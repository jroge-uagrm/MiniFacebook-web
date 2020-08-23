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
                <button class="btn btn-danger" data-toggle="modal" data-target="#deleteContactModal">
                    Eliminar
                </button>
                <a href="{{route('chat.index',$user->id)}}" class="btn btn-{{$color}}">
                    Enviar mensaje
                </a>
                @else
                @if($availableToSendFriendRequest)
                <a href="{{route('friend.request',$user->id)}}" class="btn btn-{{$color}}">
                    Enviar solicitud
                </a>
                @else
                <a href="#" class="btn btn-{{$color}} disabled">
                    Solicitud pendiente
                </a>
                @endif
                @endif
                @else
                <a href="{{route('configurations')}}" class="btn btn-{{$color}}">
                    Editar perfil
                </a>
                @endif
            </div>
        </div>
    </div>
    <!-- Tabs -->
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active text-{{$color}}" id="home-tab" data-toggle="tab" href="#home" role="tab"
                aria-controls="home" aria-selected="true">
                Información
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-{{$color}}" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                aria-controls="profile" aria-selected="false">
                Publicaciones
            </a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <!-- INFORMATION -->
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
        <!-- PUBLICATIONS -->
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            <ul class="list-group">
                @if($isFriend)
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
                        <div class="row overflow-auto text-justify">
                            <p>{{$publication->content}}</p>
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
                @else
                <li class="list-group-item list-group-item-action border boder-info rounded">
                    <div class="container">
                        <div class="row justify-content-center">
                            <p class="text-center">
                                Solo los contactos de <strong>&nbsp{{$user->names}}&nbsp</strong> pueden ver sus
                                publicaciones
                            </p>
                        </div>
                    </div>
                </li>
                @endif
            </ul>
        </div>
    </div>
</div>
<!-- deleteContactModal -->
<div class="modal fade" id="deleteContactModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Eliminar contacto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Este usuario será removido de tu lista de contactos.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-info" data-dismiss="modal">
                    Cancelar
                </button>
                <a type="button" class="btn btn-danger" href="{{route('friend.delete',$user->id)}}">
                    Eliminar contacto
                </a>
            </div>
        </div>
    </div>
</div>
@endsection