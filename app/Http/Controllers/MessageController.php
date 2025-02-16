<?php

namespace App\Http\Controllers;

use App\Models\Message;

class MessageController extends Controller
{
    public function index()
    {
        if(!\Auth::user()->hasRole('view-messages')) return back();
        return view('pages.message.index');
    }

    public function view(Message $message)
    {
        if(!\Auth::user()->hasRole('view-messages')) return back();
        return view('pages.message.edit-create',compact('message'));
    }

}

