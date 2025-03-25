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
    public $params;
    public $extraBody;
    public $eventName;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($hookId, $params = [])
    {
      $this->hookId = $hookId;
      $this->params = $params['params'] ?? [];
      $this->extraBody = $params['extraBody'] ?? null;
      $this->eventName = $params['eventName'] ?? null;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
      $service = new DispatchService();
      $service->dispatchWebhook($this->hookId, $this->params, $this->extraBody, $this->eventName);
    }
}
