@extends('home.index')
@section('content')

<div class="container-fluid h-100">
    <div class="row">
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
    <form action="{{route('chat.sendMessage')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" name="receiverId" value="{{$user->id}}">
        <div class="row">
            <div class="col-10">
                <textarea name="text" class="form-control border border-dark" type="text" rows="1"></textarea>
            </div>
            <input type="submit" class="btn btn-info" value="Enviar">
        </div>
    </form>
</div>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;
        var pusher = new Pusher('9b29f0feb3d83af18247', {
            cluster: 'us2'
        });
        var channel = pusher.subscribe('my-channel');
        channel.bind('new-message', function (data) {
            if(data.data.receiverId=="{{Auth::id()}}"){
                alert(data.data.text);
            }
        });
    </script>
@endsection