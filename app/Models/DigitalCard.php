<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DigitalCard extends Model
{
    protected $fillable = [
        'slug',
        'short_code',
        'name',
        'title',
        'company',
        'email',
        'phone',
        'linkedin_url',
        'website_url',
        'avatar_path',
        'edit_code',
        'template',
    ];

    protected $hidden = ['edit_code'];

    private const SHORT_CODE_CHARS = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';

    protected static function booted(): void
    {
        static::creating(function (DigitalCard $card) {
            if (empty($card->slug)) {
                $card->slug = Str::slug($card->name) . '-' . Str::lower(Str::random(6));
            }
            if (empty($card->short_code)) {
                $card->short_code = static::generateShortCode();
            }
        });
    }

    public static function generateShortCode(): string
    {
        $chars = self::SHORT_CODE_CHARS;
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= $chars[random_int(0, strlen($chars) - 1)];
        }
        while (static::where('short_code', $code)->exists()) {
            $code = '';
            for ($i = 0; $i < 6; $i++) {
                $code .= $chars[random_int(0, strlen($chars) - 1)];
            }
        }
        return $code;
    }

    public function getCardUrlAttribute(): string
    {
        return url('/c/' . $this->short_code);
    }

    public function getQrUrlAttribute(): string
    {
        return url('/card/' . $this->short_code . '/vcard');
    }
}
