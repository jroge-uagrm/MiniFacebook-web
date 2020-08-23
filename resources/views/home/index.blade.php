@extends('master')
@section('body')
<?php
$color="success";
if(strpos(Auth::user()->style,"classic")!==false){
    $color="info";
}else if(strpos(Auth::user()->style,"dark")!==false){
    $color="dark";
}
?>
<style>
    .bg-gray {
        background-color: gray;
    }
</style>
<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-{{$color}}  sticky-top">
    <button class="navbar-toggler mb-3" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
        <ul class="navbar-nav col-md-4 col-sm-12 justify-content-start align-items-center">
            <li class="nav-item mx-3">
                <form action="{{route('search')}}" method="post" class="form-inline col-md-9 m-0 p-0">
                    {{csrf_field()}}
                    <div class="form-group form-row">
                        <div class="col-9">
                            <input class="form-control" type="search" name="fullName" placeholder="Buscar usuarios"
                                aria-label="Search">
                        </div>
                        <div class="col">
                            <button class="btn btn-outline-{{$color=='dark'?'light':''}}" type="submit">Buscar</button>
                        </div>
                    </div>
                </form>
            </li>
        </ul>
        <ul class="my-md-0 my-sm-3 navbar-nav col-md-4 col-sm-12 justify-content-center align-items-center">
            <li class="nav-item mx-3">
                <a href="{{route('home')}}"
                    class="btn btn-{{$color=='dark'?'light':($color=='classic'?'info':'warning')}} text-dark border border-dark">
                    <!-- <img src="/images/logo.png" width="30" height="30"> -->
                    Inicio
                </a>
            </li>
        </ul>
        <ul class="navbar-nav col-md-4 col-sm-12 justify-content-end">
            <div class="row align-items-center justify-content-center">
                <li class="nav-item">
                    <img src="{{route('profile_picture',Auth::user()->id)}}" width="30" height="30">
                </li>
                <li class="nav-item mx-3">
                    <a href="{{route('profile',Auth::user()->id)}}" class="text-{{$color=='dark'?'white':'dark'}}">
                        {{Auth::user()->names}}
                    </a>
                </li>
                <!-- CHATS -->
                <li class="nav-item mx-3">
                    <a href="{{route('chats')}}">
                        <!-- <img src="{{ URL::to('images/icon-messages.png') }}" class="text-white"width="30" height="30"> -->
                        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16"
                            class="bi bi-chat-left-text text-{{$color=='dark'?'white':($color=='classic'?'dark':'danger')}}"
                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M14 1H2a1 1 0 0 0-1 1v11.586l2-2A2 2 0 0 1 4.414 11H14a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM2 0a2 2 0 0 0-2 2v12.793a.5.5 0 0 0 .854.353l2.853-2.853A1 1 0 0 1 4.414 12H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                            <path fill-rule="evenodd"
                                d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5zM3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6zm0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z" />
                        </svg>
                    </a>
                    @if(session()->has('chats'))
                    <div class="dropdown-menu dropdown-menu-right col-8 p-0 show" id="divmessages">
                        <div class="list-group rounded">
                            @forelse(session()->get('chats') as $chat)
                            <a href="{{route('chat.index',$chat->id)}}" class="list-group-item list-group-item-action">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-3 p-0">
                                            <img src="{{route('profile_picture',$chat->id)}}" width="100%"
                                                height="100%">
                                        </div>
                                        <div class="col p-0">
                                            <div class="container">
                                                <div class="row w-100">
                                                    <div class="col">
                                                        <h6>{{$chat->names}}</h6>
                                                        {{$chat->updated_at->diffForHumans()}}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @empty
                            <div class="list-group-item">
                                No tiene chats
                            </div>
                            @endforelse
                        </div>
                    </div>
                    @endif
                </li>
                <!-- FRIEND REQUEST -->
                <li class="nav-item mx-3">
                    <a href="{{route('friendRequest.allMine')}}">
                        <!-- <img src="{{ URL::to('images/icon-friends.png') }}" width="30" height="30"> -->
                        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16"
                            class="bi bi-people text-{{$color=='dark'?'white':($color=='classic'?'dark':'danger')}}"
                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M15 14s1 0 1-1-1-4-5-4-5 3-5 4 1 1 1 1h8zm-7.995-.944v-.002.002zM7.022 13h7.956a.274.274 0 0 0 .014-.002l.008-.002c-.002-.264-.167-1.03-.76-1.72C13.688 10.629 12.718 10 11 10c-1.717 0-2.687.63-3.24 1.276-.593.69-.759 1.457-.76 1.72a1.05 1.05 0 0 0 .022.004zm7.973.056v-.002.002zM11 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zM6.936 9.28a5.88 5.88 0 0 0-1.23-.247A7.35 7.35 0 0 0 5 9c-4 0-5 3-5 4 0 .667.333 1 1 1h4.216A2.238 2.238 0 0 1 5 13c0-1.01.377-2.042 1.09-2.904.243-.294.526-.569.846-.816zM4.92 10c-1.668.02-2.615.64-3.16 1.276C1.163 11.97 1 12.739 1 13h3c0-1.045.323-2.086.92-3zM1.5 5.5a3 3 0 1 1 6 0 3 3 0 0 1-6 0zm3-2a2 2 0 1 0 0 4 2 2 0 0 0 0-4z" />
                        </svg>
                    </a>
                    @if(session()->has('friendRequests'))
                    <div class="dropdown-menu dropdown-menu-right col-8 p-0 show" id="divfriendrequests">
                        <div class="list-group rounded">
                            @forelse(session()->get('friendRequests') as $friendRequest)
                            <div class="list-group-item list-group-item-action">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-3 p-0">
                                            <a href="{{route('profile',$friendRequest->id)}}">
                                                <img src="{{route('profile_picture',$friendRequest->id)}}" width="100%"
                                                    height="100%">
                                            </a>
                                        </div>
                                        <div class="col p-0">
                                            <div class="container">
                                                <div class="row w-100">
                                                    <div class="col">
                                                        <a href="{{route('profile',$friendRequest->id)}}"
                                                            class="text-dark font-weight-bold">
                                                            {{$friendRequest->names}} <br>
                                                            {{$friendRequest->last_names}}
                                                        </a>
                                                        <a href="{{route('friendRequest.accept',$friendRequest->id)}}"
                                                            class="badge badge-info">
                                                            Aceptar
                                                        </a>
                                                        <a href="{{route('friendRequest.reject',$friendRequest->id)}}"
                                                            class="badge badge-danger">
                                                            Rechazar
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @empty
                            <div class="list-group-item">
                                Sin solicitudes
                            </div>
                            @endforelse
                        </div>
                    </div>
                    @endif
                </li>
                <!-- CONFIGURATIONS AND LOG OUT -->
                <li class="nav-item mx-3">
                    <a type="button" data-toggle="dropdown">
                        <!-- <img src="{{ URL::to('images/icon-configurations.png') }}" width="30" height="30"> -->
                        <svg width="1.5em" height="1.5em" viewBox="0 0 16 16"
                            class="bi bi-tools text-{{$color=='dark'?'white':($color=='classic'?'dark':'danger')}}"
                            fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M0 1l1-1 3.081 2.2a1 1 0 0 1 .419.815v.07a1 1 0 0 0 .293.708L10.5 9.5l.914-.305a1 1 0 0 1 1.023.242l3.356 3.356a1 1 0 0 1 0 1.414l-1.586 1.586a1 1 0 0 1-1.414 0l-3.356-3.356a1 1 0 0 1-.242-1.023L9.5 10.5 3.793 4.793a1 1 0 0 0-.707-.293h-.071a1 1 0 0 1-.814-.419L0 1zm11.354 9.646a.5.5 0 0 0-.708.708l3 3a.5.5 0 0 0 .708-.708l-3-3z" />
                            <path fill-rule="evenodd"
                                d="M15.898 2.223a3.003 3.003 0 0 1-3.679 3.674L5.878 12.15a3 3 0 1 1-2.027-2.027l6.252-6.341A3 3 0 0 1 13.778.1l-2.142 2.142L12 4l1.757.364 2.141-2.141zm-13.37 9.019L3.001 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026z" />
                        </svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right col-6">
                        <a class="dropdown-item" href="{{route('configurations')}}">Configurar perfil</a>
                        @if(Auth::user()->role_id==1)
                        <a class="dropdown-item" href="{{route('admin.info')}}">Reportes y estadísticas</a>
                        @endif
                        <a class="dropdown-item" href="{{route('logout')}}">Cerrar sesión</a>
                    </div>
                </li>
            </div>
        </ul>
    </div>
