@extends('home.index')
@section('content')

<div class="container-fluid">
    <div class="row my-3">
        <h3 class="font-weight-bold mx-auto">
            {{$user->names}} {{$user->paternal_surname}} {{$user->maternal_surname}}
        </h3>
    </div>
    <div class="row">
        <div class="col">
            <div class="container-fluid">
                @foreach($messages as $message)
                <div class="row">
                    <div class="col-9 my-2 {{$message->sender==Auth::user()->id?'ml-auto':''}}">
                        @if($message->content_type==="text")
                        <label
                            class="border border-dark rounded p-1 {{$message->sender==Auth::user()->id?'float-right bg-info':'bg-white'}}">
                            {{$message->text_content}}
                        </label>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection