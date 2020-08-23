@extends('home.index')
@section('content')
<!-- Tabs -->
<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active text-info" id="home-tab" data-toggle="tab" href="#report" role="tab"
            aria-controls="home" aria-selected="true">
            Reporte
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link text-info" id="profile-tab" data-toggle="tab" href="#statics" role="tab"
            aria-controls="profile" aria-selected="false">
            Estadisticas
        </a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">
    <!-- Reporte -->
    <div class="tab-pane fade show active" id="report" role="tabpanel" aria-labelledby="home-tab">
        <h3 class="text-center">
            Reporte
        </h3>
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Informacion</th>
                    <th scope="col">Valor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($report as $key => $value)
                <tr>
                    <th class="text-left">{{$key}}</th>
                    <td class="text-right">{{$value}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row justify-content-around">
            <a href="{{route('admin.report.pdf')}}" class="btn btn-info btn-sm">
                Exportar PDF
            </a>
            <a href="{{route('admin.report.excel')}}" class="btn btn-info btn-sm">
                Exportar EXCEL
            </a>
        </div>
    </div>
    <!-- Estadisticas -->
    <div class="tab-pane fade show" id="statics" role="tabpanel" aria-labelledby="home-tab">
        <h3 class="text-center">
            Estadisticas
        </h3>
        <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Informacion</th>
                    <th scope="col">Valor</th>
                </tr>
            </thead>
            <tbody>
                @foreach($statistics as $key => $value)
                <tr>
                    <th class="text-left">{{$key}}</th>
                    <td class="text-right">{{$value}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row justify-content-around">
            <a href="{{route('admin.statistics.pdf')}}" class="btn btn-info btn-sm">
                Exportar PDF
            </a>
            <a href="{{route('admin.statistics.excel')}}" class="btn btn-info btn-sm">
                Exportar EXCEL
            </a>
        </div>
    </div>
</div>
@endsection