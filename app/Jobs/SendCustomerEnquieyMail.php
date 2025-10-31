<?php

namespace App\Jobs;

use ACME\paymentProfile\Mail\AdminEnquiryNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Webkul\User\Models\Admin;

class SendCustomerEnquieyMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $admins = Admin::select('name', 'email')->where('role_id', 1)->get();
        $emailList = $admins->pluck('email')->toArray();
        $data = $this->data;

        try {
            Mail::to($emailList)->send(new AdminEnquiryNotification($data));
            Log::info('✅ Enquiry mail sent to: ' . implode(', ', $emailList));
        } catch (\Exception $e) {
            Log::error('❌ Failed to send enquiry mail', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}
