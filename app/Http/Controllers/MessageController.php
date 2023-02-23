<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Http\Requests\MessageRequest;
use Carbon\Carbon;

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
        $messages = Message::where('sending_to_id', auth()->id())->get();

        //Admin users have access to all the messages
        if(auth()->user()->roles->contains('name', 'admin')){
            $messages = Message::where('created_by_id', '<>', auth()->id())->orderBy('created_at', 'DESC')->get();
        }

        return view('messages.index', compact('messages'));
    }

    public function sent()
    {
        $messages = Message::where('created_by_id', auth()->id())->orderBy('created_at', 'DESC')->get();
        
        return view('messages.index', compact('messages'));
    }

    public function trash(){

        $messages = Message::onlyTrashed()->where('created_by_id', auth()->id())->get();

        return view('messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $id = null)
    {
        $users = User::all();

        //if $id is provided then we are creating a reply
        if( $id ){

            $message = Message::findOrFail($id);

            //Check if the user has permissions to reply to the message
            //Only admin or the recipient of the message are allowed to reply
            if ($request->user()->cannot('reply', $message)) {
                abort(403);
            }
            
            //Get the composer of the message and pass it to the view
            $composer_id = $message->created_by_id;

            $replying_to = User::find($composer_id);

            return view('messages.create', compact(['users', 'replying_to', 'message']));

        }
        
        return view('messages.create', compact('users'));
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MessageRequest $request)
    {
        //Validate
        $message = new Message;

        $message->created_by_id = $request->user()->id;
        $message->sending_to_id = $request->sending_to_id ?? NULL;
        $message->subject = $request->subject;
        $message->message = $request->message;

        $message->save();

        return redirect()->route('messages.inbox');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Message $message)
    {
        if ($request->user()->cannot('view', $message)) {
            abort(403);
        }

        //Record as seen if the authenticated user is the recipient
        if(auth()->id() == $message->sending_to_id){

            $message->seen = Carbon::now();

            $message->save();
        }        

        return view('messages.show', compact('message'));
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
    public function destroy(Request $request, Message $message)
    {
        if ($request->user()->cannot('delete', $message)) {
            abort(403);
        }

        $message->delete();

        return redirect()->route('messages.inbox');
    }
}
