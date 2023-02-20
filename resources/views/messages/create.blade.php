@extends('layouts.app')

@section('content')
<div class="container py-4">
  <!-- Bootstrap 5 starter form -->
  <form id="contactForm" data-sb-form-api-token="API_TOKEN" method="POST" action="{{ route('messages.store') }}">
    @csrf
    <!-- Name input -->
    <div class="form-group mb-3">
        <label for="demo_overview" class="form-label" >Select recipient</label>
        <select class="form-select" aria-label="Default select example" name="user_id">
            <option selected>Open this select menu</option>
            @foreach($users as $user)
                <option  {{ auth()->user()->name == $user->name ? 'disabled' : '' }} value="{{ $user->id }}">{{$user->name}}</option>        
            @endforeach
        </select>
    </div>

    <!-- Subject input -->
    <div class="mb-3">
      <label class="form-label" for="subject">Subject</label>
      <input class="form-control" id="subject" type="text" name="subject" placeholder="Subject" data-sb-validations="required" />
        @if ($errors->has('subject'))
            <span class="text-danger">{{ $errors->first('subject') }}</span>
        @endif

    </div>

    <!-- Message input -->
    <div class="mb-3">
      <label class="form-label" for="message">Message</label>
      <textarea class="form-control" name="message" id="message" type="text" placeholder="Message" style="height: 10rem;" data-sb-validations="required"></textarea>
        @if ($errors->has('message'))
            <span class="text-danger">{{ $errors->first('message') }}</span>
        @endif
    </div>

    <!-- Form submissions success message -->
    <div class="d-none" id="submitSuccessMessage">
      <div class="text-center mb-3">Form submission successful!</div>
    </div>

    <!-- Form submissions error message -->
    <div class="d-none" id="submitErrorMessage">
      <div class="text-center text-danger mb-3">Error sending message!</div>
    </div>

    <!-- Form submit button -->
    <div class="d-grid">
      <button class="btn btn-primary btn-lg" id="submitButton" type="submit">Submit</button>
    </div>

  </form>
</div>
@endsection