<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $invoice->invoice_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Arial', sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        
        .invoice-wrapper {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        /* Header Styles */
        .invoice-header {
            background: linear-gradient(135deg, #1a237e, #0d47a1);
            color: white;
            padding: 40px 50px;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .header-left h1 {
            font-size: 42px;
            font-weight: 800;
            letter-spacing: 2px;
            margin: 0;
        }
        
        .header-left p {
            font-size: 18px;
            opacity: 0.9;
            margin-top: 10px;
        }
        
        .header-right img {
            height: 80px;
            width: auto;
        }
        
        /* Body Styles */
        .invoice-body {
            padding: 50px;
        }
        
        /* Company Section */
        .company-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 2px solid #f0f0f0;
        }
        
        .company-details h2 {
            color: #1a237e;
            font-size: 24px;
            margin-bottom: 10px;
            font-weight: 700;
        }
        
        .company-details p {
            color: #666;
            line-height: 1.6;
            margin: 5px 0;
            font-size: 14px;
        }
        
        .invoice-details {
            text-align: right;
        }
        
        .invoice-number {
            color: #1a237e;
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 10px;
        }
        
        .invoice-date {
            color: #666;
            margin: 5px 0;
            font-size: 14px;
        }
        
        /* Status Badge */
        .status-badge {
            display: inline-block;
            padding: 6px 20px;
            border-radius: 50px;
            font-size: 14px;
            font-weight: 600;
            margin-top: 10px;
            text-transform: uppercase;
        }
        
        .status-paid { background: #10b981; color: white; }
        .status-pending { background: #f59e0b; color: white; }
        .status-overdue { background: #ef4444; color: white; }
        .status-cancelled { background: #6c757d; color: white; }
        .status-draft { background: #6c757d; color: white; }
        
        /* Bill To Section */
        .bill-to-section {
            margin-bottom: 40px;
            padding: 25px;
            background: #f8fafc;
            border-radius: 10px;
        }
        
        .bill-to-section h3 {
            color: #1a237e;
            font-size: 16px;
            margin-bottom: 15px;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 700;
        }
        
        .bill-to-section p {
            color: #444;
            line-height: 1.6;
            margin: 5px 0;
            font-size: 14px;
        }
        
        /* Items Table */
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }
        
        .items-table th {
            background: #1a237e;
            color: white;
            padding: 15px;
            text-align: left;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .items-table td {
            padding: 15px;
            border-bottom: 1px solid #e5e7eb;
            color: #444;
            font-size: 14px;
        }
        
        .items-table tbody tr:hover {
            background: #f8fafc;
        }
        
        .items-table .amount {
            font-weight: 700;
            color: #1a237e;
        }
        
        /* Bank Details */
        .bank-details {
            margin-top: 30px;
            padding: 20px;
            background: #f8fafc;
            border-radius: 10px;
            font-size: 14px;
        }
        
        .bank-details h4 {
            color: #1a237e;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .bank-details p {
            color: #666;
            margin: 5px 0;
        }
        
        /* Summary Section */
        .summary-section {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 2px solid #f0f0f0;
            text-align: right;
        }
        
        .summary-row {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin: 10px 0;
        }
        
        .summary-label {
            width: 150px;
            color: #666;
            font-size: 16px;
            font-weight: 500;
        }
        
        .summary-value {
            width: 200px;
            font-weight: 600;
            color: #1a237e;
            font-size: 18px;
            text-align: right;
        }
        
        .total-row {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #1a237e;
        }
        
        .total-label {
            color: #1a237e;
            font-size: 20px;
            font-weight: 800;
        }
        
        .total-value {
            color: #1a237e;
            font-size: 28px;
            font-weight: 800;
        }
        
        .total-due {
            color: #ef4444;
            font-size: 24px;
            font-weight: 800;
            margin-top: 15px;
        }
        
        /* Notes Section */
        .notes-section {
            margin-top: 30px;
            padding: 20px;
            background: #fff3cd;
            border-left: 4px solid #f59e0b;
            border-radius: 5px;
            font-size: 14px;
        }
        
        .notes-section h4 {
            color: #856404;
            margin-bottom: 10px;
            font-size: 16px;
        }
        
        .notes-section p {
            color: #856404;
            margin: 0;
            white-space: pre-line;
        }
        
        /* Terms Section */
        .terms-section {
            margin-top: 20px;
            padding: 20px;
            background: #f8fafc;
            border-radius: 10px;
            font-size: 13px;
            color: #666;
        }
        
        .terms-section h4 {
            color: #1a237e;
            margin-bottom: 10px;
            font-size: 15px;
        }
        
        /* Footer */
        .footer {
            background: #f8fafc;
            padding: 30px 50px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        
        .footer p {
            color: #666;
            font-size: 14px;
            margin: 5px 0;
        }
        
        .footer .thank-you {
            color: #1a237e;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        @media print {
            body { background: white; padding: 0; }
            .invoice-wrapper { box-shadow: none; }
        }
    </style>
</head>
<body>
<div class="invoice-wrapper">
    <!-- Header with Logo -->
    <div class="invoice-header">
        <div class="header-content">
            <div class="header-left">
                <h1>INVOICE</h1>
                <p>#{{ $invoice->invoice_number }}</p>
            </div>
            <div class="header-right">
                {!! $logoHtml !!}
            </div>
        </div>
    </div>

    <!-- Body Content -->
    <div class="invoice-body">
        <!-- Company Section -->
        <div class="company-section">
            <div class="company-details">
                <h2>{{ $company->name ?? 'Company Name' }}</h2>
                <p>{{ $company->address_1 ?? '' }}</p>
                @if($company->address_2)
                    <p>{{ $company->address_2 }}</p>
                @endif
                <p>{{ $company->city_id ?? '' }} {{ $company->state_id ?? '' }} {{ $company->country_id ?? '' }}</p>
                <p>Email: {{ $company->email ?? '' }}</p>
                <p>Phone: {{ $company->telephon ?? '' }}</p>
            </div>
            <div class="invoice-details">
                <div class="invoice-number">INVOICE #{{ $invoice->invoice_number }}</div>
                <div class="invoice-date">Date: {{ $invoice->invoice_date->format('d M, Y') }}</div>
                <div class="invoice-date">Due Date: {{ $invoice->due_date->format('d M, Y') }}</div>
                <div class="status-badge status-{{ $invoice->status }}">
                    {{ ucfirst($invoice->status) }}
                </div>
            </div>
        </div>

        <!-- Bill To Section -->
        <div class="bill-to-section">
            <h3>BILL TO</h3>
            <p><strong>{{ $company->name ?? 'Client Name' }}</strong></p>
            <p>{{ $company->address_1 ?? '' }}</p>
            @if($company->address_2)
                <p>{{ $company->address_2 }}</p>
            @endif
            <p>{{ $company->city_id ?? '' }} {{ $company->state_id ?? '' }} {{ $company->country_id ?? '' }}</p>
            <p>Email: {{ $company->email ?? '' }}</p>
            @if($invoice->project_name)
                <p><strong>Project:</strong> {{ $invoice->project_name }}</p>
            @endif
        </div>

        <!-- Items Table -->
        @if(!empty($items))
            <table class="items-table">
                <thead>
                    <tr>
                        <th>DESCRIPTION</th>
                        <th>QUANTITY</th>
                        <th>UNIT PRICE ({{ $currencySymbol }})</th>
                        <th>TAX</th>
                        <th>AMOUNT ({{ $currencySymbol }})</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td>{{ $item['name'] ?? $item['description'] ?? 'Item' }}</td>
                            <td>{{ $item['quantity'] ?? 1 }}</td>
                            <td>{{ $currencySymbol }}{{ number_format($item['unit_price'] ?? 0, 2) }}</td>
                            <td>{{ $item['tax'] ?? 0 }}%</td>
                            <td class="amount">{{ $currencySymbol }}{{ number_format($item['amount'] ?? ($item['quantity'] * $item['unit_price']), 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p style="text-align: center; padding: 20px; color: #999;">No items in this invoice</p>
        @endif

        <!-- Bank Details -->
        @if($invoice->bank_account || $invoice->payment_details)
            <div class="bank-details">
                <h4>Bank Details</h4>
                @if($invoice->bank_account)
                    <p><strong>Account:</strong> {{ $invoice->bank_account }}</p>
                @endif
                @if($invoice->payment_details)
                    <p><strong>Details:</strong> {{ nl2br(htmlspecialchars($invoice->payment_details)) }}</p>
                @endif
            </div>
        @endif

        <!-- Summary Section -->
        @php
            $subtotal = $invoice->sub_total ?? $invoice->amount;
            $taxAmount = $invoice->tax_amount ?? 0;
            $discount = $invoice->discount_amount ?? 0;
            $total = $invoice->amount;
            $remaining = $invoice->amount - ($invoice->paid_amount ?? 0);
        @endphp

        <div class="summary-section">
            <div class="summary-row">
                <span class="summary-label">Subtotal:</span>
                <span class="summary-value">{{ $currencySymbol }}{{ number_format($subtotal, 2) }}</span>
            </div>

            @if($taxAmount > 0)
                <div class="summary-row">
                    <span class="summary-label">Tax:</span>
                    <span class="summary-value">{{ $currencySymbol }}{{ number_format($taxAmount, 2) }}</span>
                </div>
            @endif

            @if($discount > 0)
                <div class="summary-row">
                    <span class="summary-label">Discount:</span>
                    <span class="summary-value">-{{ $currencySymbol }}{{ number_format($discount, 2) }}</span>
                </div>
            @endif

            <div class="summary-row total-row">
                <span class="summary-label total-label">TOTAL:</span>
                <span class="summary-value total-value">{{ $currencySymbol }}{{ number_format($total, 2) }}</span>
            </div>

            @if($remaining > 0)
                <div class="summary-row">
                    <span class="summary-label total-label">AMOUNT DUE:</span>
                    <span class="summary-value total-due">{{ $currencySymbol }}{{ number_format($remaining, 2) }}</span>
                </div>
            @elseif($invoice->paid_amount > 0)
                <div class="summary-row">
                    <span class="summary-label">Paid:</span>
                    <span class="summary-value" style="color: #10b981;">{{ $currencySymbol }}{{ number_format($invoice->paid_amount, 2) }}</span>
                </div>
            @endif
        </div>

        <!-- Notes Section -->
        @if($invoice->notes)
            <div class="notes-section">
                <h4>Notes</h4>
                <p>{{ nl2br(htmlspecialchars($invoice->notes)) }}</p>
            </div>
        @endif
    </div>

    <!-- Footer -->
    <div class="footer">
        <p class="thank-you">Thank you for your business!</p>
        <p>{{ config('app.name') }} - Generated on {{ now()->format('d M, Y H:i') }}</p>
        <p>Invoice #{{ $invoice->invoice_number }}</p>
    </div>
</div>
</body>
</html>