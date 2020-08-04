@extends('master')
@section('body')
<style>
    .bg-login {
        height: 100vh;
        min-height: 500px;
        /* background: url('/images/bg-login.jpg'); */
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        /* filter: blur(1px); */
    }

    .bg-register {
        height: 100vh;
        min-height: 500px;
        /* background-image: url('/images/bg-register.jpg'); */
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        /* filter: blur(1px); */
    }

    .bg-o {
        opacity: 0.5;
    }
</style>
<div class="container-fluid h-100 font-weight-bold">
    <div class="row h-100">
        <div class="col-7 bg-info">
            <div class="container-fluid h-100">
                <div class="row h-100 align-items-center">
                    <div class="col col-6 mx-auto">
                        <h1 class="text-center">Inicia sesión</h1>
                        <form action="{{route('login')}}" method="post" class="border rounded border-dark p-5">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label>Correo</label>
                                <input type="email" name="email_" class="form-control" value="{{old('email_')}}">
                                {!!$errors->first('email_','<small
                                    class="text-white font-weight-bold">:message</small>')!!}
                            </div>
                            <div class="form-group">
                                <label>Contraseña</label>
                                <input type="password" name="password_" class="form-control">
                                {!!$errors->first('password_','<small
                                    class="text-white font-weight-bold">:message</small>')!!}
                            </div>
                            <div class="form-group form-row">
                                <input type="submit" class="btn btn-warning mx-auto" value="Entrar">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col bg-warning">
            <div class="container-fluid h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-9 mx-auto">
                        <h1 class="text-center">Regístrate</h1>
                        <form action="{{route('register')}}" method="post" class="border rounded border-dark p-5">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label>Nombre(s)</label>
                                <input type="text" name="names" class="form-control" value="{{old('names')}}">
                                {!!$errors->first('names','<small
                                    class="text-white font-weight-bold">:message</small>')!!}
                            </div>
                            <div class="form-group form-row">
                                <div class="col">
                                    <label>Apellido</label><br>
                                    <label>paterno</label>
                                    <input type="text" name="paternal_surname" class="form-control" value="{{old('paternal_surname')}}">
                                    {!!$errors->first('paternal_surname','<small
                                    class="text-white font-weight-bold">:message</small>')!!}
                                </div>
                                <div class="col">
                                    <label>Apellido</label><br>
                                    <label>materno</label>
                                    <input type="text" name="maternal_surname" class="form-control" value="{{old('maternal_surname')}}">
                                    {!!$errors->first('maternal_surname','<small
                                    class="text-white font-weight-bold">:message</small>')!!}
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Fecha de nacimiento</label>
                                <input type="date" name="birthday" class="form-control" value="{{old('birthday')}}">
                                {!!$errors->first('birthday','<small
                                    class="text-white font-weight-bold">:message</small>')!!}
                            </div>
                            <div class="form-group">
                                <label>Correo</label>
                                <input type="email" name="email" class="form-control" value="{{old('email')}}">
                                {!!$errors->first('email','<small
                                    class="text-white font-weight-bold">:message</small>')!!}
                            </div>
                            <div class="form-group">
                                <label>Nueva contraseña</label>
                                <input type="password" name="password" class="form-control" value="{{old('password')}}">
                                {!!$errors->first('password','<small class="text-white font-weight-bold">:message</small>')!!}
                            </div>
                            <div class="form-group">
                                <label>Confirma tu nueva contraseña</label>
                                <input type="password" name="password_confirmation" class="form-control" value="{{old('password_confirmation')}}">
                                {!!$errors->first('password','<small
                                    class="text-white font-weight-bold text-small">:message</small>')!!}
                            </div>
                            <div class="form-group form-row">
                                <input type="submit" class="btn btn-info mx-auto" value="Registrarme">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection