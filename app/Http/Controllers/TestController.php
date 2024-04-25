<?php

namespace App\Http\Controllers;

use App\Http\Requests\BonFilterRequest;
use App\Models\Article;
use App\Models\Bon;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class TestController extends Controller
{

    public function bon()
    {
        return view('test.form');
    }

    public function request(BonFilterRequest $request)
    {

        $dataRequest = $request->validated();

        $fournisseurRequest = $dataRequest['fournisseur'];
        $articlesRequest = $dataRequest['article'];
        $bonRequest = $dataRequest['bon'];

        $fournisseur = Fournisseur::where('code', $fournisseurRequest['code'])->first();

        //Si le fournisseur n'exist pas en va enregister le nouveau fourniseur
        if (!$fournisseur) {
            dd("creer un nouveau fourniseur");
        }

        // dd($articlesRequest);

        $articles = [];
        foreach ($articlesRequest as $key => $value) {

            $article = Article::where('code', $value['code'])->first();

            //Si le article n'exist pas en va enregister le nouveau article
            if (!$article) {
                dd("creer un nouveau articles avec le code " . $value['code']);
            }

            $articles[$key] = $article;
        }

        foreach ($articles as $key => $article) {


            //Calculer CMP
            $cmp = ($article->prix + $articlesRequest[$key]['prix']*$articlesRequest[$key]['quantity']) / ($article->quantity + $articlesRequest[$key]['quantity']);

            $fournisseur->article()->attach($article,[
                'type' => $bonRequest['type'],
                'prix' => $articlesRequest[$key]['prix'],
                'quantity' => $articlesRequest[$key]['quantity'],
                'valeur' => $cmp,
                'numero_bon' => '3265236523652365',
                'date' => $bonRequest['date']
            ]);

            $article->update([
                "prix"=> $cmp,
                "quantity"=> $article->quantity + $articlesRequest[$key]['quantity']
            ]);

        }

        return redirect()->back()->with('success', 'le bon est bien ajoute à base de données');
    }

    public function searchF()
    {
        return Fournisseur::all();
    }

    public function searchA()
    {
        return Article::all();
    }
}
