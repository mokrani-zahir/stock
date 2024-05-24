@php
    $idList ??= 1;
@endphp
<div class="row g-1 article-{{$idList}}" onclick="autocompleteArticle({{$idList}})">
    <x-input class="col-3" name="article[{{ $idList }}][code]" label="Code" errorMessage=0 showLabel=0 spanLeft="bi bi-upc"/>
    <x-input class="col" name="article[{{ $idList }}][nom]" label="Nom" errorMessage=0 showLabel=0 spanLeft="bi bi-database-fill"/>
    <x-input class="col-2 prix" name="article[{{ $idList }}][prix]" label="Prix" type="number" errorMessage=0 showLabel=0/>
    <x-input class="col-2" name="article[{{ $idList }}][quantity]" label="Quantity"
        type="number" errorMessage=0 showLabel=0/>
    <div class="form-group mb-2" style="width: 50px;">
        <a class="btn btn-danger form-control is-remove" onclick="removeArticle({{$idList}})">
            <i class="bi bi-trash3"></i>
        </a>
    </div>
</div>
