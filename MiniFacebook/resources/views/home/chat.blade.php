@extends('home.index')
@section('content')

<div class="container-fluid h-100">
    <div class="row">
        <a class="text-dark font-weight-bold mx-auto h3" href="{{route('profile',$user->id)}}">
            {{$user->names}} {{$user->last_names}}
        </a>
    </div>
    <div class="row overflow-auto" style="height: 85%;" id="div_scroll">
        <div class="col">
            <div id="chat_content" class="container-fluid">
                @foreach($messages as $message)
                <div class="row">
                    <div class="col-9 my-2 {{$message['sender']==Auth::user()->id?'ml-auto':''}}">
                        <label
                            class="border border-dark rounded p-1 {{$message['sender']==Auth::id()?'float-right bg-info':'bg-white'}}">
                            {{$message['content']}}
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <form action="{{route('chat.sendMessage')}}" method="post">
        {{csrf_field()}}
        <input type="hidden" id="receiver" name="receiverId" value="{{$user->id}}">
        <div class="row">
            <div class="col-10">
                <input name="content" id="content" class="form-control border border-dark" type="text" value="" />
            </div>
            <button id="sendBtn" type="submit" class="btn btn-info">
                Enviar
            </button>
        </div>
    </form>
</div>
<script>
    var div_scroll = document.getElementById('div_scroll');
    div_scroll.scrollTop = div_scroll.scrollHeight;
    function manageMessage(data) {
        if (data.data.receiverId == "{{Auth::id()}}") {
            let chatContent = document.getElementById("chat_content");
            var div_row = document.createElement('div');
            div_row.className = "row";
            var div_col = document.createElement('div');
            div_col.className = "col-9 my-2";
            var label = document.createElement('label');
            label.className = "border border-dark rounded p-1 bg-white";
            var message = document.createTextNode(data.data.content);
            label.appendChild(message);
            div_col.appendChild(label);
            div_row.appendChild(div_col);
            chatContent.appendChild(div_row);
            var div_scroll = document.getElementById('div_scroll');
            div_scroll.scrollTop = div_scroll.scrollHeight;
        }
    }
</script>
@endsection