<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">
            <h1 class="h1">
                Reporte
            </h1>
            <br>
            <br>
            <table class="table mt-5 table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th scope="border">Informacion</th>
                        <th scope="border">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($info as $key => $value)
                    <tr>
                        <th class="text-left">{{$key}}</th>
                        <td class="text-right">{{$value}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <footer class="float-right">
        <small class="text-muted">
            {{Carbon\Carbon::parse(Carbon\Carbon::now())->locale('es_ES')->isoFormat('LLLL')}}
        </small>
    </footer>
</body>

</html>