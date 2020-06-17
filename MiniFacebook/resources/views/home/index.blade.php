@extends('master')
@section('body')
<nav class="navbar navbar-expand-lg navbar-light bg-info">
    <a class="navbar-brand" href="home">Icono</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <form class="form-inline my-2 my-lg-0">
                    <input class="form-control mr-sm-2" type="search" placeholder="Buscar amigos" aria-label="Search">
                    <button class="btn btn-warning my-2 my-sm-0" type="submit">Buscar</button>
                </form>
            </li>
        </ul>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="/profile/me" class="text-dark">
                    {{$user->names}}
                </a>
            </li>
            <li class="nav-item mx-3">
                <a href="messages">
                    <img src="/images/icon-messages.png" width="30" height="30">
                </a>
            </li>
            <li class="nav-item mx-3">
                <a href="notifications">
                    <img src="/images/icon-notification.png" width="30" height="30">
                </a>
            </li>
            <li class="nav-item mx-3">
                <a type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img src="/images/icon-arrow-down.png" width="30" height="30">
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="profile">Configurar perfil</a>
                    <a class="dropdown-item" href="logout">Cerrar sesión</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<div class="continer h-75">
    <div class="row h-100">
        <div class="col-3 bg-primary">
            Amigos encontrados
        </div>
        <div class="col-6 bg-success">
            Publicaciones
        </div>
        <div class="col bg-warning">
            Contactos conectados
        </div>
    </div>
</div>

@endsection