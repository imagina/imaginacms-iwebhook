<?php

namespace Modules\Iwebhooks\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Modules\Iwebhooks\Jobs\DispatchWebhooks;

class ScheduleServiceProvider extends ServiceProvider
{
  public function boot()
  {
    $this->app->booted(function () {

      //Check id is active the webhook job
      if (setting("iwebhooks::activateDispatchWebhooksJob", null, false)) {
        //Create instance about schedule
        $schedule = $this->app->make(Schedule::class);
        //Instance Hook Repository
        $modelRepository = app('Modules\Iwebhooks\Repositories\HookRepository');
        //Filter by Not Null
        $params = ["filter" => ["callEveryMinutes" => ["where" => "notNull"]]];
        //Get Hooks
        $hooks = $modelRepository->getItemsBy(json_decode(json_encode($params)));
        //Loop hooks
        foreach ($hooks as $hook) {
          $schedule->call(function () use ($hook) {
            \Modules\Iwebhooks\Jobs\DispatchWebhooks::dispatch($hook->id);
          })->cron("*/{$hook->call_every_minutes} * * * *");
        }

      }
    });
  }

}
