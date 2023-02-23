@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div id="app">
                <div class="row">
                    <div class="col-sm" style="background-color: white; padding-left: 10%; padding-right: 10%">
                        <br></br>
                        <p>
                            {{$message->recipient}},
                        </p>
                        <br></br>
                        <p style="color:red">
                            <b>
                                {{$message->subject}}
                            </b>
                        </p>

                        <p>
                            {{$message->message}}
                        </p>
                        <br></br>
                        <br></br>
                        <p>
                            {{$message->composer_name}}
                        </p>
                    </div>
                </div>

                <br></br>
                
                <div class="row">
                    <div class="col-sm" style="padding-left: 10%; padding-right: 10%; font-size: small">
                        <br></br>
                        <hr>
                        </hr>
                        <br></br>
                        <p style="font-style: italic; text-align: center;">
                            Copyright © 2023 , LLC. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
@endsection