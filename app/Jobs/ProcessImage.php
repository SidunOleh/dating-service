<?php

namespace App\Jobs;

use App\Models\Image;
use App\Services\Images\ImagesService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private Image $image
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(ImagesService $imagesService): void
    {
        $imagesService->process($this->image);
    }
}
