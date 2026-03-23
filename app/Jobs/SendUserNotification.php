<?php

namespace App\Jobs;

use App\Mail\userNotificationsMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendUserNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function handle(){
        try {
            Mail::send(new userNotificationsMail($this->data));
        }catch (\Exception $e){
            // Log the error
            Log::error('Error sending notification email: ' . $e->getMessage(), [
                'exception' => $e,
                'data' => $this->data
            ]);
        }
    }
}
