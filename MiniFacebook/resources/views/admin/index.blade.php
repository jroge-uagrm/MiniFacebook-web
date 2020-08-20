@extends('home.index')
@section('content')
<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">Informacion</th>
            <th scope="col">Valor</th>
        </tr>
    </thead>
    <tbody>
        @foreach($info as $key => $value)
        <tr>
            <th scope="row">{{$key}}</th>
            <td>{{$value}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection