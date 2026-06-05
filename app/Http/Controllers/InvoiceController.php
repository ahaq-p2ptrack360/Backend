<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail; // Agar PDF package install hai to
use Illuminate\Support\Facades\Validator;
// use Barryvdh\DomPDF\PDF; 
// use Illuminate\Support\Facades\Log; 

class InvoiceController extends Controller
{
    public function index($companyId)
    {
        try {
            $invoices = Invoice::where('company_id', $companyId)
                ->orderBy('invoice_month', 'desc')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($invoice) {
                    return [
                        'id' => $invoice->id,
                        'invoice_number' => $invoice->invoice_number,
                        'amount' => (float) $invoice->amount,
                        'sub_total' => (float) ($invoice->sub_total ?? 0),
                        'tax_amount' => (float) ($invoice->tax_amount ?? 0),
                        'discount_amount' => (float) ($invoice->discount_amount ?? 0),
                        'currency' => $invoice->currency ?? 'USD',
                        'status' => $invoice->status,
                        'status_badge' => $this->getStatusBadge($invoice->status),
                        'status_text' => ucfirst($invoice->status),
                        'invoice_date' => $invoice->invoice_date->format('d M, Y'),
                        'due_date' => $invoice->due_date->format('d M, Y'),
                        'invoice_month' => $invoice->invoice_month ? $invoice->invoice_month->format('F Y') : null,
                        'paid_amount' => (float) ($invoice->paid_amount ?? 0),
                        'remaining' => (float) ($invoice->amount - ($invoice->paid_amount ?? 0)),
                        'project_name' => $invoice->project_name,
                        'company_name' => $invoice->company->name ?? null,
                        'is_overdue' => ($invoice->status === 'overdue' ||
                            ($invoice->status === 'pending' && $invoice->due_date < now())),
                        'created_at' => $invoice->created_at->format('d M, Y'),
                    ];
                });

            return response()->json([
                'success' => true,
                'data' => $invoices,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch invoices',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'required|integer|exists:company,id',
            'subscription_id' => 'nullable|integer',
            'project_name' => 'nullable|string|max:255',
            'invoice_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:invoice_date',
            'amount' => 'required|numeric|min:0',
            'sub_total' => 'required|numeric|min:0',
            'tax_amount' => 'required|numeric|min:0',
            'discount_amount' => 'required|numeric|min:0',
            'currency' => 'required|string|size:3',
            'status' => 'sometimes|in:pending,paid,overdue,cancelled,draft',
            'paid_amount' => 'sometimes|numeric|min:0',
            'paid_date' => 'nullable|date',
            'payment_method' => 'nullable|string',
            'transaction_id' => 'nullable|string',
            'bank_account' => 'nullable|string',
            'payment_details' => 'nullable|string',
            'billing_address' => 'nullable|string',
            'items' => 'sometimes|array',
            'items.*.name' => 'required_with:items|string',
            'items.*.quantity' => 'required_with:items|numeric|min:0',
            'items.*.unit_price' => 'required_with:items|numeric|min:0',
            'items.*.tax' => 'nullable|numeric|min:0|max:100',
            'items.*.amount' => 'nullable|numeric|min:0',
            'items.*.description' => 'nullable|string',
            'invoice_month' => 'sometimes|date',
            'notes' => 'nullable|string',
            'terms' => 'nullable|string',
            'generated_by' => 'nullable|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $invoice = new Invoice();

            // Generate invoice number automatically
            $invoiceNumber = $this->generateInvoiceNumber($request->company_id);

            // Prepare data
            $invoiceData = $request->all();
            $invoiceData['invoice_number'] = $invoiceNumber;

            // Handle items JSON
            if (isset($invoiceData['items']) && is_array($invoiceData['items'])) {
                $invoiceData['items'] = json_encode($invoiceData['items']);
            }

            $invoice->fill($invoiceData);
            $invoice->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Invoice created successfully',
                'data' => $invoice,
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to create invoice',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            // 👇 IMPORTANT: with('company') HATAAO
            // $invoice = Invoice::with('company')->find($id);

            // Sirf invoice find karo, company relation load mat karo
            $invoice = Invoice::find($id);

            if (!$invoice) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invoice not found',
                ], 404);
            }

            // Company data alag se fetch karo agar chahiye to
            $company = null;
            if ($invoice->company_id) {
                // Company::withoutGlobalScopes()->find() use karo agar koi issue ho
                $company = Company::find($invoice->company_id);
            }

            // Prepare data with proper formatting
            $invoiceData = $invoice->toArray();

            // Decode items JSON
            if (isset($invoiceData['items']) && is_string($invoiceData['items'])) {
                $invoiceData['items'] = json_decode($invoiceData['items'], true);
            }

            // Ensure numeric values
            $invoiceData['amount'] = (float) ($invoice->amount ?? 0);
            $invoiceData['sub_total'] = (float) ($invoice->sub_total ?? 0);
            $invoiceData['tax_amount'] = (float) ($invoice->tax_amount ?? 0);
            $invoiceData['discount_amount'] = (float) ($invoice->discount_amount ?? 0);
            $invoiceData['paid_amount'] = (float) ($invoice->paid_amount ?? 0);

            // Add company details if needed
            if ($company) {
                $invoiceData['company'] = [
                    'id' => $company->id,
                    'name' => $company->name,
                    'email' => $company->email,
                    'address_1' => $company->address_1,
                    'address_2' => $company->address_2,
                    'city_id' => $company->city_id,
                    'state_id' => $company->state_id,
                    'country_id' => $company->country_id,
                ];

                // Format billing address
                $invoiceData['billing_address'] = $invoiceData['billing_address'] ?? $this->formatCompanyAddress($company);
            }

