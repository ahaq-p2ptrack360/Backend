<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function build()
    {
        $invoice = $this->data['invoice'];
        $company = $this->data['company'];
        $message = $this->data['message'] ?? '';
        
        // Simple HTML banao, view file ki zaroorat nahi
        $html = $this->generateSimpleHtml($invoice, $company, $message);
        
        return $this->html($html)
                    ->subject("Invoice #{$invoice->invoice_number}");
    }
    
    private function generateSimpleHtml($invoice, $company, $message)
    {
        $statusColor = '#6c757d';
        if ($invoice->status == 'paid') $statusColor = '#10b981';
        if ($invoice->status == 'pending') $statusColor = '#f59e0b';
        if ($invoice->status == 'overdue') $statusColor = '#ef4444';
        
        $html = "<!DOCTYPE html>";
        $html .= "<html><head><title>Invoice</title></head><body>";
        $html .= "<div style='max-width:600px; margin:auto; padding:20px; font-family:Arial,sans-serif;'>";
        $html .= "<div style='background:linear-gradient(135deg,#4a6cf7,#6a11cb); color:white; padding:20px; text-align:center; border-radius:10px 10px 0 0;'>";
        $html .= "<h1>Invoice #{$invoice->invoice_number}</h1>";
        $html .= "</div>";
        
        $html .= "<div style='padding:30px; background:#f9f9f9; border:1px solid #e5e7eb;'>";
        
        if (!empty($message)) {
            $html .= "<p>{$message}</p>";
        }
        
        $html .= "<div style='background:white; padding:20px; border-radius:8px; border:1px solid #e5e7eb;'>";
        $html .= "<h3>Invoice Details</h3>";
        $html .= "<table style='width:100%; border-collapse:collapse;'>";
        $html .= "<tr><td><strong>Company:</strong></td><td>{$company->name}</td></tr>";
        $html .= "<tr><td><strong>Invoice Date:</strong></td><td>" . $invoice->invoice_date->format('d M, Y') . "</td></tr>";
        $html .= "<tr><td><strong>Due Date:</strong></td><td>" . $invoice->due_date->format('d M, Y') . "</td></tr>";
        $html .= "<tr><td><strong>Status:</strong></td><td>";
        $html .= "<span style='padding:5px 10px; border-radius:4px; background:{$statusColor}; color:white;'>";
        $html .= ucfirst($invoice->status);
        $html .= "</span></td></tr>";
        $html .= "</table>";
        
        $html .= "<div style='font-size:18px; font-weight:bold; text-align:right; margin-top:20px;'>";
        $html .= "Amount: $" . number_format($invoice->amount, 2);
        $html .= "</div>";
        
        if ($invoice->paid_amount > 0) {
            $html .= "<p>Paid Amount: $" . number_format($invoice->paid_amount, 2) . "</p>";
            $html .= "<p>Remaining: $" . number_format($invoice->amount - $invoice->paid_amount, 2) . "</p>";
        }
        
        $html .= "</div>"; // invoice-details close
        $html .= "</div>"; // content close
        
        $html .= "<div style='text-align:center; padding:20px; color:#666; border-top:1px solid #e5e7eb;'>";
        $html .= "<p>Thank you for your business!</p>";
        $html .= "<p>&copy; " . date('Y') . " {$company->name}. All rights reserved.</p>";
        $html .= "</div>";
        
        $html .= "</div></body></html>";
        
        return $html;
    }
}