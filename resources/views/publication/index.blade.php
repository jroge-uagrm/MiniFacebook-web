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
            <p class="form-control border border-dark rounded">
                {{$publication->content}}
            </p>
        </div>
    </div>
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
                            {{$comment->content}}
                        </div>
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

@endsection