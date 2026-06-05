<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class GenerateMonthlyInvoices extends Command
{
    protected $signature = 'invoices:generate-monthly';
    protected $description = 'Har mahine ki 1st date ko companies ke subscription invoices generate karo';

    public function handle()
    {
        $this->info('📅 Invoice generation started at: ' . now());
        Log::info('Monthly invoice generation started');

        $currentMonth = Carbon::now()->startOfMonth();
        $monthName = $currentMonth->format('F Y');
        
        $this->info("Generating invoices for month: {$monthName}");
        
        // Sirf active companies jin ke paas subscription hai
        $companies = DB::table('company')
            ->where('active', 1)
            ->whereNotNull('subscription_id')
            ->get();
            
        $this->info('Total active companies found: ' . $companies->count());
        
        $generated = 0;
        $skipped = 0;
        $errors = 0;

        foreach ($companies as $company) {
            try {
                DB::beginTransaction();
                
                // Check if invoice already exists for this month
                $exists = DB::table('invoices')
                    ->where('company_id', $company->id)
                    ->whereYear('invoice_month', $currentMonth->year)
                    ->whereMonth('invoice_month', $currentMonth->month)
                    ->exists();
                    
                if ($exists) {
                    $this->warn("⏭️ Invoice already exists for {$company->name}");
                    $skipped++;
                    DB::rollBack();
                    continue;
                }
                
                // ✅ FIXED: subscription_package (singular) - 's' nahi hai
                $subscription = DB::table('subscription_package')
                    ->where('id', $company->subscription_id)
                    ->first();
                    
                if (!$subscription) {
                    $this->error("❌ No subscription package found for ID: {$company->subscription_id}");
                    $errors++;
                    DB::rollBack();
                    continue;
                }
                
                // Calculate amount
                $licences = $company->licences ?? 1;
                $amount = $subscription->price * $licences;
                
                // Generate invoice number
                $invoiceNumber = $this->generateInvoiceNumber();
                
                // Create invoice
                DB::table('invoices')->insert([
                    'invoice_number' => $invoiceNumber,
                    'company_id' => $company->id,
                    'subscription_id' => $company->subscription_id,
                    'invoice_date' => Carbon::now(),
                    'due_date' => Carbon::now()->addDays(15),
                    'amount' => $amount,
                    'status' => 'pending',
                    'paid_amount' => 0,
                    'invoice_month' => $currentMonth,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                
                DB::commit();
                
                $generated++;
                $this->info("✅ Generated: {$invoiceNumber} - {$company->name} - \${$amount}");
                
            } catch (\Exception $e) {
                DB::rollBack();
                $errors++;
                $this->error("❌ Failed for {$company->name}: " . $e->getMessage());
                Log::error('Invoice generation failed', [
                    'company' => $company->name,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $this->newLine();
        $this->info('📊 SUMMARY');
        $this->info('✅ Generated: ' . $generated);
        $this->info('⏭️ Skipped: ' . $skipped);
        $this->info('❌ Errors: ' . $errors);

        return Command::SUCCESS;
    }

    private function generateInvoiceNumber()
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