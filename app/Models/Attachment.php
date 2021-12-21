<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Message;

class Attachment extends Model
{
    use HasFactory;
    protected $fillable = ['path'];

  
    public function attachable()
    {
        return $this->morphTo(Message::class , 'attachable');
        
    }




}
