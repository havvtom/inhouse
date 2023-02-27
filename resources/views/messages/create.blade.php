@extends('layouts.app')

@section('content')
<div class="container py-4">
  <!-- Bootstrap 5 starter form -->
  <form id="contactForm" data-sb-form-api-token="API_TOKEN" method="POST" action="{{ route('messages.store') }}">
    @csrf
    <!-- Name input -->
    <div class="form-group mb-3">
        <label for="demo_overview" class="form-label" >Select recipient</label>
        <select class="form-select" aria-label="Default select example" name="sending_to_id">
            <option value="" selected>Open this select menu</option>
            
              @if(isset($replying_to))
                <option value="{{ $replying_to->id }}" selected>{{$replying_to->name}}</option>
              @else
                @foreach($users as $user)
                  <option  {{ auth()->user()->name == $user->name ? 'disabled' : '' }} value="{{ $user->id}}">{{$user->name}}</option> 
                @endforeach
              @endif       
        </select>
        @if ($errors->has('sending_to_id'))
            <span class="text-danger">{{ $errors->first('sending_to_id') }}</span>
        @endif
    </div>

    <!-- Subject input -->
    <div class="mb-3">
      <label class="form-label" for="subject">Subject</label>
      @if(isset($replying_to))
        <input class="form-control" id="subject" type="text" name="subject" placeholder="Subject" data-sb-validations="required" value="RE: {{ $message->subject }}" />
      @else
      <input class="form-control" id="subject" type="text" name="subject" placeholder="Subject" data-sb-validations="required" value="{{ old('subject') }}" />
      @endif
        @if ($errors->has('subject'))
            <span class="text-danger">{{ $errors->first('subject') }}</span>
        @endif

    </div>

    <!-- Message input -->
    <div class="mb-3">
      <label class="form-label" for="message">Message</label>
      <textarea class="form-control" name="message" id="message" type="text" placeholder="Message" style="height: 10rem;" data-sb-validations="required">{{old('message')}}</textarea>
        @if ($errors->has('message'))
            <span class="text-danger">{{ $errors->first('message') }}</span>
        @endif
    </div>

    <!-- Form submit button -->
    <div class="row">
      <div class="col-md-6">
        <button class="btn btn-primary btn-lg" id="submitButton" type="submit">Submit</button>
      </div>
      <div class="col-md-6">
        <a href="{{ route('messages.inbox') }}" class="btn btn-secondary btn-lg pull-right" id="submitButton" type="submit">Cancel</a>
      </div>
    </div>
  </form>
</div>
@endsection
