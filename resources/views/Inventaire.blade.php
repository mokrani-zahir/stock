@extends("base")

@section("content")

<style>
    .table td:nth-child(2n){
        background-color: rgba(0, 0, 0, 0.05);
    }
    .table thead td{
        background-color:#FFF !important;
        text-align: center;
        border-left: 1px solid rgba(0, 0, 0, 0.2);
    }
    .table thead td:nth-child(1){
        border-left: 0;
    }
</style>


{{date("Y")}}

<table class="table">
    <thead class="thead-light">
        <td colspan="2">Article</td>
        <td colspan="3">Intial</td>
        <td colspan="3">Entrée</td>
        <td colspan="3">Sortie</td>
        <td colspan="3">Retour</td>
        <td colspan="3">Final</td>
    </thead>

    <tr>

        <td>Date</td>
        <td>Article</td>

        <td>Quantité</td>
        <td>Prix</td>
        <td>Valeur</td>

        <td>Quantité</td>
        <td>Prix</td>
        <td>Valeur</td>

        <td>Quantité</td>
        <td>Prix</td>
        <td>Valeur</td>

        <td>Quantité</td>
        <td>Prix</td>
        <td>Valeur</td>

        <td>Quantité</td>
        <td>Prix</td>
        <td>Valeur</td>

    </tr>
    @foreach($articles as $article)
    <tr>
        <td>{{ $article['date'] }}</td>
        <td>{{ $article['code'] }}</td>

        <td>{{ $article['init']['quantite'] }}</td>
        <td>{{ $article['init']['cmp'] }}</td>
        <td>{{ $article['init']['value'] }}</td>

        <td>{{ $article['entre']['quantite'] }}</td>
        <td>{{ $article['entre']['cmp'] }}</td>
        <td>{{ $article['entre']['value'] }}</td>

        <td>{{ $article['sorte']['quantite'] }}</td>
        <td>{{ $article['sorte']['cmp'] }}</td>
        <td>{{ $article['sorte']['value'] }}</td>

        <td>{{ $article['retour']['quantite'] }}</td>
        <td>{{ $article['retour']['cmp'] }}</td>
        <td>{{ $article['retour']['value'] }}</td>

        <td>{{ $article['final']['quantite'] }}</td>
        <td>{{ $article['final']['cmp'] }}</td>
        <td>{{ $article['final']['value'] }}</td>

    </tr>
    @endforeach

</table>


@endsection
