<?php

namespace App\Services\Images;

use App\Jobs\ProcessImage;
use App\Models\Creator;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;
use Spatie\Image\Image as SpatieImage;
use Illuminate\Http\File;

class ImagesService
{
    public function upload(
        User|Creator $user,
        UploadedFile $uploaded,
        bool $process,
        string $disk = 'public'
    ): Image
    {
        $dir = $this->dir($disk);

        $name = md5($user->id . microtime() . $uploaded->getClientOriginalName()) . '.webp';

        $path = $uploaded->storeAs($dir, $name, $disk);

        $image = Image::create([
            'path' => $path,
            'disk' => $disk,
            'user_id' => $user->id,
            'user_type' => get_class($user),
        ]);

        $user->uploads()->create([
            'mime_type' => $uploaded->getMimeType(),
            'size' => $uploaded->getSize(),
        ]);

        if (in_array($uploaded->getMimeType(), [
            'image/heif', 
            'image/heif-sequence', 
            'image/heic', 
            'image/heic-sequence', 
            'image/avif',
        ])) {
            $this->convertToWebp($image);
        }

        if ($process) {
            $image->update(['processed' => false]);

            ProcessImage::dispatch($image)->delay(now()->addMinutes(1));
        }
        
        return $image;
    }

    public function createFromLocal(
        string $path, 
        Creator|User $creator,
        string $disk = 'public'
    ): Image
    {
        $dir = $this->dir($disk);
        $name = md5($path).'.webp';
        
        $image = Image::whereRaw('path REGEXP ?', [preg_quote('/'.$name).'$'])->first();

        if (! $image) {
            $newPath = $dir.'/'.$name;
            Storage::disk($disk)->put($newPath, file_get_contents($path));

            $image = Image::create([
                'path' => $newPath,
                'disk' => $disk,
                'user_id' => $creator->id,
                'user_type' => get_class($creator),
            ]);

            $this->addWatermark($image);
        }

        return $image;
    }

    private function dir(string $disk): string
    {
        $dir = date('Y') . '/' . date('m');
        
        $path = Storage::disk($disk)->path($dir);

        if (! file_exists($path)) {
            mkdir($path, recursive: true);
        }

        return $dir;
    }

    public function process(Image $image): void
    {
        $this->convertToWebp($image);

        $this->optimize($image);

        $this->addWatermark($image);

        $image->update(['processed' => true]);
    }

    public function convertToWebp(Image $image): void
    {
        $manager = new ImageManager(new Driver());
        
        $_image = $manager->read($image->getPath());
        
        $_image->toWebp()->save($image->getPath());
    }

    public function optimize(Image $image): void
    {
        $manager = new ImageManager(new Driver());

        $_image = $manager->read($image->getPath());
        
        $_image->save($image->getPath(), 10);
    }

    public function addWatermark(Image $image): void
    {
        $_image = SpatieImage::load($image->getPath());
        
        $_image->text(
            'Cherry21.com', 
            fontSize: 20, 
            color: 'rgba(150, 152, 158, 0.8)',
            x: $_image->getWidth() - 140, 
            y: $_image->getHeight() - 10,
            fontPath: storage_path('Poppins-Regular.ttf'),
        );
        
        $_image->save();
    }

    public function deleteByIds(array $ids): void
    {
        foreach ($ids as $id) {
            Image::find($id)?->delete();
        }
    }
}