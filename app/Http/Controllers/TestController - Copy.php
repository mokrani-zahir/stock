<?php

namespace App\Http\Controllers;

use App\Http\Requests\BonFilterRequest;
use App\Models\Article;
use App\Models\Bon;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        $fournisseur = Fournisseur::find(1);
        $bon = new Bon();
        $bon->date = '10-10-2024';
        $bon->fournisseur()->associate($fournisseur);
        $bon->save();

        $articles = [];
        for ($i = 1; $i <= 5; $i++) {
            $article = Article::find($i);
            if ($article) {
                $articles[] = $article;
            }
        }

        foreach ($articles as $article) {
            $bon->articles()->attach($article, ['prixe' => '100', 'quantity' => '150']);
        }
    }

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

        // //Creation de bon
        // $bon = new Bon();
        // $bon->date = $bonRequest['date'];
        // $bon->fournisseur()->associate($fournisseur);
        // $bon->save();

        foreach ($articles as $key => $article) {

            //Logique de PRIX stock CMP
            $cump = ($article->prix + $articlesRequest[$key]['prix']*$articlesRequest[$key]['quantity']) / ($article->quantity + $articlesRequest[$key]['quantity']);

            $article->update([
                "prix"=> $cump,
                "quantity"=> $articlesRequest[$key]['quantity']
            ]);

        }

        return redirect()->back()->with('success', 'le bon est bien ajoute à base de données');
    }

    public function autoComplet()
    {
        return view('test.auto');
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
