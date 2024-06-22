<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'path',
    ];

    public static function saveUploaded(
        UploadedFile $uploaded, 
        bool $watermark = false,
        ?int $compress = null
    ): self
    {
        $manager = new ImageManager(new Driver());

        $img = $manager->read($uploaded->path());

        if ($watermark) {
            $img->place(self::watermark(), 'center');
        }
        
        $name = md5(Auth::id() . $uploaded->getClientOriginalName() . microtime());
        $path = date('Y') . '/' . date('m') . '/' . $name . '.webp';

        Storage::disk('public')->put(
            $path, isset($compress) ? $img->toWebp($compress) : $img->toWebp()
        );

        $image = self::create(['path' => $path,]);

        return $image;
    }

    public static function watermark(): string
    {
        return storage_path('watermark.png');
    }

    public function url(): string
    {
        return url('storage/' . $this->path);
    }

    public function deleteFile(): bool
    {
        $path = Storage::disk('public')->path($this->path);

        if (! file_exists($path)) {
            return false;
        }

        return unlink($path);
    }
    
    public static function getByIds(array $ids): Collection
    {
        if (empty($ids)) {
            return new Collection();
        }

        return self::whereIn('id', $ids)
            ->orderByRaw('FIELD(id, ' . implode(',', $ids) . ')')
            ->get();
    }
}
