<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;
use Staudenmeir\EloquentJsonRelations\Relations\BelongsToJson;

class ProfileRequest extends Model
{
    use HasFactory, HasJsonRelationships;

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
        'verification_photo',
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
        'verification_photo' => 'array',
        'id_photo' => 'array',
        'street_photo' => 'array',
    ];

    protected $profileFields = [
        'name',
        'age',
        'gender',
        'description',
        'phone',
        'telegram',
        'whatsapp',
        'snapchat',
        'instagram',
        'onlyfans',
        'profile_email',
        'location',
        'first_name',
        'last_name',
        'birthday',
        'id_photo',
        'street_photo',
        'verification_photo',
        'photos',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Creator::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function gallery(): BelongsToJson
    {
        return $this->belongsToJson(Image::class, 'photos->value');
    }

    public function verificationPhoto(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'verification_photo->value');
    }

    public function idPhoto(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'id_photo->value');
    }

    public function streetPhoto(): BelongsTo
    {
        return $this->belongsTo(Image::class, 'street_photo->value');
    }

    public function migrateDataToProfile(): bool
    {
        foreach ($this->profileFields as $field) {
            if (! $this->{$field}) {
                continue;
            }

            if (is_array($this->{$field}['status'])) {
                $values = array_filter($this->{$field}['value'], function ($i) use($field) {
                    return $this->{$field}['status'][$i] == 'approved';
                }, ARRAY_FILTER_USE_KEY);
    
                $this->creator[$field] = array_merge($this->creator->{$field} ?? [], $values);
                continue;
            }

            if ($this->{$field}['status'] != 'approved') {
                continue;
            }

            $this->creator[$field] = $this->{$field}['value'];
        }

        return $this->creator->save();
    }

    public function profileData(): array
    {
        $data = [];
        foreach ($this->profileFields as $field) {
            $data[$field]['value'] = $this->{$field} ? 
                $this->{$field}['value'] : 
                $this->creator->{$field};
            $data[$field]['status'] = $this->{$field} ? 
                $this->{$field}['status'] : 
                null;
            $data[$field]['comment'] = $this->{$field} ? 
                $this->{$field}['comment'] : 
                null;
        }

        return $data;
    }

    public function status(array $fields): ?string
    {
        $hasApproved = false;
        foreach ($fields as $field) {
            if (! $this->{$field}) {
                continue;
            }

            if ($this->{$field}['status'] == 'approved') {
                $hasApproved = true;
            }

            if (
                $this->{$field}['status'] == 'pending' or 
                $this->{$field}['status'] == 'rejected'
            ) {
                return $this->{$field}['status'];
            }
        }

        return $hasApproved ? 'approved' : null;
    }

    public function comments(array $fields): array
    {
        $comments = [];
        foreach ($fields ?? [] as $field) {
            if (! $this->{$field} or $this->{$field}['status'] != 'rejected') {
                continue;
            }

            if (is_array($this->{$field}['comment'])) {
                $comments = array_merge($comments, $this->{$field}['comment']);
            } else {
                $comments[] = $this->{$field}['comment'];
            }
        }

        return $comments;
    }

    public function deleteRejectedPhotos(): void
    {
        $approved = [];
        $rejected = [];
        foreach ($this->photos['status'] ?? [] as $i => $status) {
            if ($status == 'rejected') {
                $rejected[] = $this->photos['value'][$i];
            } else {
                $approved['value'][] = 
                    $this->photos['value'][$i];
                $approved['status'][] = 
                    $this->photos['status'][$i];
                $approved['comment'][] = 
                    $this->photos['comment'][$i];
            }
        }

        Image::deleteByIds($rejected);

        $this->photos = $approved ?: null;
        $this->save();
    }

    public static function next(bool $approved): ?ProfileRequest
    {
        return ProfileRequest::where('status', 'undone')
            ->whereHas('creator', function (Builder $query) use($approved) {
                $query->where('is_approved', $approved);
            })->orderBy('created_at', 'DESC')->first();
    }
}
