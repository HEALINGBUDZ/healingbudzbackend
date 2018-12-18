<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPostScrape extends Model
{
    protected $casts = [
        'id' => 'integer',
        'post_id' => 'integer',
        'title' => 'string',
        'content' => 'string',
        'image' => 'string',
        'extracted_url' => 'string',
        'url' => 'string',
    ];
}
