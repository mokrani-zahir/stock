<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Bon;
use Illuminate\Support\Facades\DB;

class Inventaire extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Récupérer tous les articles
        $bons = Bon::all();

        // Grouper les articles par date
        $bonsGroupedByDate = $bons->groupBy(function ($bon) {
            return \Carbon\Carbon::parse($bon->date)->format('Y-m-d');
        });

        $bonsGroupedByDateAndArticle = $bonsGroupedByDate->map(function ($itemsByDate) {
            return $itemsByDate->groupBy('article_id')->map(function ($articlesByArticleId) {
                // Grouper les articles par type à l'intérieur de chaque groupe d'article_id
                return $articlesByArticleId->groupBy('type');
            });
        });

        $tableaux = [];
        $ligne = 0;
        foreach ($bonsGroupedByDateAndArticle as $date => $articlesByArticle) {
            foreach ($articlesByArticle as $articleId => $articlesByType) {

                $initQuantityEntre = Bon::where('article_id',$articleId)->whereDate('date','<', $date)->where('type','entre')->get()->sum('quantity');
                $initQuantityRetour = Bon::where('article_id',$articleId)->whereDate('date','<', $date)->where('type','retour')->get()->sum('quantity');
                $initQuantitySortie = Bon::where('article_id',$articleId)->whereDate('date','<', $date)->where('type','sorte')->get()->sum('quantity');

                $initQuantity = $initQuantityEntre - $initQuantitySortie + $initQuantityRetour;

                $initValueEntre = Bon::where('article_id',$articleId)->whereDate('date','<', $date)->where('type','entre')->get()->sum('value');
                $initValueRetour = Bon::where('article_id',$articleId)->whereDate('date','<', $date)->where('type','retour')->get()->sum('value');
                $initValueSortie = Bon::where('article_id',$articleId)->whereDate('date','<', $date)->where('type','sorte')->get()->sum('value');

                $initValue = $initValueEntre + $initValueRetour - $initValueSortie;

                $intCmp = ($initQuantity!=0) ? $initValue / $initQuantity : 0;


                $entreArticles = $articlesByType->get('entre', collect());
                $sorteArticles = $articlesByType->get('sorte', collect());
                $retourArticles = $articlesByType->get('retour', collect());



                $entreQuantite = $entreArticles->sum('quantity');
                $sorteQuantite = $sorteArticles->sum('quantity');
                $retourQuantite = $retourArticles->sum('quantity');
                $finalQuantite = $entreQuantite + $retourQuantite - $sorteQuantite + $initQuantity;

                $entreValue = $entreArticles->sum('value');
                $sorteValue = $sorteArticles->sum('value');
                $retourValue = $retourArticles->sum('value');
                $finalValue = $entreValue - $sorteValue + $retourValue + $initValue;

                $entreCmp = ($entreQuantite != 0) ? $entreValue / $entreQuantite : 0;
                $sorteCmp = ($sorteQuantite != 0) ? $sorteValue / $sorteQuantite : 0;
                $retourCmp = ($retourQuantite != 0) ? $retourValue / $retourQuantite : 0;
                $finalCmp = ($finalQuantite != 0) ? $finalValue / $finalQuantite : 0;

                $tableaux[$ligne]['code'] = Article::where('id',$articleId)->first()->nom;
                $tableaux[$ligne]['date'] = $date;

                $tableaux[$ligne]['init']['value'] = round($initValue,2);
                $tableaux[$ligne]['entre']['value'] = round($entreValue,2);
                $tableaux[$ligne]['sorte']['value'] = round($sorteValue,2);
                $tableaux[$ligne]['retour']['value'] = round($retourValue,2);
                $tableaux[$ligne]['final']['value'] = round($finalValue,2);

                $tableaux[$ligne]['init']['quantite'] = round($initQuantity,2);
                $tableaux[$ligne]['entre']['quantite'] = round($entreQuantite,2);
                $tableaux[$ligne]['sorte']['quantite'] = round($sorteQuantite,2);
                $tableaux[$ligne]['retour']['quantite'] = round($retourQuantite,2);
                $tableaux[$ligne]['final']['quantite'] = round($finalQuantite,2);

                $tableaux[$ligne]['init']['cmp'] = round($intCmp,2);
                $tableaux[$ligne]['entre']['cmp'] = round($entreCmp,2);
                $tableaux[$ligne]['sorte']['cmp'] = round($sorteCmp,2);
                $tableaux[$ligne]['retour']['cmp'] = round($retourCmp,2);
                $tableaux[$ligne]['final']['cmp'] = round($finalCmp,2);

                $ligne++;

            }
        }

        return view("Inventaire",['articles'=>$tableaux]);

    }

}
