@extends('home.index')
@section('content')

<div class="container-fluid h-100">
    <div class="row my-3">
        <h3 class="font-weight-bold mx-auto">
            {{$user->names}} {{$user->paternal_surname}} {{$user->maternal_surname}}
        </h3>
    </div>
    <div class="row h-75">
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
    <div class="row">
        <div class="col-10">
            <textarea class="form-control border border-dark" type="text" rows="1"></textarea>
        </div>
        <a class="btn btn-info">
            Enviar
        </a>
    </div>
</div>
@endsection