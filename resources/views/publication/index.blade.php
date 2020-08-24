@extends('home.index')
@section('content')
<?php
$color="success";
if(strpos(Auth::user()->style,"classic")!==false){
    $color="info";
}else if(strpos(Auth::user()->style,"dark")!==false){
    $color="dark";
}
?>
<div class="container">
    <div class="row ">
        <div class="col">
            <div class="container">
                <div class="row justify-content-between mb-2">
                    <div class="col-md-2">
                        <div class="row align-items-center">
                            <div class="col-6 p-0">
                                <img src="{{route('profile_picture',$publication->user_id)}}" width="100%"
                                    height="100%">
                            </div>
                            <div class="col p-0 pl-2">
                                <a class="text-{{$color}} h6" href="{{route('profile',$publication->user_id)}}">
                                    {{$publication->names}}
                                </a>
                            </div>
                        </div>
                    </div>
                    <small class="text-muted">
                        {{Carbon\Carbon::parse($publication->created_at)->locale('es_ES')->isoFormat('LLLL')}}
                    </small>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p id="oldContent" name="{{$publication->content}}"
                class="form-control border border-dark rounded collapse show">
                {{$publication->content}}
            </p>
            <form id="newContent" class="collapse" action="{{route('publications.edit')}}" method="post">
                {{csrf_field()}}
                <input type="hidden" name="publication_id" value="{{$publication->id}}">
                <textarea id="content" name="content" class="form-control"></textarea>
                <button class="float-right btn badge badge-{{$color}} my-2">Guardar</button>
            </form>
        </div>
    </div>
    @if($publication->user_id==Auth::id())
    <div class="container">
        <div class="row justify-content-end">
            <a href="{{route('publications.delete',$publication->id)}}" class="badge badge-danger">
                Eliminar publicación
            </a>
            <button class="btn badge badge-warning" id="btnEdit">
                Editar publicación
            </button>
        </div>
    </div>

    @endif
    <div class="row">
        <div class="col">
            <ul class="list-group ">
                @forelse($comments as $comment)
                <li class="list-group-item list-group-item-action my-2 border boder-info rounded">
                    <div class="container">
                        <div class="row justify-content-between">
                            <a class="text-{{$color}} h6" href="{{route('profile',$comment->user_id)}}">
                                {{$comment->names}}
                            </a>
                            <small class="text-dark">
                                {{Carbon\Carbon::parse($comment->created_at)->locale('es_ES')->isoFormat('LLLL')}}
                            </small>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p class="oldComment collapse show" name="{{$comment->content}}" id="{{$comment->id}}">
                                    {{$comment->content}}
                                </p>
                                <form id="newComment{{$comment->id}}" class="collapse"
                                    action="{{route('comments.edit')}}" method="post">
                                    {{csrf_field()}}
                                    <input type="hidden" name="comment_id" value="{{$comment->id}}">
                                    <textarea id="content" name="content" class="form-control"></textarea>
                                    <button class="float-right btn badge badge-{{$color}} my-2">Guardar</button>
                                </form>
                            </div>
                        </div>
                        @if(Auth::id()==$comment->user_id)
                        <div class="row justify-content-end">
                            <a href="{{route('comments.delete',$comment->id)}}" class="badge badge-danger">
                                Eliminar comentario
                            </a>
                            <button class="btn badge badge-warning btnComment" id="{{$comment->id}}">
                                Editar comentario
                            </button>
                        </div>
                        @endif
                    </div>
                </li>
                @empty
                <div>
                    No hay comentarios para mostrar
                </div>
                @endforelse
                <li class="px-0 list-group-item list-group-item-action my-2 border border-light bg-light">
                    <div class="container">
                        <form action="{{route('comments.new')}}" method="post">
                            <div class="row">
                                {{csrf_field()}}
                                <input type="hidden" name="publication_id" value="{{$publication->id}}">
                                <input type="text" name="content" placeholder="Escribe algo..."
                                    class="form-control col-10 bg-light">
                                <input class="btn btn-{{$color}}" type="submit" value="Comentar">
                            </div>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"
    integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script>
    $('#btnEdit').click(function () {
        let content = $('#oldContent').attr('name')
        if ($('#oldContent').hasClass('show')) {
            $('#oldContent').removeClass('show')
            $('#newContent').addClass('show')
            $('#newContent' + ' #content').val(content)
        } else {
            $('#oldContent').addClass('show')
            $('#newContent').removeClass('show')
        }
    })
    $('.btnComment').click(function () {
        let id = $(this).attr('id')
        let content = $('#'+id).attr('name')
        if ($('#' + id).hasClass('show')) {
            $('#' + id).removeClass('show')
            $('#newComment' + id).addClass('show')
            $('#newComment' + id + ' #content').val(content)
        } else {
            $('#'+id).addClass('show')
            $('#newComment'+id).removeClass('show')
        }
    })
</script>
@endsection