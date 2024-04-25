<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MouvementController extends Controller
{
    public function index(){
        $articles = \App\Models\Bon::all();

        $listArticle = [];
        foreach($articles as $key => $article){
            $listArticle[$key]['id'] = $article->article->code;
            $listArticle[$key]['type'] = $article->type;
            $listArticle[$key]['date'] = $article->date;
            $listArticle[$key]['quantity'] = $article->quantity;
            $listArticle[$key]['valeur'] = $article->valeur;
            $listArticle[$key]['fournisseur'] = $article->fournisseur->nom;
            
        }

        return view('mouvement',['articles'=>$listArticle]);
    }

}
