<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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

    public static function saveUploadedFile(UploadedFile $uploaded): self
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
