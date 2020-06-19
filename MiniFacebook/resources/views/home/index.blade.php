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
                        <button class="btn btn-warning" type="submit">Buscar</button>
                    </div>
                </form>
            </li>
        </ul>
        <ul class="navbar-nav col-4 justify-content-center">
            <li class="nav-item mx-3">
                <a href="{{route('home')}}" class="text-dark">
                    <!-- <img src="/images/icon-app.png" width="30" height="30"> -->
                    Icono
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
                <a href="#">
                    <img src="/images/icon-messages.png" width="30" height="30">
                </a>
            </li>
            <li class="nav-item mx-3">
                <a data-toggle="dropdown" href="#">
                    <img src="/images/icon-friends.png" width="30" height="30">
                </a>
                <div class="dropdown-menu dropdown-menu-right p-0">
                    @forelse($friendRequests as $friendRequest)
                    <div class="container-fluid border border-info rounded">
                        <div class="row">
                            <div class="col-3 py-2">
                                <img src="{{route('profile_picture',$friendRequest->id)}}" width="100%" height="100%">
                            </div>
                            <div class="col p-0 mt-3">
                                <a href="{{route('profile',$friendRequest->id)}}" class="dropdown-item container-fluid p-0">
                                    {{$friendRequest->names}} {{$friendRequest->paternal_surname}}
                                    {{$friendRequest->maternal_surname}}
                                </a>
                            </div>
                            <div class="position-absolute align-self-end row w-100">
                                <div class="col-9 ml-auto mb-3">
                                    <a href="{{route('friendRequest.accept',$friendRequest->id)}}" class="btn btn-sm btn-info">
                                        Aceptar
                                    </a>
                                    <a href="{{route('friendRequest.reject',$friendRequest->id)}}" class="btn btn-sm btn-danger">
                                        Rechazar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <a class="dropdown-item" href="#">
                        No tienes solicitudes
                    </a>
                    @endforelse
                </div>
            </li>
            <li class="nav-item mx-3">
                <a type="button" data-toggle="dropdown">
                    <img src="/images/icon-configurations.png" width="30" height="30">
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{route('configurations')}}">Configurar perfil</a>
                    <a class="dropdown-item" href="{{route('logout')}}">Cerrar sesión</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<div class="continer h-100">
    <div class="row h-100 w-100">
        <!-- FOUND USERS -->
        <div class="col-3 m-2 ml-4">
            @if(session()->has('foundUsers'))
            <h5 class="text-center">Usuarios encontrados</h5>
            <ul class="list-group">
                @foreach(session()->get('foundUsers') as $foundUser)
                <a href="{{route('profile',$foundUser->id)}}">
                    <li class="list-group-item list-group-item-action border border-info">
                        <img src="{{route('profile_picture',$foundUser->id)}}" width="50" height="50">
                        {{$foundUser->names}} {{$foundUser->paternal_surname}} {{$foundUser->maternal_surname}}
                    </li>
                </a>
                @endforeach
            </ul>
            @else
            <h5 class="text-center">Busca más usuarios para conectarte con ellos</h5>
            @endif
        </div>
        <!-- PUBLICATIONS -->
        <div class="col-6 bg-light">
            @section('content')
            @show
        </div>
        <!-- ONLINE CONTACTS -->
        <div class="col">
            Contactos conectados
        </div>
    </div>
</div>

@endsection