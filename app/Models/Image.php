<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Imagick\Driver;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
    ];

    protected $appends = [
        'url',
    ];

    protected function url(): Attribute
    {
        return new Attribute(
            get: fn () => $this->getUrl(),
        );
    }

    public function getUrl(): string
    {
        return url('storage/' . $this->path);
    }

    public static function processUploaded(
        UploadedFile $uploaded, 
        bool $watermark = false,
        int $quality = 0
    ): void
    {
        $manager = new ImageManager(new Driver());

        $img = $manager->read(
            $manager->read($uploaded->path())->toWebp($quality)->toFilePointer()
        );

        if ($watermark) {
            $img->place(storage_path('watermark.png'), 'center');
        }
        
        $img->save($uploaded->path());
    }

    public static function saveUploaded(UploadedFile $uploaded): self
    {
        $path = $uploaded->store(date('Y') . '/' . date('m'), 'public');

        $image = self::create(['path' => $path,]);

        return $image;
    }

    public function deleteFile(): bool
    {
        $path = Storage::disk('public')->path($this->path);

        if (! file_exists($path)) {
            return false;
        }

        return unlink($path);
    }
}
