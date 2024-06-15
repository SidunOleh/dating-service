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

    public const THUMB_SIZE = [
        400,
        400,
    ];

    public static function saveUploaded(
        UploadedFile $uploaded, 
        bool $thumb = false,
        bool $watermark = false
    ): self
    {
        $manager = new ImageManager(new Driver());

        $img = $manager->read($uploaded->path());

        if ($watermark) {
            $img->place(storage_path('watermark.png'), 'center');
        }

        $dir = date('Y') . '/' . date('m');
        if (! is_dir($fullDir = Storage::disk('public')->path($dir))) {
            mkdir($fullDir, 0775, true);
        }

        $name = md5(Auth::id() . $uploaded->getClientOriginalName() . microtime());
        $extention = $uploaded->extension();
        $path = $fullDir . '/' . $name . '.' . $extention;
        
        $img->save($path);

        if ($thumb) {
            $thumbImg = $manager->read($path);
            $thumbImg->scale(self::THUMB_SIZE[0], self::THUMB_SIZE[1]);
            $thumbPath = $fullDir . '/' . "{$name}-thumb" . '.' . $extention;
            $thumbImg->save($thumbPath);
        }

        $image = self::create([
            'path' => $dir . '/' . $name . '.' . $extention,
        ]);

        return $image;
    }

    public function url(): string
    {
        return url('storage/' . $this->path);
    }

    public function thumbUrl(): ?string
    {
        $name = explode('.', basename($this->path))[0];
        $thumbName = $name . '-thumb';
        $regex = '/' . preg_quote($name) . '/';
        $thumbPath = preg_replace($regex, $thumbName, $this->path);
        
        if (Storage::disk('public')->exists($thumbPath)) {
            return url('storage/' . $thumbPath);
        } else {
            return null;
        }
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
