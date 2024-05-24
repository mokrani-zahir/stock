<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Bon;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Inventairev2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function articleAnneeActual($idArticle){
        $bons = Bon::whereYear('date', '>=', 2024)->where('article_id',$idArticle)->get();

        $bonsGroupedByType = $bons->groupBy('type');

        $entreArticles = $bonsGroupedByType->get('entre', collect());
        $sorteArticles = $bonsGroupedByType->get('sorte', collect());
        $retourArticles = $bonsGroupedByType->get('retour', collect());

        $entreQuantite = $entreArticles->sum('quantity');
        $sorteQuantite = $sorteArticles->sum('quantity');
        $retourQuantite = $retourArticles->sum('quantity');

        $entreValue = $entreArticles->sum('value');
        $sorteValue = $sorteArticles->sum('value');
        $retourValue = $retourArticles->sum('value');
        $finalValue = $entreValue - $sorteValue + $retourValue;

        $entreCmp = ($entreQuantite != 0) ? $entreValue / $entreQuantite : 0;
        $sorteCmp = ($sorteQuantite != 0) ? $sorteValue / $sorteQuantite : 0;
        $retourCmp = ($retourQuantite != 0) ? $retourValue / $retourQuantite : 0;

        $tableaux['code'] = $idArticle;

        $tableaux['entre']['value'] = round($entreValue,2);
        $tableaux['sorte']['value'] = round($sorteValue,2);
        $tableaux['retour']['value'] = round($retourValue,2);

        $tableaux['entre']['quantite'] = round($entreQuantite,2);
        $tableaux['sorte']['quantite'] = round($sorteQuantite,2);
        $tableaux['retour']['quantite'] = round($retourQuantite,2);

        $tableaux['entre']['cmp'] = round($entreCmp,2);
        $tableaux['sorte']['cmp'] = round($sorteCmp,2);
        $tableaux['retour']['cmp'] = round($retourCmp,2);

        return $tableaux;
    }

    public function articleAnneePresident($idArticle){
        $bons = Bon::whereYear('date', '<', 2024)->where('article_id',$idArticle)->get();

        $bonsGroupedByType = $bons->groupBy('type');

        $entreArticles = $bonsGroupedByType->get('entre', collect());
        $sorteArticles = $bonsGroupedByType->get('sorte', collect());
        $retourArticles = $bonsGroupedByType->get('retour', collect());

        $entreQuantite = $entreArticles->sum('quantity');
        $sorteQuantite = $sorteArticles->sum('quantity');
        $retourQuantite = $retourArticles->sum('quantity');
        $finalQuantite = $entreQuantite + $retourQuantite - $sorteQuantite;

        $entreValue = $entreArticles->sum('value');
        $sorteValue = $sorteArticles->sum('value');
        $retourValue = $retourArticles->sum('value');
        $finalValue = $entreValue - $sorteValue + $retourValue;

        $entreCmp = ($entreQuantite != 0) ? $entreValue / $entreQuantite : 0;
        $sorteCmp = ($sorteQuantite != 0) ? $sorteValue / $sorteQuantite : 0;
        $retourCmp = ($retourQuantite != 0) ? $retourValue / $retourQuantite : 0;
        $finalCmp = ($finalQuantite != 0) ? $finalValue / $finalQuantite : 0;


        return [
            'quantite' => $finalQuantite,
            'cmp' => round($finalCmp,2),
            'value' => round($finalValue,2)
        ];
    }


    public function index()
    {


        $bons = Bon::all()->unique('article_id');

        $tableaux = [];
        foreach($bons as $key => $article){
            $articlePresident = $this->articleAnneePresident($article->article_id);
            $tableau = $this->articleAnneeActual($article->article_id);

            $tableau['init']['quantite'] = $articlePresident['quantite'];
            $tableau['init']['value'] = round($articlePresident['value'],2);
            $tableau['init']['cmp'] = round($articlePresident['cmp'],2);

            $tableau['final']['quantite'] = $articlePresident['quantite'] + $tableau['entre']['quantite'] - $tableau['sorte']['quantite'] + $tableau['retour']['quantite'];
            $tableau['final']['value'] = round($articlePresident['value'] + $tableau['entre']['value'] - $tableau['sorte']['value'] + $tableau['retour']['value'],2);
            $tableau['final']['cmp'] = ($tableau['final']['quantite']!=0) ? round($tableau['final']['value'] / $tableau['final']['quantite'],2) : 0 ;

            $tableaux[$key] = $tableau;
        }

        return view("Inventairev2",['articles'=>$tableaux]);

    }
}
