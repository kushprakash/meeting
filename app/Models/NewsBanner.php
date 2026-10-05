<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsBanner extends Model
{
    use HasFactory;

    protected $table = 'news_banners';

    protected $fillable = [
        'title',
        'description',
        'image_url',
        'action_type',
        'meeting_uuid',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
