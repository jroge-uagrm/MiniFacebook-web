@extends('master')
@section('body')
<nav class="navbar navbar-expand-lg navbar-light bg-info sticky-top">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav col-4 justify-content-start">
            <li class="nav-item mx-3">
                <form action="{{route('search')}}" method="post" class="form-inline col-9 m-0 p-0">
                    {{csrf_field()}}
                    <div class="form-group form-row">
                        <input class="form-control" type="search" name="fullName" placeholder="Buscar usuarios"
                            aria-label="Search">
                        <button class="btn btn-outline-dark" type="submit">Buscar</button>
                    </div>
                </form>
            </li>
        </ul>
        <ul class="navbar-nav col-4 justify-content-center">
            <li class="nav-item mx-3">
                <a href="{{route('home')}}" class="text-dark">
                    <img src="/images/logo.png" width="30" height="30">
                </a>
            </li>
        </ul>
        <ul class="navbar-nav col-4 justify-content-end">
            <li class="nav-item">
                <img src="{{route('profile_picture',Auth::user()->id)}}" width="30" height="30">
            </li>
            <li class="nav-item mx-3">
                <a href="{{route('profile',Auth::user()->id)}}" class="text-dark">
                    {{Auth::user()->names}}
                </a>
            </li>
            <li class="nav-item mx-3">
                <a href="{{route('chats')}}">
                    <img src="/images/icon-messages.png" width="30" height="30">
                </a>
                @if(session()->has('chats'))
                <div class="dropdown-menu dropdown-menu-right col-8 p-0 show" id="divmessages">
                    <div class="list-group rounded">
                        @forelse(session()->get('chats') as $chat)
                        <a href="{{route('chat',$chat->id)}}" class="list-group-item list-group-item-action">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-3 p-0">
                                        <img src="{{route('profile_picture',1)}}" width="100%" height="100%">
                                    </div>
                                    <div class="col p-0">
                                        <div class="container">
                                            <div class="row w-100">
                                                <div class="col">
                                                    {{$chat->names}} {{$chat->paternal_surname}}
                                                    {{$chat->maternal_surname}}
                                                </div>
                                            </div>
                                            <div class="row w-100">
                                                <div class="col">
                                                    Mensaje
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
            <li class="nav-item mx-3">
                <a href="{{route('friendRequest.allMine')}}">
                    <img src="/images/icon-friends.png" width="30" height="30">
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
                                                    <small>
                                                        <a href="{{route('profile',$friendRequest->id)}}"
                                                            class="text-dark font-weight-bold">
                                                            {{$friendRequest->names}}
                                                            {{$friendRequest->last_names}}
                                                        </a>
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="row w-100 mt-2">
                                                <div class="col">
                                                    <a href="{{route('friendRequest.accept',$friendRequest->id)}}"
                                                        class="btn btn-sm btn-info">
                                                        Aceptar
                                                    </a>
                                                </div>
                                                <div class="col">
                                                    <a href="{{route('friendRequest.reject',$friendRequest->id)}}"
                                                        class="btn btn-sm btn-danger">
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
            <li class="nav-item mx-3">
                <a type="button" data-toggle="dropdown">
                    <img src="/images/icon-configurations.png" width="30" height="30">
                </a>
                <div class="dropdown-menu dropdown-menu-right col-6">
                    <a class="dropdown-item" href="{{route('configurations')}}">Configurar perfil</a>
                    <a class="dropdown-item" href="{{route('logout')}}">Cerrar sesión</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<div class="continer" style="height: 88%;">
    <div class="row h-100 w-100">
        <!-- FOUND USERS -->
        <div class="col-3 m-2 ml-4 h-100">
            @if(session()->has('foundUsers'))
            <h5 class="text-center">Usuarios encontrados</h5>
            <ul class="list-group">
                @foreach(session()->get('foundUsers') as $foundUser)
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
                @endforeach
            </ul>
            @else
            <h5 class="text-center">Busca más usuarios para conectarte con ellos</h5>
            @endif
        </div>
        <!-- CONTENT -->
        <div class="col-6 bg-light h-100">
            @section('content')
            @show
        </div>
        <!-- ONLINE CONTACTS -->
        <div class="col h-100">
            Contactos conectados
        </div>
    </div>
</div>

@endsection