@extends('home.index')
@section('content')
<?php
$color="success";
if(strpos(Auth::user()->style,"classic")!==false){
    $color="info";
}else if(strpos(Auth::user()->style,"dark")!==false){
    $color="dark";
}
$size="small";
if(strpos(Auth::user()->style,"normal")!==false){
    $size="normal";
}else if(strpos(Auth::user()->style,"big")!==false){
    $size="large";
}
?>
<h3 class="text-center">Solitudes enviadas</h3>
<ul class="list-group mt-4">
    @forelse($friendRequests as $contact)
    <a href="{{route('profile',$contact->id)}}">
        <li
            class="list-group-item {{$color=='dark'?'bg-gray':''}} list-group-item-action border border-{{$color}} rounded">
            <div class="row align-items-center">
                <div class="col-2 p-0">
                    <a href="{{route('profile',$contact->id)}}">
                        <img src="{{route('profile_picture',$contact->id)}}" width="100%" height="100%">
                    </a>
                </div>
                <div class="col p-0">
                    <div class="container">
                        <div class="row w-100 align-items-center">
                            <a href="{{route('profile',$contact->id)}}" class="text-dark h5">
                                {{$contact->names}} {{$contact->last_names}}
                            </a>
                            <br>
                            <div class="container">
                                <div class="row">
                                    <div class="col p-0">
                                        <a href="{{route('friendRequest.delete',$contact->id)}}" class="badge badge-danger">
                                            Eliminar solicitud
                                        </a>
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
                No has enviado ninguna solicitud
            </h7>
        </div>
    </div>
    @endforelse
</ul>
@endsection