@extends('home.index')
@section('content')

<div class="container">
    <div class="row ">
        <div class="col">
            <div class="container">
                <div class="row justify-content-between">
                    <h4>
                        {{$publication->names}}
                    </h4>
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
                            <a class="text-info h6" href="{{route('profile',$comment->user_id)}}">
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
                                <input class="btn btn-info" type="submit" value="Comentar">
                            </div>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

@endsection