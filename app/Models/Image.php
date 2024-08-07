<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        $path = $uploaded->store($dir, $disk);

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
            Image::find($id)?->delete();
        }
    }
}
