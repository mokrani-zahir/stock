@extends('base')

@section('content')
<form action="" method="post">
    @csrf
    <fieldset class="border p-4 mb-4">
        <legend class="float-none w-auto p-2 mb-0 pb-0">Connection</legend>
            <x-input class="col" name="email" label="Email" placeholder="admin@entrpris.com" spanLeft="bi bi-person-fill" />
            <x-input class="col" name="password" type="password" label="mot de passe" placeholder="mot de passe" spanLeft="bi bi-key-fill" />
            <button type="submit" class="btn btn-primary">Connecté</button>
    </fieldset>
</form>
@endsection
