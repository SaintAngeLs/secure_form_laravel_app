<?php

namespace App\Infrastructure\Persistence\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormEntry extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'file_id'];

    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
