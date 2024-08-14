<?php

namespace App\Jobs;

use App\Models\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;
use Spatie\Image\Image as SpatieImage;
use Spatie\Image\Enums\AlignPosition;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Enums\Unit;


class ProcessImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        private Image $image,
        private int $quality,
        private int $watermark,
    )
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $manager = new ImageManager(new Driver());

        $manager->read($this->image->getPath())->toWebp($this->quality)->save($this->image->getPath());

        if ($this->watermark) {
            SpatieImage::load($this->image->getPath())->watermark(
                storage_path('watermark.png'),
                AlignPosition::Center,
                width: 100,
                widthUnit: Unit::Percent,
                height: 100,
                heightUnit: Unit::Percent,
                fit: Fit::Stretch,
                alpha: 10,
            )->save();
        }

        $this->image->update(['processed' => true,]);
    }
}
