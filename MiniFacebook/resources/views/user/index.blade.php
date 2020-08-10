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
                <a href="{{route('chat',$user->id)}}" class="btn btn-info">
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
    <div class="card-header bg-light">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a class="nav-link text-info tablinks active" onclick="openCity(event, 'informationCollapse')" data-toggle="collapse" href="#informationCollapse">
                    <strong>
                        Información
                    </strong>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-info tablinks " onclick="openCity(event, 'publicationsCollapse')" data-toggle="collapse" href="#publicationsCollapse">
                    <strong>
                        Link
                    </strong>
                </a>
            </li>
        </ul>
    </div>
    <div class="card-body collapse tabcontent" id="informationCollapse">
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
    <div class="card-body collapse tabcontent" id="publicationsCollapse">
        PU
    </div>
</div>
<script>
    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>
@endsection