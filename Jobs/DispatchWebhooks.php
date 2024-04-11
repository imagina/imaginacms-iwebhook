<?php

namespace Modules\Iwebhooks\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Modules\Iwebhooks\Services\DispatchService;

class DispatchWebhooks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $hookId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($hookId)
    {
      $this->hookId = $hookId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $service = new DispatchService();
      $data = $service->dispatchWebhook($this->hookId, []);

      \Log::info("Hook With ID: {$this->hookId} run");
    }
}
