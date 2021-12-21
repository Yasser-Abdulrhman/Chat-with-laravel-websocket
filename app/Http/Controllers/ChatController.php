<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Attachment;
use App\Events\MessageSent;
use Illuminate\Support\Facades\Storage;

class ChatController extends Controller
{
    public function __constructor()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('chats');
    }
    public function fetchMessages()
    {
        return Message::with('user' ,'attachments')->get();
    }
    public function sendMessage(Request $request)
    {
       $message = auth()->user()->messages()->create([   
         'message' => $request->message ? $request->message : 'image',
         'type' => 'image'
       ]);


       if($request->has('file')){
        $path = Storage::putFile('files', $request->file('file'));
        $url = base_path().'/storage/app/'.$path;
            $message->attachments()->create([
                'path' => $url
            ]);
        }

        broadcast(new MessageSent($message->load('user' ,'attachments')))->toOthers();
        return ['status' => 'success'];
    }
}
