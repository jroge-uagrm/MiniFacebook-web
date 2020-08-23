@extends('master')
@section('body')
<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light bg-info sticky-top">
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
                            <button class="btn btn-outline-dark" type="submit">Buscar</button>
                        </div>
                    </div>
                </form>
            </li>
        </ul>
        <ul class="my-md-0 my-sm-3 navbar-nav col-md-4 col-sm-12 justify-content-center align-items-center">
            <li class="nav-item mx-3">
                <a href="{{route('home')}}" class="btn btn-info text-dark border border-dark">
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
                    <a href="{{route('profile',Auth::user()->id)}}" class="text-dark">
                        {{Auth::user()->names}}
                    </a>
                </li>
                <!-- CHATS -->
                <li class="nav-item mx-3">
                    <a href="{{route('chats')}}">
                        <img src="{{ URL::to('images/icon-messages.png') }}" width="30" height="30">
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
                        <img src="{{ URL::to('images/icon-friends.png') }}" width="30" height="30">
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
                        <img src="{{ URL::to('images/icon-configurations.png') }}" width="30" height="30">
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
<div class="continer" style="height: 88%;">
    <div class="row h-100 w-100">
        <!-- FOUND USERS -->
        <div class="col-3 m-2 ml-4 h-100 overflow-auto">
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
        <div class="col-6 bg-light h-100 overflow-auto border border-info">
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