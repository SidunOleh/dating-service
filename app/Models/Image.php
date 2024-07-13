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
use Spatie\Image\Image as SpatieImage;
use Spatie\Image\Enums\AlignPosition;
use Spatie\Image\Enums\Unit;

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

    public static function saveUploadedFile(
        UploadedFile $uploaded,
        bool $process = false,
        int $quality = 0,
        bool $watermark = false, 
        string $disk = 'public'
    ): self
    {
        $dir = date('Y') . '/' . date('m');

        if ($process) {
            $manager = new ImageManager(new Driver());

            $name = md5(Auth::id() . microtime() . $uploaded->getClientOriginalName()) . '.webp';
            $path = $dir . '/' . $name;
            $fullPath = Storage::disk($disk)->path($path);

            $manager->read($uploaded->path())->toWebp($quality)->save($fullPath);

            if ($watermark) {
                SpatieImage::load($fullPath)->watermark(
                    storage_path('watermark.png'),
                    AlignPosition::Center,
                    width: 100,
                    widthUnit: Unit::Percent,
                    height: 100,
                    heightUnit: Unit::Percent,
                    alpha: 10
                )->save();
            }
        } else {
            $path = $uploaded->store(date('Y') . '/' . date('m'), $disk);
        }

        $image = self::create([
            'path' => $path,
            'disk' => $disk,
            'user_id' => Auth::id(),
            'user_type' => get_class(Auth::user()),
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
