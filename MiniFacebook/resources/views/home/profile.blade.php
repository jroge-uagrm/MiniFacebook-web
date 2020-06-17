@extends('home.index')
@section('content')

<!-- {{$user}} -->
<form action="me" method="post" class="p-5">
    {{csrf_field()}}
    @method('put')
    <div class="form-group">
        <label>Nombre(s)</label>
        <input type="text" name="names" class="form-control" value="{{$user->names}}">
        {!!$errors->first('names','<small class="text-danger font-weight-bold">:message</small>')!!}
    </div>
    <div class="form-group form-row">
        <div class="col">
            <label>Apellido paterno</label>
            <input type="text" name="paternal_surname" class="form-control" value="{{$user->paternal_surname}}">
            {!!$errors->first('paternal_surname','<small class="text-danger font-weight-bold">:message</small>')!!}
        </div>
        <div class="col">
            <label>Apellido materno</label>
            <input type="text" name="maternal_surname" class="form-control" value="{{$user->maternal_surname}}">
            {!!$errors->first('maternal_surname','<small class="text-danger font-weight-bold">:message</small>')!!}
        </div>
    </div>
    <div class="form-group">
        <label>Fecha de nacimiento</label>
        <input type="date" name="birthday" class="form-control" value="{{$user->birthday}}">
        {!!$errors->first('birthday','<small class="text-danger font-weight-bold">:message</small>')!!}
    </div>
    <div class="form-group">
        <label>Correo</label>
        <input type="email" name="email" class="form-control" value="{{$user->email}}">
        {!!$errors->first('email','<small class="text-danger font-weight-bold">:message</small>')!!}
    </div>
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
    <div class=" form-group">
        <label>Confirma tu nueva contraseña</label>
        <input type="password" name="password_confirmation" class="form-control" value="{{old('password_confirmation')}}">
        {!!$errors->first('password','<small class="text-danger font-weight-bold text-small">:message</small>')!!}
    </div>
    <div class="form-group form-row">
        <input type="submit" class="btn btn-info mx-auto" value="Guardar">
    </div>
</form>

@endsection