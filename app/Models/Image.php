<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
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

    public function user(): MorphTo
    {
        return $this->morphTo();
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
        $dir = self::dir($disk);

        if ($process) {
            $name = md5(Auth::id() . microtime() . $uploaded->getClientOriginalName()) . '.webp';
            $path = $dir . '/' . $name;

            $manager = new ImageManager(new Driver());
            $manager->read($uploaded->path())->toWebp($quality)->save(Storage::disk($disk)->path($path));
        } else {
            $path = $uploaded->store($dir, $disk);
        }

        if ($watermark) {
            SpatieImage::load(Storage::disk($disk)->path($path))->watermark(
                storage_path('watermark.png'),
                AlignPosition::Center,
                width: 100,
                widthUnit: Unit::Percent,
                height: 100,
                heightUnit: Unit::Percent,
                alpha: 10
            )->save();
        }

        $image = self::create([
            'path' => $path,
            'disk' => $disk,
            'user_id' => Auth::id(),
            'user_type' => get_class(Auth::user()),
        ]);
        
        return $image;
    }

    public static function dir(string $disk): string
    {
        $dir = date('Y') . '/' . date('m');
        
        $path = Storage::disk($disk)->path($dir);

        if (! file_exists($path)) {
            mkdir($path, recursive: true);
        }

        return $dir;
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
