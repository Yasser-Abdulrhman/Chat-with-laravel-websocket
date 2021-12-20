<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Attachment;

class Message extends Model
{
    use HasFactory;
    protected $fillable = ['message','type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
 
    public function attachments(){
        return $this->morphMany(Attachment::class, 'attachable');
    }
     



}
