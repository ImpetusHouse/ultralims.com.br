<?php

namespace App\Jobs;

use App\Services\EpicFlow;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendEpicFlowMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $clientName;
    protected $pageTitle;
    protected $phone;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($clientName, $pageTitle, $phone)
    {
        $this->clientName = $clientName;
        $this->pageTitle = $pageTitle;
        $this->phone = $phone;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $epicFlow = new EpicFlow();
            $epicFlow->sendTemplateMessage(
                $this->clientName,
                '"Produto - ' . $this->pageTitle . '"',
                $this->phone,
                'marcele@ultralims.com.br'
            );
        } catch (Exception $e) {
            // Handle exception (e.g., log error)
            Log::error('Failed to send EpicFlow message: ' . $e->getMessage());
        }
    }
}
