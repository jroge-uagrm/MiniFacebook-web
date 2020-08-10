@extends('home.index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h5>¿Quieres publicar algo?</h5>
        </div>
    </div>
    <div class="row">
        <form class="col" action="{{route('publications.new')}}" method="post">
            {{csrf_field()}}
            <textarea class="form-control border border-dark rounded" name="content" rows="2"
                placeholder="Escribe algo..."></textarea>
            <div class="float-right mt-1 mb-3">
                <button type="submit" class="btn btn-sm btn-info">
                    Publicar
                </button>
            </div>
        </form>
    </div>
    <div class="row">
        <div class="col">
            <ul class="list-group ">
                @forelse($publications as $publication)
                <li class="list-group-item list-group-item-action my-2 border boder-info rounded">
                    <div class="container">
                        <div class="row justify-content-between">
                            <a class="text-info h6" href="{{route('profile',$publication->user_id)}}">
                                {{$publication->names}}
                            </a>
                            <small class="text-muted">
                                {{Carbon\Carbon::parse($publication->created_at)->locale('es_ES')->isoFormat('LLLL')}}
                            </small>
                        </div>
                        <div class="row">
                            <label>{{$publication->content}}</label>
                        </div>
                        <div class="row justify-content-between mt-3">
                            <small class="text-muted">
                                {{count(App\Comment::where('publication_id',$publication->id)->get())}} comentarios
                            </small>
                            <a class="btn btn-outline-info btn-sm"
                                href="{{route('publications.index',$publication->id)}}" role="button">
                                Ver publicación
                            </a>
                        </div>
                    </div>
                </li>
                @empty
                <div class="list-group-item">
                    No hay publicaciones para mostrar
                </div>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection