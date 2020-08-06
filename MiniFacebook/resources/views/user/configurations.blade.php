@extends('home.index')
@section('content')
<div class="row">
    <div class="col border border-dark p-0">
        <h2 class="text-center mt-3">
            Información personal
        </h2>
        <form action="{{route('configurations.save')}}" method="post" enctype="multipart/form-data" class="px-5">
            {{csrf_field()}}
            @method('put')
            <div class="form-group">
                <label>Nombre(s)</label>
                <input type="text" name="names" class="form-control" value="{{old('names') ?? Auth::user()->names}}">
                {!!$errors->first('names','<small class="text-danger font-weight-bold">:message</small>')!!}
            </div>
            <div class="form-group form-row">
                <label>Apellidos</label>
                <input type="text" name="last_names" class="form-control"
                    value="{{old('paternal_surname') ?? Auth::user()->last_names}}">
                {!!$errors->first('last_names','<small class="text-danger font-weight-bold">:message</small>')!!}
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label>Fecha de nacimiento</label>
                    <input type="date" name="birthday" class="form-control"
                        value="{{old('birthday') ?? Auth::user()->birthday}}">
                    {!!$errors->first('birthday','<small class="text-danger font-weight-bold">:message</small>')!!}
                </div>
                <div class="col">
                    <label>Número de celular</label>
                    <input type="text" name="phone_number" class="form-control"
                        value="{{old('phone_number') ?? Auth::user()->phone_number}}">
                    {!!$errors->first('phone_number','<small class="text-danger font-weight-bold">:message</small>')!!}
                </div>
            </div>
            <div class="form-group">
                <label>Correo</label>
                <input type="email" name="email" class="form-control" value="{{old('email') ?? Auth::user()->email}}">
                {!!$errors->first('email','<small class="text-danger font-weight-bold">:message</small>')!!}
            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label>Foto de perfil</label>
                    <input type="file" name="profile_picture" class="form-control-file">
                    {!!$errors->first('profile_picture','<small
                        class="text-danger font-weight-bold">:message</small>')!!}
                </div>
                <div class="col">
                    <label>Sexo</label>
                    <select name="sex" class="form-control">
                        @if(Auth::user()->sex=='M')
                        <option value="M" selected>Masculino</option>
                        <option value="F">Femenino</option>
                        @else
                        <option value="M">Masculino</option>
                        <option value="F" selected>Femenino</option>
                        @endif
                    </select>
                    {!!$errors->first('phone_number','<small class="text-danger font-weight-bold">:message</small>')!!}
                </div>
            </div>
            <div class="form-group form-row">
                <input type="submit" class="btn btn-info mx-auto" value="Guardar">
            </div>
        </form>
    </div>
</div>
<div class="row mb-4">
    <div class="col border border-dark p-0">
        <h2 class="text-center mt-3">
            Cambiar contraseña
        </h2>
        <form action="{{route('password.save')}}" method="post" class="px-5">
            {{csrf_field()}}
            @method('put')
            <div class="form-group">
                <label>Antigua contraseña</label>
                <input type="password" name="old_password" class="form-control" value="{{old('old_password')}}">
                {!!$errors->first('old_password','<small class="text-danger font-weight-bold">:message</small>')!!}
            </div>
            <div class="form-group">
                <label>Nueva contraseña</label>
                <input type="password" name="password" class="form-control" value="{{old('password')}}">
                {!!$errors->first('password','<small class="text-danger font-weight-bold">:message</small>')!!}
            </div>
            <div class="form-group">
                <label>Confirma tu nueva contraseña</label>
                <input type="password" name="password_confirmation" class="form-control"
                    value="{{old('password_confirmation')}}">
                {!!$errors->first('password','<small
                    class="text-danger font-weight-bold text-small">:message</small>')!!}
            </div>
            <div class="form-group form-row">
                <input type="submit" class="btn btn-info mx-auto" value="Guardar">
            </div>
        </form>
    </div>
</div>

@endsection