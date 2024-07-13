<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'disk',
        'user_id',
        'user_type',
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

    protected static function boot()
    {
        parent::boot();

        static::deleted(function (self $image) {
            $image->deleteFile();
        });
    }

    public function getUrl(): string
    {
        return url('storage/' . $this->path);
    }

    public static function processUploadedFile(UploadedFile $uploaded, $watermark = false, $quality = 0): void
    {
        $manager = new ImageManager(new Driver());

        $img = $manager->read(
            $manager->read($uploaded->path())
                ->toWebp($quality)
                ->toFilePointer()
        );

        if ($watermark) {
            $watermarkImg = $manager->read(storage_path('watermark.png'));
            $watermarkImg->cover($img->width(), $img->height());
            $img->place($watermarkImg, 'center', opacity: 10);
        }
        
        $img->save($uploaded->path());
    }

    public static function saveUploadedFile(UploadedFile $uploaded, $user, string $disk = 'public'): self
    {
        $path = $uploaded->store(date('Y') . '/' . date('m'), $disk);

        $image = self::create([
            'path' => $path,
            'disk' => $disk,
            'user_id' => $user->id,
            'user_type' => get_class($user),
        ]);

        return $image;
    }

    public function deleteFile(): bool
    {
        $path = Storage::disk($this->disk)->path($this->path);

        if (! file_exists($path)) {
            return false;
        }

        return unlink($path);
    }

    public static function deleteByIds(array $ids): void
    {
        foreach ($ids as $id) {
            Image::find($id)->delete();
        }
    }
}
