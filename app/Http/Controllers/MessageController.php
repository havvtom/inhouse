<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }
    /**
     * Display a listing of the resource.
     */
    public function inbox()
    {        
        $inbox = Message::where('sending_to_id', auth()->id())->get();

        //Admin users have access to all the messages
        if(auth()->user()->roles->contains('name', 'admin')){
            $inbox = Message::get();
        }

        dd($inbox);

        return view('messages.index', compact(['inbox' => $inbox]));
    }

    public function sent()
    {
        $sent = Message::where('created_by_id', auth()->id)->get();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all();

        return view('messages.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validate
        $validated = $request->validate([
            'subject' => 'required',
            'message' => 'required',
        ]);

        $message = new Message;

        $message->created_by_id = $request->user()->id;
        $message->message_parent_id = $request->message_parent_id ?? '';
        $message->sending_to_id = $request->sending_to_id ?? '';
        $message->subject = $request->subject;
        $message->message = $request->message;

        $message->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Message $message)
    {
        //
    }
}
