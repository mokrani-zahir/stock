@php
    $type ??= 'text';
    $class ??= null;
    $name ??= '';
    $value ??= '';
    $label ??= ucfirst($name);
    $placeholder ??= $label;
    $idName = str_replace(['[', ']'], ['.', ''], $name);
    $idNameHtml = str_replace(['[', ']'], ['-', ''], $name);
    $errorMessage ??= true;
    $showLabel ??= true;
    $spanRight ??= '';
    $spanLeft ??= '';

@endphp

<div @class(['form-group mb-2', $class])>

    @if ($showLabel)
        <label for="{{ $idNameHtml }}" class="form-label">{{ $label }}</label>
    @endif

    @if ($type == 'textarea')
        <textarea class="form-control @error($idName) is-invalid @enderror" type="{{ $type }}" id="{{ $idNameHtml }}"
            name="{{ $name }}">
            {{ old($idName, $value) }}
        </textarea>
    @else
        <div class="input-group">
            @if ($spanLeft)
                <span class="input-group-text"><i class="{{$spanLeft}}"></i></span>
            @endif
            <input class="form-control @error($idName) is-invalid @enderror" type="{{ $type }}"
                id="{{ $idNameHtml }}" name="{{ $name }}" value="{{ old($idName, $value) }}"
                placeholder="{{ $placeholder }}">
            @if ($spanRight)
                <span class="input-group-text">{{$spanRight}}</span>
            @endif
        </div>

    @endif

    @if ($errorMessage)
        @error($idName)
            <div class="text-danger">
                {{ $message }}
            </div>
        @enderror
    @endif


</div>
