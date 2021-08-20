<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use App\Events\ChatEvent;
use Illuminate\Http\Request;
use App\Events\PrivateChatEvent;

class ChatController extends Controller
{
    public function chat()
    {
        return view('chat');
    }

    public function broadcast(Request $request)
    {

        $color = 'primary';
        $this->saveToSession($request);
        event(new ChatEvent($request->message, Auth::user(), $color));
    }

    public function broadcastPrivate(Request $request)
    {

        $chattingWith =  User::where('name', $request->chattingWith)->first();
        event(new PrivateChatEvent($request->message, Auth::user(), $chattingWith));
    }

    public function saveToSession(Request $request)
    {

        session()->put('chat', $request->chat);
    }

    public function getSessionMessages()
    {
        return session()->get('chat');
    }

    public function deleteSession()
    {
        session()->forget('chat');
    }
}
