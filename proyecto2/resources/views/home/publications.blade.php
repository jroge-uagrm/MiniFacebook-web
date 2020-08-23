@extends('home.index')
@section('content')
<div class="container">
    <div class="row">
        <div class="col">
            <h5>¿Quieres publicar algo?</h5>
        </div>
    </div>
    <div class="row border-bottom border-info my-3">
        <form class="col" action="{{route('publications.new')}}" method="post">
            {{csrf_field()}}
            <textarea class="form-control rounded" name="content" rows="2" placeholder="Escribe algo..."></textarea>
            {!!$errors->first('content','<small class="text-danger font-weight-bold">:message</small>')!!}
            <div class="float-right mt-1 mb-3">
                <button type="submit" class="btn btn-info badge badge-info">
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
                        <div class="row justify-content-between mb-2">
                            <div class="col-md-2">
                                <div class="row align-items-center">
                                    <div class="col-6 p-0">
                                        <img src="{{route('profile_picture',$publication->user_id)}}" width="100%"
                                            height="100%">
                                    </div>
                                    <div class="col p-0 pl-2">
                                        <a class="text-info h6" href="{{route('profile',$publication->user_id)}}">
                                            {{$publication->names}}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <small class="text-muted">
                                {{Carbon\Carbon::parse($publication->created_at)->locale('es_ES')->isoFormat('LLLL')}}
                            </small>
                        </div>
                        <div class="row overflow-auto text-justify">
                            <p>
                                {{$publication->content}}
                            </p>
                        </div>
                        <div class="row justify-content-between mt-3">
                            <small class="text-muted">
                                {{count(App\Comment::where('publication_id',$publication->id)->get())}} comentarios
                            </small>
                            @if($publication->user_id==Auth::id())
                            <a href="{{route('publications.delete',$publication->id)}}" class="badge badge-danger">
                                Eliminar publicación
                            </a>
                            @endif
                            <a class="badge badge-info" href="{{route('publications.index',$publication->id)}}"
                                role="button">
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