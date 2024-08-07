<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;
use Spatie\Image\Image;
use Spatie\Image\Enums\AlignPosition;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Enums\Unit;


class ProcessImage implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $image = $event->image;
        $process = $event->process;
        $quality = $event->quality;
        $watermark = $event->watermark;

        if ($process) {
            $manager = new ImageManager(new Driver());
            
            $manager->read($image->getPath())
                ->toWebp($quality)
                ->save($image->getPath());
        }

        if ($watermark) {
            Image::load($image->getPath())->watermark(
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

        $image->processed = true;
        $image->save();
    }
}
