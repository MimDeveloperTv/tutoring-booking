<?php

namespace App\Jobs;

use App\Lib\Http\Request as CustomRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendNewReserveToCollectionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public array $booked)
    {
    }

    public function handle(): void
    {
        CustomRequest::post([
            'domain' => $this->booked['domain']
        ],$this->booked,'core_clinic','/reserves/notification');
    }
}