            return response()->json([
                'success' => true,
                'data' => $invoiceData,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch invoice',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // Helper function to format company address
    private function formatCompanyAddress($company)
    {
        $address = '';
        if ($company->address_1) {
            $address .= $company->address_1;
        }

        if ($company->address_2) {
            $address .= ($address ? ', ' : '') . $company->address_2;
        }

        if ($company->city_id) {
            $address .= ($address ? ', ' : '') . $company->city_id;
        }

        if ($company->state_id) {
            $address .= ($address ? ', ' : '') . $company->state_id;
        }

        if ($company->country_id) {
            $address .= ($address ? ', ' : '') . $company->country_id;
        }

        return $address;
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'invoice_number' => 'sometimes|string|unique:invoices,invoice_number,' . $id,
            'subscription_id' => 'nullable|integer',
            'project_name' => 'nullable|string|max:255',
            'invoice_date' => 'sometimes|date',
            'due_date' => 'sometimes|date|after_or_equal:invoice_date',
            'amount' => 'sometimes|numeric|min:0',
            'sub_total' => 'sometimes|numeric|min:0',
            'tax_amount' => 'sometimes|numeric|min:0',
            'discount_amount' => 'sometimes|numeric|min:0',
            'currency' => 'sometimes|string|size:3',
            'status' => 'sometimes|in:pending,paid,overdue,cancelled,draft',
            'paid_amount' => 'sometimes|numeric|min:0',
            'paid_date' => 'nullable|date',
            'payment_method' => 'nullable|string',
            'transaction_id' => 'nullable|string',
            'bank_account' => 'nullable|string',
            'payment_details' => 'nullable|string',
            'billing_address' => 'nullable|string',
            'items' => 'sometimes|array',
            'items.*.name' => 'required_with:items|string',
            'items.*.quantity' => 'required_with:items|numeric|min:0',
            'items.*.unit_price' => 'required_with:items|numeric|min:0',
            'items.*.tax' => 'nullable|numeric|min:0|max:100',
            'items.*.amount' => 'nullable|numeric|min:0',
            'items.*.description' => 'nullable|string',
            'invoice_month' => 'sometimes|date',
            'notes' => 'nullable|string',
            'terms' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $invoice = Invoice::findOrFail($id);

            // Get data to update
            $updateData = $request->only([
                'invoice_number',
                'subscription_id',
                'project_name',
                'invoice_date',
                'due_date',
                'amount',
                'sub_total',
                'tax_amount',
                'discount_amount',
                'currency',
                'status',
                'paid_amount',
                'paid_date',
                'payment_method',
                'transaction_id',
                'bank_account',
                'payment_details',
                'billing_address',
                'notes',
                'terms',
                'invoice_month',
            ]);

            // Handle items JSON
            if ($request->has('items')) {
                $updateData['items'] = json_encode($request->items);
            }

            $invoice->fill($updateData);

            // Auto-update status based on payment
            if ($request->has('paid_amount') && $invoice->paid_amount >= $invoice->amount) {
                $invoice->status = 'paid';
            }

            $invoice->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Invoice updated successfully',
                'data' => $invoice,
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to update invoice',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * View Invoice in Browser - HTML Page
     */
    public function view($id)
    {
        try {
            $invoice = Invoice::with('company')->findOrFail($id);
            $company = $invoice->company;

            // Calculate amounts
            $remaining = $invoice->amount - ($invoice->paid_amount ?? 0);

            // Get currency symbol
            $currencySymbol = $this->getCurrencySymbol($invoice->currency ?? 'USD');

            // Get items from database
            $items = [];
            if ($invoice->items) {
                $items = is_string($invoice->items) ? json_decode($invoice->items, true) : $invoice->items;
            }

            // ===== FIXED: iinv-img.jpg USE KARO =====
            $logoHtml = '';

// Pehle storage path check karo (direct)
            $logoPath = storage_path('app/public/upload/logo.png');

// Agar direct storage path se image mil gayi to base64 use karo
            if (file_exists($logoPath)) {
                // Image ko base64 mein convert karo (yeh har haal mein kaam karega)
                $imageData = base64_encode(file_get_contents($logoPath));
                $imageSrc = 'data:image/png;base64,' . $imageData;

                $logoHtml = '<img src="' . $imageSrc . '" alt="Company Logo" style="height: 80px; width: auto; filter: brightness(0) invert(1);">';
            }
// Agar base64 se na mile to public storage link try karo
            else {
                $publicPath = public_path('storage/upload/logo.png');
                if (file_exists($publicPath)) {
                    $logoSrc = asset('storage/upload/logo.png');
                    $logoHtml = '<img src="' . $logoSrc . '" alt="Company Logo" style="height: 80px; width: auto; filter: brightness(0) invert(1);">';
                } else {
                    // Agar image nahi mili toh fallback
                    $logoHtml = '<div style="background: white; color: #1a237e; padding: 10px 20px; border-radius: 8px; font-weight: bold; font-size: 24px;">LOGO</div>';
                }
            }

            // Simple HTML page for viewing
            $html = '<!DOCTYPE html>';
            $html .= '<html><head>';
            $html .= '<meta charset="UTF-8">';
            $html .= '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
            $html .= '<title>Invoice #' . $invoice->invoice_number . '</title>';
            $html .= '<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">';
            $html .= '<style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            body {
                font-family: Arial, sans-serif;
                background: #f5f5f5;
                padding: 20px;
            }
            .invoice-container {
                max-width: 900px;
                margin: 0 auto;
                background: white;
                border-radius: 10px;
                box-shadow: 0 5px 20px rgba(0,0,0,0.1);
                overflow: hidden;
            }
            .header {
                background: linear-gradient(135deg, #1a237e, #0d47a1);
                color: white;
                padding: 25px 30px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .header-left {
                display: flex;
                align-items: center;
                gap: 20px;
            }
            .invoice-title {
                margin: 0;
                font-size: 32px;
                font-weight: 700;
            }
            .invoice-number-header {
                margin: 5px 0 0;
                font-size: 14px;
                opacity: 0.9;
            }
            .content {
                padding: 30px;
            }
            .company-row {
                display: flex;
                justify-content: space-between;
                margin-bottom: 25px;
                padding-bottom: 20px;
                border-bottom: 1px solid #eee;
            }
            .company-info h2 {
                color: #1a237e;
                font-size: 22px;
                margin-bottom: 8px;
            }
            .company-info p {
                color: #666;
                margin: 3px 0;
                font-size: 13px;
                line-height: 1.5;
            }
            .invoice-info {
                text-align: right;
            }
            .invoice-info .number {
                color: #1a237e;
                font-size: 16px;
                font-weight: 700;
                margin-bottom: 5px;
            }
            .invoice-info .date {
                color: #666;
                margin: 2px 0;
                font-size: 13px;
            }
            .status-badge {
                display: inline-block;
                padding: 4px 12px;
                border-radius: 20px;
                font-size: 12px;
                font-weight: 600;
                margin-top: 5px;
            }
            .status-paid { background: #10b981; color: white; }
            .status-pending { background: #f59e0b; color: white; }
            .status-overdue { background: #ef4444; color: white; }
            .status-cancelled { background: #6c757d; color: white; }
            .status-draft { background: #6c757d; color: white; }

            .bill-box {
                background: #f8fafc;
                padding: 15px 20px;
                border-radius: 8px;
                margin-bottom: 25px;
                border-left: 3px solid #1a237e;
            }
            .bill-box h3 {
                color: #1a237e;
                font-size: 14px;
                margin-bottom: 10px;
                text-transform: uppercase;
            }
            .bill-box p {
                color: #444;
                margin: 3px 0;
                font-size: 13px;
            }

            table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
                border: 1px solid #ddd;
                border-radius: 8px;
                overflow: hidden;
            }
            th {
                background: #1a237e;
                color: white;
                padding: 10px;
                font-size: 13px;
                text-align: left;
            }
            td {
                padding: 10px;
                border-bottom: 1px solid #eee;
                font-size: 13px;
            }
            tr:last-child td {
                border-bottom: none;
            }

            .bank-box {
                background: #f8fafc;
                padding: 15px 20px;
                border-radius: 8px;
                margin: 20px 0;
                border: 1px solid #ddd;
            }
            .bank-box h4 {
                color: #1a237e;
                margin-bottom: 8px;
                font-size: 14px;
            }
            .bank-box p {
                color: #444;
                margin: 3px 0;
                font-size: 13px;
            }

            .summary-box {
                background: #f8fafc;
                padding: 15px 20px;
                border-radius: 8px;
                max-width: 350px;
                margin-left: auto;
                border: 1px solid #ddd;
            }
            .summary-row {
                display: flex;
                justify-content: space-between;
                padding: 5px 0;
                border-bottom: 1px dashed #ddd;
            }
            .summary-row:last-child {
                border-bottom: none;
            }
            .total {
                font-weight: 700;
                color: #1a237e;
            }
            .due {
                color: #ef4444;
                font-weight: 700;
            }

            .note-box {
                background: #fff3cd;
                padding: 10px 15px;
                border-left: 3px solid #f59e0b;
                border-radius: 5px;
                margin: 20px 0;
                font-size: 13px;
            }

            .footer {
                background: #f8fafc;
                padding: 15px;
                text-align: center;
                border-top: 1px solid #ddd;
                font-size: 12px;
                color: #666;
            }

            .buttons {
                text-align: center;
                margin: 20px 0;
            }
            .btn {
                padding: 8px 20px;
                border: none;
                border-radius: 5px;
                font-size: 13px;
                font-weight: 600;
                cursor: pointer;
                display: inline-flex;
                align-items: center;
                gap: 5px;
                margin: 0 5px;
            }
            .btn-primary {
                background: #1a237e;
                color: white;
            }
            .btn-primary:hover {
                background: #0d47a1;
            }
            .btn-secondary {
                background: #6c757d;
                color: white;
            }
            .btn-secondary:hover {
                background: #5a6268;
            }
        </style>';
            $html .= '</head><body>';

            $html .= '<div class="invoice-container">';

            // ===== HEADER WITH LOGO (iinv-img.jpg) =====
            $html .= '<div class="header">';
            $html .= '<div class="header-left">';
            $html .= '<div>';
            $html .= '<h1 class="invoice-title">INVOICE</h1>';
            $html .= '<p class="invoice-number-header">#' . $invoice->invoice_number . '</p>';
            $html .= '</div>';
            $html .= '</div>';

            // Right side - Date
            $html .= '<div style="text-align: right;">';
            // $html .= '<p style="margin: 0; font-size: 14px;">' . now()->format('d M, Y') . '</p>';
            $html .= $logoHtml;
            $html .= '</div>';
            $html .= '</div>'; // Close header

            // Content
            $html .= '<div class="content">';

            // Company Info
            $statusClass = 'status-pending';
            if ($invoice->status == 'paid') {
                $statusClass = 'status-paid';
            }

            if ($invoice->status == 'overdue') {
                $statusClass = 'status-overdue';
            }

            if ($invoice->status == 'cancelled') {
                $statusClass = 'status-cancelled';
            }

            if ($invoice->status == 'draft') {
                $statusClass = 'status-draft';
            }

            $html .= '<div class="company-row">';
            $html .= '<div class="company-info">';
            $html .= '<h2>' . ($company->name ?? 'Company Name') . '</h2>';
            $html .= '<p>' . ($company->address_1 ?? '') . '</p>';
            $html .= '<p>' . ($company->city_id ?? '') . ' ' . ($company->state_id ?? '') . ' ' . ($company->country_id ?? '') . '</p>';
            $html .= '<p>Email: ' . ($company->email ?? '') . '</p>';
            $html .= '<p>Phone: ' . ($company->telephon ?? '') . '</p>';
            $html .= '</div>';
            $html .= '<div class="invoice-info">';
            $html .= '<div class="number">INVOICE #' . $invoice->invoice_number . '</div>';
            $html .= '<div class="date">Date: ' . $invoice->invoice_date->format('d M, Y') . '</div>';
            $html .= '<div class="date">Due: ' . $invoice->due_date->format('d M, Y') . '</div>';
            $html .= '<div class="status-badge ' . $statusClass . '">' . ucfirst($invoice->status) . '</div>';
            $html .= '</div>';
            $html .= '</div>';

            // Bill To
            $html .= '<div class="bill-box">';
            $html .= '<h3>BILL TO</h3>';
            $html .= '<p><strong>' . ($company->name ?? 'Client Name') . '</strong></p>';
            $html .= '<p>' . ($company->address_1 ?? '') . '</p>';
            $html .= '<p>' . ($company->city_id ?? '') . ' ' . ($company->state_id ?? '') . ' ' . ($company->country_id ?? '') . '</p>';
            $html .= '<p>Email: ' . ($company->email ?? '') . '</p>';
            if ($invoice->project_name) {
                $html .= '<p><strong>Project:</strong> ' . $invoice->project_name . '</p>';
            }
            $html .= '</div>';

            // Items Table
            if (!empty($items)) {
                $html .= '<table>';
                $html .= '<thead><tr>';
                $html .= '<th>DESCRIPTION</th>';
                $html .= '<th>QTY</th>';
                $html .= '<th>UNIT PRICE</th>';
                $html .= '<th>TAX</th>';
                $html .= '<th>AMOUNT</th>';
                $html .= '</tr></thead><tbody>';

                foreach ($items as $item) {
                    $itemName = $item['name'] ?? $item['description'] ?? 'Item';
                    $quantity = $item['quantity'] ?? 1;
                    $unitPrice = $item['unit_price'] ?? 0;
                    $tax = $item['tax'] ?? 0;
                    $amount = $item['amount'] ?? ($quantity * $unitPrice);

                    $html .= '<tr>';
                    $html .= '<td>' . htmlspecialchars($itemName) . '</td>';
                    $html .= '<td>' . $quantity . '</td>';
                    $html .= '<td>' . $currencySymbol . number_format($unitPrice, 2) . '</td>';
                    $html .= '<td>' . $tax . '%</td>';
                    $html .= '<td><strong>' . $currencySymbol . number_format($amount, 2) . '</strong></td>';
                    $html .= '</tr>';
                }

                $html .= '</tbody></table>';
            }

            // Bank Details
            if ($invoice->bank_account || $invoice->payment_details) {
                $html .= '<div class="bank-box">';
                $html .= '<h4>Bank Details</h4>';
                if ($invoice->bank_account) {
                    $html .= '<p><strong>Account:</strong> ' . $invoice->bank_account . '</p>';
                }
                if ($invoice->payment_details) {
                    $html .= '<p><strong>Details:</strong> ' . nl2br(htmlspecialchars($invoice->payment_details)) . '</p>';
                }
                $html .= '</div>';
            }

            // Summary
            $subtotal = $invoice->sub_total ?? $invoice->amount;
            $taxAmount = $invoice->tax_amount ?? 0;
            $discount = $invoice->discount_amount ?? 0;
            $total = $invoice->amount;

            $html .= '<div class="summary-box">';
            $html .= '<div class="summary-row"><span>Subtotal:</span> <span>' . $currencySymbol . number_format($subtotal, 2) . '</span></div>';

            if ($taxAmount > 0) {
                $html .= '<div class="summary-row"><span>Tax:</span> <span>' . $currencySymbol . number_format($taxAmount, 2) . '</span></div>';
            }

            if ($discount > 0) {
                $html .= '<div class="summary-row"><span>Discount:</span> <span>-' . $currencySymbol . number_format($discount, 2) . '</span></div>';
            }

            $html .= '<div class="summary-row total"><span>TOTAL:</span> <span>' . $currencySymbol . number_format($total, 2) . '</span></div>';

            if ($remaining > 0) {
                $html .= '<div class="summary-row due"><span>AMOUNT DUE:</span> <span>' . $currencySymbol . number_format($remaining, 2) . '</span></div>';
            }
            $html .= '</div>';

            // Notes
            if ($invoice->notes) {
                $html .= '<div class="note-box">';
                $html .= '<strong>Notes:</strong><br>' . nl2br(htmlspecialchars($invoice->notes));
                $html .= '</div>';
            }

            $html .= '</div>'; // Close content

            // Buttons
            $html .= '<div class="buttons">';
            $html .= '<button class="btn btn-primary" onclick="window.print()">';
            $html .= '<i class="bi bi-printer"></i> Print Invoice';
            $html .= '</button>';
            $html .= '<button class="btn btn-secondary" onclick="window.close()">';
            $html .= '<i class="bi bi-x-lg"></i> Close';
            $html .= '</button>';
            $html .= '</div>';

            // Footer
            $html .= '<div class="footer">';
            $html .= '<p>Thank you for your business!</p>';
            $html .= '</div>';

            $html .= '</div>'; // Close invoice-container
            $html .= '</body></html>';

            return response($html, 200)
                ->header('Content-Type', 'text/html');

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to view invoice',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
/**
 * Download Invoice as PDF 
 */
// public function downloadPdf($id)
// {
//     try {
//         $invoice = Invoice::with('company')->findOrFail($id);
//         $company = $invoice->company;

//         // Calculate amounts
//         $remaining = $invoice->amount - ($invoice->paid_amount ?? 0);

//         // Get currency symbol
//         $currencySymbol = $this->getCurrencySymbol($invoice->currency ?? 'USD');

//         // Get items from database (JSON se decode karo)
//         $items = [];
//         if ($invoice->items) {
//             $items = is_string($invoice->items) ? json_decode($invoice->items, true) : $invoice->items;
//         }

//         // Agar items empty hain to default empty array
//         if (empty($items)) {
//             $items = [];
//         }

//         // ===== PDF KE LIYE LOGO BASE64 MEIN CONVERT KARO =====
// $logoHtml = '';
// $logoPath = storage_path('app/public/upload/logo.png');

// if (file_exists($logoPath)) {
//     try {
//         // Image ko manipulate karo - white color mein convert karo
//         $imageInfo = getimagesize($logoPath);
//         $extension = pathinfo($logoPath, PATHINFO_EXTENSION);
        
//         // Source image create karo
//         if ($extension == 'jpg' || $extension == 'jpeg') {
//             $sourceImage = imagecreatefromjpeg($logoPath);
//         } elseif ($extension == 'png') {
//             $sourceImage = imagecreatefrompng($logoPath);
//         } else {
//             // Unsupported format, fallback to CSS filter
//             $imageData = base64_encode(file_get_contents($logoPath));
//             $mimeType = ($extension == 'jpg' || $extension == 'jpeg') ? 'jpeg' : 'png';
//             $imageSrc = 'data:image/' . $mimeType . ';base64,' . $imageData;
            
//             $logoHtml = '<div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">';
//             $logoHtml .= '<h1 style="margin: 0; font-size: 42px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; color: white;">INVOICE</h1>';
//             $logoHtml .= '<img src="' . $imageSrc . '" alt="Company Logo" style="height: 70px; width: auto;">';
//             $logoHtml .= '</div>';
            
//             return $logoHtml;
//         }
        
//         // White image create karo
//         $width = imagesx($sourceImage);
//         $height = imagesy($sourceImage);
        
//         // Transparent background ke saath new image create karo
//         $whiteImage = imagecreatetruecolor($width, $height);
        
//         // Transparency enable karo for PNG
//         imagealphablending($whiteImage, false);
//         imagesavealpha($whiteImage, true);
        
//         // Pure white color fill karo (alpha ke saath)
//         $white = imagecolorallocatealpha($whiteImage, 255, 255, 255, 0);
//         imagefill($whiteImage, 0, 0, $white);
        
//         // Original image ke alpha channel ko preserve karte hue white apply karo
//         for ($x = 0; $x < $width; $x++) {
//             for ($y = 0; $y < $height; $y++) {
//                 $rgb = imagecolorat($sourceImage, $x, $y);
//                 $r = ($rgb >> 16) & 0xFF;
//                 $g = ($rgb >> 8) & 0xFF;
//                 $b = $rgb & 0xFF;
                
//                 // Grayscale calculate karo
//                 $gray = ($r + $g + $b) / 3;
                
//                 // Alpha channel preserve karo (PNG ke liye)
//                 if ($extension == 'png') {
//                     $alpha = ($rgb >> 24) & 0x7F;
//                     $color = imagecolorallocatealpha($whiteImage, 255, 255, 255, $alpha);
//                 } else {
//                     // JPG ke liye opacity based on brightness
//                     $opacity = 127 - (($gray / 255) * 127);
//                     $color = imagecolorallocatealpha($whiteImage, 255, 255, 255, $opacity);
//                 }
                
//                 imagesetpixel($whiteImage, $x, $y, $color);
//             }
//         }
        
//         // Output buffering start karo
//         ob_start();
        
//         // White image ko PNG format mein output karo
//         imagepng($whiteImage);
//         $imageData = ob_get_clean();
        
//         // Memory free karo
//         imagedestroy($sourceImage);
//         imagedestroy($whiteImage);
        
//         // Base64 encode karo
//         $base64Image = base64_encode($imageData);
//         $imageSrc = 'data:image/png;base64,' . $base64Image;
        
//         // Logo HTML with white image
//         $logoHtml = '<div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">';
//         $logoHtml .= '<h1 style="margin: 0; font-size: 42px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; color: white;">INVOICE</h1>';
//         $logoHtml .= '<img src="' . $imageSrc . '" alt="Company Logo" style="height: 80px; width: auto;">';
//         $logoHtml .= '</div>';
        
//     } catch (\Exception $e) {
//         // Agar image manipulation fail ho jaye to fallback
//         $imageData = base64_encode(file_get_contents($logoPath));
//         $mimeType = ($extension == 'jpg' || $extension == 'jpeg') ? 'jpeg' : 'png';
//         $imageSrc = 'data:image/' . $mimeType . ';base64,' . $imageData;
        
//         $logoHtml = '<div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">';
//         $logoHtml .= '<h1 style="margin: 0; font-size: 42px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; color: white;">INVOICE</h1>';
//         $logoHtml .= '<img src="' . $imageSrc . '" alt="Company Logo" style="height: 80px; width: auto;">';
//         $logoHtml .= '</div>';
//     }
    
// } else {
//     // Agar image nahi mili toh fallback - Right side pe text
//     $logoHtml = '<div style="display: flex; justify-content: space-between; align-items: center; width: 100%;">';
//     $logoHtml .= '<h1 style="margin: 0; font-size: 42px; font-weight: 800; letter-spacing: 2px; text-transform: uppercase; color: white;">INVOICE</h1>';
//     $logoHtml .= '<span style="color: white; font-weight: bold; font-size: 24px;">LOGO</span>';
//     $logoHtml .= '</div>';
// }

//         // Bill Gates Style HTML with REAL DATA
//         $html = '<!DOCTYPE html>';
//         $html .= '<html><head>';
//         $html .= '<meta charset="UTF-8">';
//         $html .= '<title>Invoice #' . $invoice->invoice_number . '</title>';
//         $html .= '<style>';
//         $html .= '
//         .invoice-wrapper {
//             max-width: 900px;
//             margin: 0 auto;
//             background: white;
//             border-radius: 15px;
//             box-shadow: 0 10px 30px rgba(0,0,0,0.1);
//             overflow: hidden;
//         }
//         .invoice-header {
//             background: linear-gradient(135deg, #1a237e, #0d47a1);
//             color: white;
//             padding: 40px 50px;
//         }
//         .invoice-header p {
//             font-size: 18px;
//             opacity: 0.9;
//             margin-top: 1opx;
//             color: rgba(255,255,255,0.9);
//         }
//         .invoice-body {
//             padding: 50px;
//         }
//         .company-section {
//             display: flex;
//             justify-content: space-between;
//             margin-bottom: 40px;
//             padding-bottom: 30px;
//             border-bottom: 2px solid #f0f0f0;
//         }
//         .company-details h2 {
//             color: #1a237e;
//             font-size: 24px;
//             margin-bottom: 10px;
//             font-weight: 700;
//         }
//         .company-details p {
//             color: #666;
//             line-height: 1.6;
//             margin: 5px 0;
//             font-size: 14px;
//         }
//         .invoice-details {
//             text-align: right;
//         }
//         .invoice-details .invoice-number {
//             color: #1a237e;
//             font-size: 20px;
//             font-weight: 700;
//             margin-bottom: 10px;
//         }
//         .invoice-details .invoice-date {
//             color: #666;
//             margin: 5px 0;
//             font-size: 14px;
//         }
//         .invoice-details .status-badge {
//             display: inline-block;
//             padding: 6px 20px;
//             border-radius: 50px;
//             font-size: 14px;
//             font-weight: 600;
//             margin-top: 10px;
//             text-transform: uppercase;
//         }
//         .status-paid { background: #10b981; color: white; }
//         .status-pending { background: #f59e0b; color: white; }
//         .status-overdue { background: #ef4444; color: white; }
//         .status-cancelled { background: #6c757d; color: white; }
//         .status-draft { background: #6c757d; color: white; }

//         .bill-to-section {
//             margin-bottom: 40px;
//             padding: 25px;
//             background: #f8fafc;
//             border-radius: 10px;
//         }
//         .bill-to-section h3 {
//             color: #1a237e;
//             font-size: 16px;
//             margin-bottom: 15px;
//             text-transform: uppercase;
//             letter-spacing: 1px;
//             font-weight: 700;
//         }
//         .bill-to-section p {
//             color: #444;
//             line-height: 1.6;
//             margin: 5px 0;
//             font-size: 14px;
//         }

//         .items-table {
//             width: 100%;
//             border-collapse: collapse;
//             margin: 30px 0;
//         }
//         .items-table th {
//             background: #1a237e;
//             color: white;
//             padding: 15px;
//             text-align: left;
//             font-size: 14px;
//             font-weight: 600;
//             text-transform: uppercase;
//             letter-spacing: 0.5px;
//         }
//         .items-table td {
//             padding: 15px;
//             border-bottom: 1px solid #e5e7eb;
//             color: #444;
//             font-size: 14px;
//         }
//         .items-table tbody tr:hover {
//             background: #f8fafc;
//         }
//         .items-table .amount {
//             font-weight: 700;
//             color: #1a237e;
//         }

//         .summary-section {
//             margin-top: 40px;
//             padding-top: 30px;
//             border-top: 2px solid #f0f0f0;
//             text-align: right;
//         }
//         .summary-row {
//             display: flex;
//             justify-content: flex-end;
//             align-items: center;
//             margin: 10px 0;
//         }
//         .summary-label {
//             width: 150px;
//             color: #666;
//             font-size: 16px;
//             font-weight: 500;
//         }
//         .summary-value {
//             width: 200px;
//             font-weight: 600;
//             color: #1a237e;
//             font-size: 18px;
//             text-align: right;
//         }
//         .total-row {
//             margin-top: 20px;
//             padding-top: 20px;
//             border-top: 2px solid #1a237e;
//         }
//         .total-label {
//             color: #1a237e;
//             font-size: 20px;
//             font-weight: 800;
//         }
//         .total-value {
//             color: #1a237e;
//             font-size: 28px;
//             font-weight: 800;
//         }
//         .total-due {
//             color: #ef4444;
//             font-size: 24px;
//             font-weight: 800;
//             margin-top: 15px;
//         }

//         .bank-details {
//             margin-top: 30px;
//             padding: 20px;
//             background: #f8fafc;
//             border-radius: 10px;
//             font-size: 14px;
//         }
//         .bank-details h4 {
//             color: #1a237e;
//             margin-bottom: 10px;
//             font-size: 16px;
//         }
//         .bank-details p {
//             color: #666;
//             margin: 5px 0;
//         }

//         .notes-section {
//             margin-top: 30px;
//             padding: 20px;
//             background: #fff3cd;
//             border-left: 4px solid #f59e0b;
//             border-radius: 5px;
//             font-size: 14px;
//         }
//         .notes-section h4 {
//             color: #856404;
//             margin-bottom: 10px;
//             font-size: 16px;
//         }
//         .notes-section p {
//             color: #856404;
//             margin: 0;
//             white-space: pre-line;
//         }

//         .terms-section {
//             margin-top: 20px;
//             padding: 20px;
//             background: #f8fafc;
//             border-radius: 10px;
//             font-size: 13px;
//             color: #666;
//         }
//         .terms-section h4 {
//             color: #1a237e;
//             margin-bottom: 10px;
//             font-size: 15px;
//         }
//         .terms-section p {
//             margin: 0;
//             white-space: pre-line;
//         }

//         .footer {
//             background: #f8fafc;
//             padding: 30px 50px;
//             text-align: center;
//             border-top: 1px solid #e5e7eb;
//         }
//         .footer p {
//             color: #666;
//             font-size: 14px;
//             margin: 5px 0;
//         }
//         .footer .thank-you {
//             color: #1a237e;
//             font-size: 18px;
//             font-weight: 600;
//             margin-bottom: 10px;
//         }

//         .currency {
//             font-size: 14px;
//             color: #666;
//             margin-left: 5px;
//         }

//         @media print {
//             body { background: white; padding: 0; }
//             .invoice-wrapper { box-shadow: none; }
//         }
//     ';
//         $html .= '</style>';
//         $html .= '</head><body>';

//         $html .= '<div class="invoice-wrapper">';

//         // ===== HEADER WITH LOGO ON RIGHT SIDE =====
//         $html .= '<div class="invoice-header">';
//         $html .= $logoHtml; // Yahan logo right side pe + white color + bada height
//         $html .= '<p>#' . $invoice->invoice_number . '</p>';
//         $html .= '</div>';

//         // ===== BODY =====
//         $html .= '<div class="invoice-body">';

//         // ----- Company Section -----
//         $html .= '<div class="company-section">';
//         $html .= '<div class="company-details">';
//         $html .= '<h2>' . ($company->name ?? 'Your Company Name') . '</h2>';
//         $html .= '<p>' . ($company->address_1 ?? '') . '</p>';
//         $html .= '<p>' . ($company->city_id ?? '') . ' ' . ($company->state_id ?? '') . ' ' . ($company->country_id ?? '') . '</p>';
//         $html .= '<p>Email: ' . ($company->email ?? '') . '</p>';
//         $html .= '<p>Phone: ' . ($company->telephon ?? '') . '</p>';
//         $html .= '</div>';

//         $statusClass = 'status-pending';
//         if ($invoice->status == 'paid') {
//             $statusClass = 'status-paid';
//         }

//         if ($invoice->status == 'overdue') {
//             $statusClass = 'status-overdue';
//         }

//         if ($invoice->status == 'cancelled') {
//             $statusClass = 'status-cancelled';
//         }

//         if ($invoice->status == 'draft') {
//             $statusClass = 'status-draft';
//         }

//         $html .= '<div class="invoice-details">';
//         $html .= '<div class="invoice-number">INVOICE #' . $invoice->invoice_number . '</div>';
//         $html .= '<div class="invoice-date">Date: ' . $invoice->invoice_date->format('d M, Y') . '</div>';
//         $html .= '<div class="invoice-date">Due Date: ' . $invoice->due_date->format('d M, Y') . '</div>';
//         $html .= '<div class="status-badge ' . $statusClass . '">' . ucfirst($invoice->status) . '</div>';
//         $html .= '</div>';
//         $html .= '</div>';

//         // ----- Bill To Section -----
//         $html .= '<div class="bill-to-section">';
//         $html .= '<h3>BILL TO</h3>';
//         $html .= '<p>' . ($company->name ?? 'Client Name') . '</p>';
//         $html .= '<p>' . ($company->address_1 ?? '') . '</p>';
//         $html .= '<p>' . ($company->city_id ?? '') . ' ' . ($company->state_id ?? '') . ' ' . ($company->country_id ?? '') . '</p>';
//         $html .= '<p>Email: ' . ($company->email ?? '') . '</p>';
//         if ($invoice->project_name) {
//             $html .= '<p>Project: ' . $invoice->project_name . '</p>';
//         }
//         $html .= '</div>';

//         // ----- Items Table -----
//         if (!empty($items)) {
//             $html .= '<table class="items-table">';
//             $html .= '<thead>';
//             $html .= '<tr>';
//             $html .= '<th>DESCRIPTION</th>';
//             $html .= '<th>QUANTITY</th>';
//             $html .= '<th>UNIT PRICE (' . $currencySymbol . ')</th>';
//             $html .= '<th>TAX</th>';
//             $html .= '<th>AMOUNT (' . $currencySymbol . ')</th>';
//             $html .= '</tr>';
//             $html .= '</thead>';
//             $html .= '<tbody>';

//             foreach ($items as $item) {
//                 $itemName = $item['name'] ?? $item['description'] ?? 'Item';
//                 $quantity = $item['quantity'] ?? 1;
//                 $unitPrice = $item['unit_price'] ?? 0;
//                 $tax = $item['tax'] ?? 0;
//                 $amount = $item['amount'] ?? ($quantity * $unitPrice);

//                 $html .= '<tr>';
//                 $html .= '<td>' . htmlspecialchars($itemName) . '</td>';
//                 $html .= '<td>' . $quantity . '</td>';
//                 $html .= '<td>' . $currencySymbol . number_format($unitPrice, 2) . '</td>';
//                 $html .= '<td>' . $tax . '%</td>';
//                 $html .= '<td class="amount">' . $currencySymbol . number_format($amount, 2) . '</td>';
//                 $html .= '</tr>';
//             }

//             $html .= '</tbody>';
//             $html .= '</table>';
//         } else {
//             $html .= '<p style="text-align: center; padding: 20px; color: #999;">No items in this invoice</p>';
//         }

//         // ----- Bank Details (if available) -----
//         if ($invoice->bank_account || $invoice->payment_details) {
//             $html .= '<div class="bank-details">';
//             $html .= '<h4>Bank Details</h4>';
//             if ($invoice->bank_account) {
//                 $html .= '<p><strong>Account:</strong> ' . $invoice->bank_account . '</p>';
//             }
//             if ($invoice->payment_details) {
//                 $html .= '<p><strong>Details:</strong> ' . nl2br(htmlspecialchars($invoice->payment_details)) . '</p>';
//             }
//             $html .= '</div>';
//         }

//         // ----- Summary Section -----
//         $subtotal = $invoice->sub_total ?? $invoice->amount;
//         $taxAmount = $invoice->tax_amount ?? 0;
//         $discount = $invoice->discount_amount ?? 0;
//         $total = $invoice->amount;

//         $html .= '<div class="summary-section">';
//         $html .= '<div class="summary-row">';
//         $html .= '<span class="summary-label">Subtotal:</span>';
//         $html .= '<span class="summary-value">' . $currencySymbol . number_format($subtotal, 2) . '</span>';
//         $html .= '</div>';

//         if ($taxAmount > 0) {
//             $html .= '<div class="summary-row">';
//             $html .= '<span class="summary-label">Tax:</span>';
//             $html .= '<span class="summary-value">' . $currencySymbol . number_format($taxAmount, 2) . '</span>';
//             $html .= '</div>';
//         }

//         if ($discount > 0) {
//             $html .= '<div class="summary-row">';
//             $html .= '<span class="summary-label">Discount:</span>';
//             $html .= '<span class="summary-value">-' . $currencySymbol . number_format($discount, 2) . '</span>';
//             $html .= '</div>';
//         }

//         $html .= '<div class="summary-row total-row">';
//         $html .= '<span class="summary-label total-label">TOTAL:</span>';
//         $html .= '<span class="summary-value total-value">' . $currencySymbol . number_format($total, 2) . '</span>';
//         $html .= '</div>';

//         if ($remaining > 0) {
//             $html .= '<div class="summary-row">';
//             $html .= '<span class="summary-label total-label">AMOUNT DUE:</span>';
//             $html .= '<span class="summary-value total-due">' . $currencySymbol . number_format($remaining, 2) . '</span>';
//             $html .= '</div>';
//         } else if ($invoice->paid_amount > 0) {
//             $html .= '<div class="summary-row">';
//             $html .= '<span class="summary-label">Paid:</span>';
//             $html .= '<span class="summary-value" style="color: #10b981;">' . $currencySymbol . number_format($invoice->paid_amount, 2) . '</span>';
//             $html .= '</div>';
//         }

//         $html .= '</div>'; // Close summary-section

//         // ----- Notes (if available) -----
//         if ($invoice->notes) {
//             $html .= '<div class="notes-section">';
//             $html .= '<h4>Notes</h4>';
//             $html .= '<p>' . nl2br(htmlspecialchars($invoice->notes)) . '</p>';
//             $html .= '</div>';
//         }

//         // ----- Terms & Conditions (if available) -----
//         if ($invoice->terms) {
//             $html .= '<div class="terms-section">';
//             $html .= '<h4>Terms & Conditions</h4>';
//             $html .= '<p>' . nl2br(htmlspecialchars($invoice->terms)) . '</p>';
//             $html .= '</div>';
//         }

//         $html .= '</div>'; // Close invoice-body

//         // ===== FOOTER =====
//         $html .= '<div class="footer">';
//         $html .= '<p class="thank-you">Thank you for your business!</p>';
//         $html .= '<p>' . config('app.name') . ' - Generated on ' . now()->format('d M, Y H:i') . '</p>';
//         $html .= '<p>Invoice #' . $invoice->invoice_number . '</p>';
//         $html .= '</div>';

//         $html .= '</div>'; // Close invoice-wrapper
//         $html .= '</body></html>';

//         // Set headers for download
//         $headers = [
//             'Content-Type' => 'application/pdf',
//             'Content-Disposition' => 'attachment; filename="invoice-' . $invoice->invoice_number . '.pdf"',
//             'Content-Transfer-Encoding' => 'binary',
//             'Cache-Control' => 'private, no-transform, no-store, must-revalidate',
//         ];

//         return response($html, 200, $headers);

//     } catch (\Exception $e) {
//         return response()->json([
//             'success' => false,
//             'message' => 'Failed to generate invoice',
//             'error' => $e->getMessage(),
//         ], 500);
//     }
// }

private function getLogoHtml()
{
    $logoPath = storage_path('app/public/upload/logo.png');
    if (file_exists($logoPath)) {
        $imageData = base64_encode(file_get_contents($logoPath));
        return '<img src="data:image/png;base64,' . $imageData . '" style="height: 80px;">';
    }
    return '<span style="color:white;">LOGO</span>';
}

public function downloadPdf($id)
{
    try {

        $invoice = Invoice::with('company')->findOrFail($id);
        $company = $invoice->company;

        $remaining = $invoice->amount - ($invoice->paid_amount ?? 0);
        $currencySymbol = $this->getCurrencySymbol($invoice->currency ?? 'USD');

        $items = [];
        if ($invoice->items) {
            $items = is_string($invoice->items) ? json_decode($invoice->items, true) : $invoice->items;
        }

        $logoHtml = $this->getLogoHtml();

        $html = view('pdf.invoice', compact('invoice', 'company', 'items', 'remaining', 'currencySymbol', 'logoHtml'))->render();

        // ✅ Check if DomPDF exists
        if (!class_exists('\Barryvdh\DomPDF\Facade')) {
            // Fallback: HTML download
            return response($html, 200, [
                'Content-Type' => 'text/html',
                'Content-Disposition' => 'attachment; filename="invoice-' . $invoice->invoice_number . '.html"',
            ]);
        }

        // Generate PDF
        $pdf = app('dompdf.wrapper');
        $pdf->loadHTML($html);
        $pdf->setPaper('A4', 'portrait');
        
        return $pdf->download('invoice-' . $invoice->invoice_number . '.pdf');

    } catch (\Exception $e) {
        
        return response()->json([
            'success' => false,
            'message' => 'Failed to generate invoice',
            'error' => $e->getMessage()
        ], 500);
    }
}

/**
 * Get currency symbol from currency code
 */
    private function getCurrencySymbol($currency)
    {
        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'PKR' => 'Rs',
            'INR' => '₹',
            'JPY' => '¥',
            'CAD' => 'C$',
            'AUD' => 'A$',
        ];

        return $symbols[$currency] ?? '$';
    }

    public function send(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'message' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $invoice = Invoice::with('company')->findOrFail($id);

            // Simple email bhejo - NO MAIL CLASS NEEDED
            $emailMessage = $request->message ?? "Please find invoice attached.\n\n";
            $emailMessage .= "Invoice #: {$invoice->invoice_number}\n";
            $emailMessage .= "Amount: $" . number_format($invoice->amount, 2) . "\n";
            $emailMessage .= "Due Date: " . $invoice->due_date->format('d M, Y');

            Mail::raw($emailMessage, function ($message) use ($request, $invoice) {
                $message->to($request->email)
                    ->subject("Invoice #{$invoice->invoice_number}");

                // Agar current user ko bhi copy bhejni ho
                if ($request->send_copy && auth()->check()) {
                    $message->bcc(auth()->user()->email);
                }
            });

            return response()->json([
                'success' => true,
                'message' => 'Invoice sent successfully to ' . $request->email,
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Failed to send invoice',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function sendReminder(Request $request, $id)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'subject' => 'nullable|string|max:255',
            'message' => 'nullable|string',
            'send_copy' => 'sometimes|in:0,1',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            // Invoice fetch karo
            $invoice = Invoice::with('company')->findOrFail($id);

            // Check if already paid
            if ($invoice->status === 'paid') {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot send reminder for paid invoice',
                ], 400);
            }

            // Check if overdue
            $dueDate = Carbon::parse($invoice->due_date);
            $isOverdue = $invoice->status === 'overdue' ||
                ($invoice->status === 'pending' && $dueDate->isPast());

            $overdueDays = $isOverdue ? $dueDate->diffInDays(now()) : 0;
            $remaining = $invoice->amount - ($invoice->paid_amount ?? 0);

            // Prepare email subject
            $subject = $request->subject;
            if (!$subject) {
                if ($isOverdue) {
                    $subject = "⚠️ OVERDUE: Invoice #{$invoice->invoice_number} is {$overdueDays} days late";
                } else {
                    $subject = "🔔 Reminder: Invoice #{$invoice->invoice_number} is due on " .
                    $invoice->due_date->format('d M, Y');
                }
            }

            // Prepare email body (SIMPLE TEXT)
            $emailBody = $request->message ?? "";

            if (empty($emailBody)) {
                $companyName = $invoice->company->name ?? 'Customer';

                if ($isOverdue) {
                    $emailBody = "Dear {$companyName},\n\n";
                    $emailBody .= "This is an URGENT reminder that invoice #{$invoice->invoice_number} for ";
                    $emailBody .= "\$" . number_format($remaining, 2) . " was due on ";
                    $emailBody .= $invoice->due_date->format('d M, Y') . " and is now {$overdueDays} days OVERDUE.\n\n";
                    $emailBody .= "Please make the payment immediately to avoid any service interruption.\n\n";
                    $emailBody .= "Invoice Details:\n";
                    $emailBody .= "- Invoice Number: {$invoice->invoice_number}\n";
                    $emailBody .= "- Total Amount: \$" . number_format($invoice->amount, 2) . "\n";
                    $emailBody .= "- Paid Amount: \$" . number_format($invoice->paid_amount ?? 0, 2) . "\n";
                    $emailBody .= "- Remaining Amount: \$" . number_format($remaining, 2) . "\n";
                    $emailBody .= "- Due Date: " . $invoice->due_date->format('d M, Y') . "\n";
                    $emailBody .= "- Days Overdue: {$overdueDays}\n\n";
                    $emailBody .= "Thank you for your immediate attention.\n\n";
                    $emailBody .= "Best regards,\n" . config('app.name') . " Team";
                } else {
                    $emailBody = "Dear {$companyName},\n\n";
                    $emailBody .= "This is a friendly reminder that invoice #{$invoice->invoice_number} for ";
                    $emailBody .= "\$" . number_format($remaining, 2) . " is due on ";
                    $emailBody .= $invoice->due_date->format('d M, Y') . ".\n\n";
                    $emailBody .= "Please process the payment at your earliest convenience.\n\n";
                    $emailBody .= "Invoice Details:\n";
                    $emailBody .= "- Invoice Number: {$invoice->invoice_number}\n";
                    $emailBody .= "- Total Amount: \$" . number_format($invoice->amount, 2) . "\n";
                    $emailBody .= "- Paid Amount: \$" . number_format($invoice->paid_amount ?? 0, 2) . "\n";
                    $emailBody .= "- Remaining Amount: \$" . number_format($remaining, 2) . "\n";
                    $emailBody .= "- Due Date: " . $invoice->due_date->format('d M, Y') . "\n\n";
                    $emailBody .= "Thank you for your business!\n\n";
                    $emailBody .= "Best regards,\n" . config('app.name') . " Team";
                }
            }

            // Prepare recipients
            $recipients = [$request->email];

            // Send copy to authenticated user if requested
            if ($request->send_copy == 1 && auth()->check()) {
                $recipients[] = auth()->user()->email;
            }

            // Send email using Mail::raw (SIMPLE TEXT EMAIL)
            foreach ($recipients as $recipient) {
                Mail::raw($emailBody, function ($message) use ($recipient, $subject) {
                    $message->to($recipient)
                        ->subject($subject);
                });
            }


            return response()->json([
                'success' => true,
                'message' => 'Payment reminder sent successfully to ' . $request->email,
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'success' => false,
                'message' => 'Failed to send payment reminder',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function cancel($id)
    {
        try {
            DB::beginTransaction();

            $invoice = Invoice::findOrFail($id);

            if ($invoice->status === 'paid') {
                return response()->json([
                    'success' => false,
                    'message' => 'Paid invoices cannot be cancelled',
                ], 400);
            }

            $invoice->status = 'cancelled';
            $invoice->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Invoice cancelled successfully',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to cancel invoice',
            ], 500);
        }
    }

    public function markAsPaid(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'paid_amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_method' => 'nullable|string',
            'transaction_id' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            DB::beginTransaction();

            $invoice = Invoice::findOrFail($id);

            if (!in_array($invoice->status, ['pending', 'overdue'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending or overdue invoices can be marked as paid',
                ], 400);
            }

            $paidAmount = $request->paid_amount;
            $remaining = $invoice->amount - $invoice->paid_amount;

            if ($paidAmount > $remaining) {
                return response()->json([
                    'success' => false,
                    'message' => "Paid amount cannot exceed remaining amount: \${$remaining}",
                ], 400);
            }

            $invoice->paid_amount += $paidAmount;
            $invoice->paid_date = Carbon::parse($request->payment_date);

            if ($invoice->paid_amount >= $invoice->amount) {
                $invoice->status = 'paid';
            }

            $invoice->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Payment recorded successfully',
                'data' => [
                    'invoice' => $invoice,
                    'remaining' => $invoice->amount - $invoice->paid_amount,
                ],
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Failed to record payment',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function getCurrentMonthInvoice($companyId)
    {
        try {
            $currentMonth = Carbon::now()->startOfMonth();

            $invoice = Invoice::where('company_id', $companyId)
                ->whereYear('invoice_month', $currentMonth->year)
                ->whereMonth('invoice_month', $currentMonth->month)
                ->first();

            if (!$invoice) {
                return response()->json([
                    'success' => true,
                    'data' => null,
                    'message' => 'No invoice for current month',
                ]);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $invoice->id,
                    'invoice_number' => $invoice->invoice_number,
                    'amount' => $invoice->amount,
                    'status' => $invoice->status,
                    'due_date' => $invoice->due_date->format('d M, Y'),
                    'paid_amount' => $invoice->paid_amount,
                    'remaining' => $invoice->amount - $invoice->paid_amount,
                ],
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch current month invoice',
            ], 500);
        }
    }

    // Helper functions
    private function getCurrentMonthInvoiceData($companyId)
    {
        $currentMonth = Carbon::now()->startOfMonth();
        $invoice = Invoice::where('company_id', $companyId)
            ->whereYear('invoice_month', $currentMonth->year)
            ->whereMonth('invoice_month', $currentMonth->month)
            ->first();

        if ($invoice) {
            return [
                'amount' => $invoice->amount,
                'status' => $invoice->status,
                'due_date' => $invoice->due_date->format('d M, Y'),
            ];
        }

        return null;
    }

    private function getStatusBadge($status)
    {
        $badges = [
            'pending' => 'badge bg-warning',
            'paid' => 'badge bg-success',
            'overdue' => 'badge bg-danger',
            'cancelled' => 'badge bg-secondary',
            'draft' => 'badge bg-info',
        ];

        return $badges[$status] ?? 'badge bg-secondary';
    }

    private function generateInvoiceNumber($companyId)
    {
        $year = Carbon::now()->format('Y');
        $month = Carbon::now()->format('m');

        $count = DB::table('invoices')
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count() + 1;

        return "INV-SUB-{$year}{$month}-" . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}
