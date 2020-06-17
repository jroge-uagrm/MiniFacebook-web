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
        <div class="col-7 h-100 d-flex align-items-center p-0">
            <div class="col bg-login position-absolute bg-primary"></div>
            <form action="login" method="post" class="col-6 mx-auto border rounded border-dark p-5">
                {{csrf_field()}}
                <div class="form-group">
                    <label>Correo</label>
                    <input type="email" name="email" class="form-control" value="{{old('email')}}">
                    {!!$errors->first('email','<span class="text-white font-weight-bold">:message</span>')!!}
                </div>
                <div class="form-group">
                    <label>Contraseña</label>
                    <input type="password" name="password" class="form-control">
                    {!!$errors->first('password','<span class="text-white font-weight-bold">:message</span>')!!}
                </div>
                <div class="form-group form-row">
                    <input type="submit" class="btn btn-warning mx-auto" value="Entrar">
                </div>
            </form>
        </div>
        <div class="col h-100 d-flex align-items-center p-0">
            <div class="col bg-login position-absolute bg-rgister bg-warning"></div>
            <form action="register" method="post" class="col-9 mx-auto border rounded border-dark p-5">
                {{csrf_field()}}
                <div class="form-group">
                    <label>Nombre(s)</label>
                    <input type="text" name="names" class="form-control">
                </div>
                <div class="form-group form-row">
                    <div class="col">
                        <label>Apellido paterno</label>
                        <input type="text" name="paternal_surname" class="form-control">
                    </div>
                    <div class="col">
                        <label>Apellido materno</label>
                        <input type="text" name="maternal_surname" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label>Fecha de nacimiento</label>
                    <input type="date" name="birthday" class="form-control">
                </div>
                <div class="form-group">
                    <label>Correo</label>
                    <input type="email" name="email" class="form-control">
                </div>
                <div class="form-group">
                    <label>Nueva contraseña</label>
                    <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                    <label>Confirma tu nueva contraseña</label>
                    <input type="password" name="password_confirm" class="form-control">
                </div>
                <div class="form-group form-row">
                    <input type="submit" class="btn btn-info mx-auto" value="Registrarme">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection