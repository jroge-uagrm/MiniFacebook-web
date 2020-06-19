@extends('home.index')
@section('content')

<div class="container-fluid my-5">
    <div class="row my-5">
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
                <a href="{{route('chat',$user->id)}}" class="btn btn-info">
                    Enviar mensaje
                </a>
                @else
                <a href="{{route('friend.request',$user->id)}}" class="btn btn-info">
                    Enviar solicitud
                </a>
                @endif
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <h5 class="text-right">
                Correo electrónico
            </h5>
        </div>
        <div class="col">
            <label>{{$user->email}}</label>
        </div>
    </div>
    <div class="row">
        <div class="col-4">
            <h5 class="text-right">
                Cumpleaños
            </h5>
        </div>
        <div class="col">
            <label>{{$user->birthday}}</label>
        </div>
    </div>
</div>

@endsection