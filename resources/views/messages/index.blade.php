@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div id="app">
  
<!--msb: main sidebar-->

<!--main content wrapper-->
<div class="mcw">
  <!--navigation here-->
  <!--main content view-->
  <div class="cv">
    <div>
     <div class="inbox">
       <div class="inbox-sb">
         
       </div>
       <div class="inbox-bx container-fluid">
         <div class="row">
           <div class="col-md-2">
             <ul>
               <li><a href="{{ route('messages.inbox') }}">Inbox ({{auth()->user()->inbox_count}})</a></li>
               <li><a href="{{ route('messages.sent') }}">Sent ({{auth()->user()->sent_count}})</a></li>
               <li><a href="{{ route('messages.create') }}">Compose</a></li>
               <li><a href="{{ route('messages.trash') }}">Trash</a></li>
             </ul>
           </div>
           <div class="col-md-10">
             <table class="table table-stripped">
               <tbody>
                @foreach($messages as $message)
                 <tr>
                    @if(Illuminate\Support\Facades\Route::is('messages.inbox'))
                        <td><a type="submit" href="{{ route('messages.create', $message->id) }}"><i class="fa fa-reply" title="Reply"></i></a></td>
                    @endif
                    @if(!Illuminate\Support\Facades\Route::is('messages.trash'))
                      @can('delete', $message)
                        <td>
                          <form method="POST" action="{{ route('messages.destroy', $message->id) }}">
                            @csrf
                            @method("DELETE")
                            <button type="submit"><i class="fa fa-trash" title="Delete"></i></button>
                          </form>
                        </td>
                      @endcan
                    @endif
                   <td><b><a title="View" href="{{ route('messages.show', $message) }}" style="font-weight: {{($message->read) ? 'normal' : 'bold' }}">{{\Illuminate\Support\Str::limit($message->subject, 20, $end="...")}}</a></b></td>
                   <td><b>
                      <a title="View" style="font-weight: {{($message->read) ? 'normal' : 'bold' }}" href="{{ route('messages.show', $message) }}">{{\Illuminate\Support\Str::limit($message->message, 20, $end="...")}}</a></b>
                    </td>
                   <td>{{ $message->composer_name }}</td>
                   <td>{{\Carbon\Carbon::parse($message->created_at)->diffForHumans()}}</td>
                 </tr>
                 @endforeach
               </tbody>
             </table>
           </div>
         </div>
       </div>
     </div>
    </div>
  </div>
</div>
@endsection