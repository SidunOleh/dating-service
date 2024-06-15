<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProfileRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'gender',
        'description',
        'phone',
        'profile_email',
        'instagram',
        'telegram',
        'snapchat',
        'onlyfans',
        'whatsapp',
        'photos',
        'location',
        'first_name',
        'last_name',
        'birthday',
        'id_photo',
        'street_photo',
        'status',
        'creator_id',
        'user_id',
    ];

    protected $casts = [
        'name' => 'array',
        'age' => 'array',
        'gender' => 'array',
        'description' => 'array',
        'phone' => 'array',
        'profile_email' => 'array',
        'instagram' => 'array',
        'telegram' => 'array',
        'snapchat' => 'array',
        'onlyfans' => 'array',
        'whatsapp' => 'array',
        'photos' => 'array',
        'location' => 'array',
        'first_name' => 'array',
        'last_name' => 'array',
        'birthday' => 'array',
        'id_photo' => 'array',
        'street_photo' => 'array',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Creator::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function photos(): Collection
    {
        return Image::getByIds($this->photos['value'] ?? []);
    }

    public function idPhoto(): ?Image
    {
        return Image::find($this->id_photo['value'] ?? '');
    }

    public function streetPhoto(): ?Image
    {
        return Image::find($this->street_photo['value'] ?? '');
    }

    public function migrate(): bool
    {
        $data = [];

        foreach ([
            'name',
            'age',
            'gender',
            'phone',
            'profile_email',
            'instagram',
            'telegram',
            'snapchat',
            'onlyfans',
            'whatsapp',
            'description',
            'first_name',
            'last_name',
            'birthday',
            'id_photo',
            'street_photo',
        ] as $field) {
            if (
                isset($this->{$field}) and 
                $this->{$field}['status'] == 'approved'
            ) {
                $data[$field] = $this->{$field}['value'];
            }
        }

        if (
            isset($this->location) and 
            $this->location['status'] == 'approved'
        ) {
            foreach ([
                'full_address',
                'country',
                'region',
                'city',
                'latitude',
                'longitude',
            ] as $field) {
                $data[$field] = $this->location['value'][$field];
            }
        }

        if (isset($this->photos)) {
            $photos = array_filter($this->photos['value'], function ($i) {
                return $this->photos['status'][$i] == 'approved';
            }, ARRAY_FILTER_USE_KEY);

            $data['photos'] = array_merge($this->creator->photos ?? [], $photos);
        }

        return $this->creator->update($data);
    }

    public static function next(bool $approved): ?ProfileRequest
    {
        return ProfileRequest::where('status', 'undone')
            ->whereHas('creator', function (Builder $query) use($approved) {
                $query->where('is_approved', $approved);
            })->orderBy('created_at', 'DESC')->first();
    }
}
