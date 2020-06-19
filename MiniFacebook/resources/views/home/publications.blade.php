@extends('home.index')
@section('content')

<ul class="list-group">
    @foreach($publications as $publication)
    <li class="list-group-item list-group-item-action">
        {{$publication}}
    </li>
    @endforeach
</ul>

@endsection