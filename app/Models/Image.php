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

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
        'disk',
        'user_id',
        'user_type',
        'processed',
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

    public function getPath(): string
    {
        return Storage::disk($this->disk)->path($this->path);
    }

    public static function saveUploadedFile(
        UploadedFile $uploaded,
        string $disk = 'public'
    ): self
    {
        $dir = self::dir($disk);

        $name = md5(Auth::id() . microtime() . $uploaded->getClientOriginalName()) . '.webp';

        $path = $uploaded->storeAs($dir, $name, $disk);

        $image = self::create([
            'path' => $path,
            'disk' => $disk,
            'user_id' => Auth::id(),
            'user_type' => get_class(Auth::user()),
        ]);

        if (in_array($uploaded->getMimeType(), [
            'image/heif', 
            'image/heif-sequence', 
            'image/heic', 
            'image/heic-sequence', 
            'image/avif',
        ])) {
            $manager = new ImageManager(new Driver());
        
            $manager->read($image->getPath())->toWebp()->save($image->getPath());
        }
        
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
            Image::find($id)?->delete();
        }
    }
}
