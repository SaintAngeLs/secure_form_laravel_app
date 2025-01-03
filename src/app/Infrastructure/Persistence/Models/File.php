<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'path', 'extension', 'mime_type', 'size', 'uploader_id'];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }
}
