@extends('home.index')
@section('content')

<div class="container-fluid mt-5">
    <div class="row my-3">
        <div class="col-4">
            <img src="{{route('profile_picture',$user->id)}}" width="100%" height="100%">
        </div>
        <div class="col align-self-center">
            <h3>
                {{$user->names}} {{$user->paternal_surname}} {{$user->maternal_surname}}
            </h3>
        </div>
        <div class="position-absolute align-self-end row w-100">
            <div class="col-8 ml-auto">
                @if($user->id!=Auth::user()->id)
                @if($isFriend)
                <a href="{{route('friend.delete',$user->id)}}" class="btn btn-danger">
                    Eliminar
                </a>
                <a href="{{route('chat.index',$user->id)}}" class="btn btn-info">
                    Enviar mensaje
                </a>
                @else
                @if($availableToSendFriendRequest)
                <a href="{{route('friend.request',$user->id)}}" class="btn btn-info">
                    Enviar solicitud
                </a>
                @else
                <a href="#" class="btn btn-info disabled">
                    Solicitud pendiente
                </a>
                @endif
                @endif
                @else
                <a href="{{route('configurations')}}" class="btn btn-info">
                    Editar perfil
                </a>
                @endif
            </div>
        </div>
    </div>
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active text-info" id="home-tab" data-toggle="tab" href="#home"
                role="tab" aria-controls="home" aria-selected="true">
                Información
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-info" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                aria-controls="profile" aria-selected="false">
                Publicaciones
            </a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
            <div class="container">
                <div class="row my-3 border-bottom border-muted">
                    <div class="col-4 text-right">
                        <strong>
                            Nombres:
                        </strong>
                    </div>
                    <div class="col text-left">
                        {{$user->names}}
                    </div>
                </div>
                <div class="row my-3 border-bottom border-muted">
                    <div class="col-4 text-right">
                        <strong>
                            Apellidos:
                        </strong>
                    </div>
                    <div class="col text-left">
                        {{$user->last_names}}
                    </div>
                </div>
                <div class="row my-3 border-bottom border-muted">
                    <div class="col-4 text-right">
                        <strong>
                            Fecha de nacimiento:
                        </strong>
                    </div>
                    <div class="col text-left">
                        {{$user->birthday}}
                    </div>
                </div>
                <div class="row my-3 border-bottom border-muted">
                    <div class="col-4 text-right">
                        <strong>
                            Sexo:
                        </strong>
                    </div>
                    <div class="col text-left">
                        {{$user->sex=='M'?'Masculino':'Femenino'}}
                    </div>
                </div>
                <div class="row my-3 border-bottom border-muted">
                    <div class="col-4 text-right">
                        <strong>
                            Correo:
                        </strong>
                    </div>
                    <div class="col text-left">
                        {{$user->email}}
                    </div>
                </div>
                <div class="row my-3 border-bottom border-muted">
                    <div class="col-4 text-right">
                        <strong>
                            Nro. celular:
                        </strong>
                    </div>
                    <div class="col text-left">
                        {{$user->phone_number??'No tiene'}}
                    </div>
                </div>
                <div class="row my-3">
                    <div class="col-4 text-right">
                        <strong>
                            Se unió:
                        </strong>
                    </div>
                    <div class="col text-left">
                        {{$user->created_at->diffForHumans()}}
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <ul class="list-group">
                @forelse($publications as $publication)
                <li class="list-group-item list-group-item-action my-2 border boder-info rounded">
                    <div class="container">
                        <div class="row justify-content-between">
                            <a class="text-info h6" href="{{route('profile',$publication->user_id)}}">
                                {{$user->names}}
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