</nav>
<div class="continer {{$color=='dark'?'bg-gray':''}}" style="height: 89%;">
    <div class="row h-100 w-100 ">
        <!-- FOUND USERS -->
        <div class="col-3 m-2 ml-4 h-100 overflow-auto p-0">
            @if(session()->has('foundUsers'))
            <h5 class="text-center">Usuarios encontrados</h5>
            <ul class="list-group">
                @forelse(session()->get('foundUsers') as $foundUser)
                <a href="{{route('profile',$foundUser->id)}}">
                    <li class="list-group-item list-group-item-action border border-info rounded">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{route('profile_picture',$foundUser->id)}}" class="img-fluid img-thumbnail"
                                    alt="Responsive image">
                            </div>
                            <div class="col">
                                <h7>{{$foundUser->names}}</h7><br>
                                <h7>{{$foundUser->last_names}}</h7>
                            </div>
                        </div>
                    </li>
                </a>
                @empty
                <div class="row">
                    <div class="col text-center">
                        <h7 class="">
                            Ninguno
                        </h7>
                    </div>
                </div>
                @endforelse
            </ul>
            @else
            <h5 class="text-center">Busca más usuarios para conectarte con ellos</h5>
            @endif
        </div>
        <!-- CONTENT -->
        <div class="col-6 bg-light h-100 overflow-auto border border-{{$color=='dark'?'dark':'info'}}">
            @section('content')
            @show
        </div>
        <!-- ONLINE CONTACTS -->
        <div class="col h-100 overflow-auto">
            <h5 class="text-center">Contactos</h5>
            <?php
            $contacts=App\Contact::where('user_a',Auth::id())
            ->join('users','users.id','contacts.user_b')
            ->where([
                ['contacts.user_b','<>',Auth::id()],
                ['users.role_id','<>','3'],
            ])
            ->get();
            ?>
            <ul class="list-group">
                @forelse($contacts as $contact)
                <a href="{{route('profile',$contact->id)}}">
                    <li class="list-group-item list-group-item-action border border-info rounded">
                        <div class="row">
                            <div class="col-3 p-0">
                                <a href="{{route('profile',$contact->id)}}">
                                    <img src="{{route('profile_picture',$contact->id)}}" width="100%" height="100%">
                                </a>
                            </div>
                            <div class="col p-0">
                                <div class="container">
                                    <div class="row w-100">
                                        <div class="col">
                                            <a href="{{route('profile',$contact->id)}}"
                                                class="text-dark font-weight-bold">
                                                {{$contact->names}} <br>
                                                {{$contact->last_names}}
                                            </a>
                                            <br>
                                            <div class="container">
                                                <div class="row">
                                                    <div class="col p-0">
                                                        <a href="{{route('chat.index',$contact->id)}}"
                                                            class="badge badge-info">
                                                            Abrir chat
                                                        </a>
                                                    </div>
                                                    <div class="col p-0">
                                                        <a href="{{route('friend.delete',$contact->id)}}"
                                                            class="badge badge-danger">
                                                            Eliminar contacto
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </li>
                </a>
                @empty
                <div class="row">
                    <div class="col text-center">
                        <h7 class="">
                            No tienes contactos
                        </h7>
                    </div>
                </div>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection