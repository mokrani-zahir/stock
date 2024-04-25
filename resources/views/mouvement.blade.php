@extends('base')

@section('content')
<style>
  img{
    margin-right: 5px;
  }
</style>
<table class="table">
    <thead class="thead-light">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Type</th>
        <th scope="col">Date</th>
        <th scope="col">Quantity</th>
        <th scope="col">Prix/CMP</th>
        <th scope="col">Fournisseur</th>
      </tr>
    </thead>
    <tbody>
      @foreach($articles as $article)
      <tr>
        <th scope="row">{{$article['id']}}</th>
        <td> <img src="/img/{{$article['type']}}.png" width="16" height="16"> {{$article['type']}} </td>
        <td>{{$article['date']}}</td>
        <td>{{$article['quantity']}}</td>
        <td>{{$article['valeur']}}</td>
        <td>{{$article['fournisseur']}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
@endsection