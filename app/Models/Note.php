<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model {
    protected $fillable = [ 'img_url', 'base64_img', 'extracted_data', 'markdown', 'title', 'user_id', ];
    protected $attributes = [ 'is_favourite' => false, 'is_archived' => false, 'is_edited' => false, 'is_deleted' => false, ];

    public function user() {
        return $this->belongsTo(User::class);
    }

}
