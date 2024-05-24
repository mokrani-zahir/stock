@extends('base')

@php
    $dateJour = explode(' ', Carbon\Carbon::now()->toDateTimeString())[0];

    //generation de nemero de command
    $id = mt_rand(1000000, 9999999);
    $numeroBom = str_pad($id, 10, '0', STR_PAD_LEFT);

@endphp

@section('head')
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <style>
        .auto_complete {
            border: 1px solid green;
            -webkit-text-fill-color: green;
            -webkit-box-shadow: 0 0 0px 1000px #000 inset;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>
@endsection

@section('content')
    @if (\Session::has('success'))
        <div class="alert alert-success">
            <ul>
                <li>{!! \Session::get('success') !!}</li>
            </ul>
        </div>
    @endif

    @if (\Session::has('error'))
        <div class="alert alert-danger">
            <ul>
                <li>{!! \Session::get('error') !!}</li>
            </ul>
        </div>
    @endif
    <form method="post">
        @csrf

        <fieldset class="border p-4 mb-4">
            <legend class="float-none w-auto p-2 mb-0 pb-0">Bon de commande</legend>
            <div class="row g-3">
                <x-input class="col" name="bon[date]" label="Date de commande" placeholder="aaaa-mm-jj"
                    value="{{ $dateJour }}" spanLeft="bi bi-calendar" />
                <x-input class="col" name="bon[numero]" label="Numero de commande" placeholder="XXXXXXXXX"
                    value="{{ $numeroBom }}" spanLeft="bi bi-upc" />

                <div class="input-group ">
                    <select class="form-select" aria-label="Default select example" name="bon[type]" id="operation">
                        <option value="entre">Entre</option>
                        <option value="sorte">Sorte</option>
                        <option value="retour">Retour</option>
                      </select>
                </div>
            </div>

        </fieldset>


        <fieldset class="border p-4 mb-4">
            <legend class="float-none w-auto p-2 mb-0 pb-0">Coordonnée de fournisseur</legend>
            <div class="row g-3">
                <x-input class="col" name="fournisseur[nom]" label="Nom" spanLeft="bi bi-shop-window" />
                <x-input class="col-4" name="fournisseur[code]" label="Code" spanLeft="bi bi-upc" />
            </div>

            <div class="row g-3">
                <x-input class="col" name="fournisseur[siege]" label="Siege" spanLeft="bi bi-building" />
                <x-input class="col" name="fournisseur[post]" label="Code postal" spanLeft="bi bi-mailbox" />
            </div>

            <div class="row g-3">
                <x-input class="col-3" name="fournisseur[telephon]" label="Telephon" spanLeft="bi bi-telephone" />
                <x-input class="col" name="fournisseur[email]" label="Email" type="email"
                    spanLeft="bi bi-envelope-at" />
            </div>

        </fieldset>

        <fieldset class="border p-4 mb-4" id="articles">
            <legend class="float-none w-auto p-2 mb-0 pb-0">Les articles</legend>
            @error('article.*')
                @foreach (old('article') as $key => $value)
                    <x-article-bon idList="{{ $key }}" />
                @endforeach
            @else
                <x-article-bon />
            @enderror


        </fieldset>
        <div class="col-12 mb-4">
            <button type="button" class="btn btn-primary" id="add-article">
                <i class="bi bi-plus-lg"></i>
                Article
            </button>
            <button type="submit" class="btn btn-primary">Enregister</button>
        </div>
        <script type="text/javascript" src="{{ URL::asset('js/autoComplet.js') }}"></script>
    </form>
@endsection
