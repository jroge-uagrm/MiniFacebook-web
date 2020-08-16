@extends('home.index')
@section('content')

<div class="container-fluid h-100">
    <div class="row justify-content-between align-items-center">
        <a class="text-dark font-weight-bold h4 col-md-8" href="{{route('profile',$user->id)}}">
            {{$user->names}} {{$user->last_names}}
        </a>
        <form action="{{route('chat.search')}}" method="post" class="col-md-4">
            <div class="row">
                <input type="text" name="content" class="form-control col-md-9">
                <input type="hidden" name="user_id" value="{{$user->id}}">
                {{csrf_field()}}
                <button href="#" class="btn  text-info col-md-3" title="Buscar mensajes">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-search" fill="currentColor"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M10.442 10.442a1 1 0 0 1 1.415 0l3.85 3.85a1 1 0 0 1-1.414 1.415l-3.85-3.85a1 1 0 0 1 0-1.415z" />
                        <path fill-rule="evenodd"
                            d="M6.5 12a5.5 5.5 0 1 0 0-11 5.5 5.5 0 0 0 0 11zM13 6.5a6.5 6.5 0 1 1-13 0 6.5 6.5 0 0 1 13 0z" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
    <div class="row overflow-auto" style="height: 85%;" id="div_scroll">
        <div class="col">
            <div id="chat_content" class="container-fluid">
                @if(session()->has('foundMessages'))
                @forelse(session()->get('foundMessages') as $message)
                <div class="row">
                    <div class="col-9 my-2 {{$message->sender==Auth::user()->id?'ml-auto':''}}">
                        <label
                            class="border border-dark rounded p-1 {{$message->sender==Auth::id()?'float-right bg-info':'bg-white'}}">
                            {{$message->content}}
                        </label>
                    </div>
                </div>
                @empty
                <label class="mx-auto">
                    No hay coincidencias
                </label>
                @endforelse
                @else
                @foreach($messages as $message)
                <div class="row {{$message['sender']==Auth::id()?'messageSent':''}}" id="{{$message['id']}}">
                    <div class="col-9 p-0 my-2 {{$message['sender']==Auth::id()?'ml-auto':''}}">
                        <div class="row align-items-center {{$message['sender']==Auth::id()?'justify-content-end':''}}">
                            @if($message['sender']==Auth::id())
                            <a href="#showOptions" class="text-dark">
                                <svg id="deleteMessage{{$message['id']}}" width="1em" height="1em" viewBox="0 0 16 16"
                                    class="collapse text-dark bi bi-trash-fill" fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5a.5.5 0 0 0-1 0v7a.5.5 0 0 0 1 0v-7z" />
                                </svg>
                                <svg id="editMessage{{$message['id']}}" width="1em" height="1em" viewBox="0 0 16 16"
                                    class="collapse text-dark bi bi-pencil" fill="currentColor"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M11.293 1.293a1 1 0 0 1 1.414 0l2 2a1 1 0 0 1 0 1.414l-9 9a1 1 0 0 1-.39.242l-3 1a1 1 0 0 1-1.266-1.265l1-3a1 1 0 0 1 .242-.391l9-9zM12 2l2 2-9 9-3 1 1-3 9-9z" />
                                    <path fill-rule="evenodd"
                                        d="M12.146 6.354l-2.5-2.5.708-.708 2.5 2.5-.707.708zM3 10v.5a.5.5 0 0 0 .5.5H4v.5a.5.5 0 0 0 .5.5H5v.5a.5.5 0 0 0 .5.5H6v-1.5a.5.5 0 0 0-.5-.5H5v-.5a.5.5 0 0 0-.5-.5H3z" />
                                </svg>
                            </a>
                            @endif
                            <label
                                class="ml-2 border border-dark rounded p-1 {{$message['sender']==Auth::id()?'float-right bg-info':'bg-white'}}">
                                {{$message['content']}}
                            </label>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
    @if(session()->has('foundMessages'))
    <div class="row align-items-center">
        <a class="btn btn-info" href="{{route('chat.index',$user->id)}}">
            Volver al chat
        </a>
        <h4 class="mx-auto">Mensajes encontrados</h4>
    </div>
    @else
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
    @endif
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script>
    $('.messageSent').hover(function () {
        let id = $(this).attr('id');
        let editElement = $('#editMessage' + id);
        let deleteElement = $('#deleteMessage' + id);
        editElement.addClass('show');
        deleteElement.addClass('show');
    }, function () {
        let id = $(this).attr('id');
        let editElement = $('#editMessage' + id);
        let deleteElement = $('#deleteMessage' + id);
        editElement.removeClass('show');
        deleteElement.removeClass('show');
    }
    );
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