<?php

namespace App\Http\Controllers;

use App\Http\Requests\BonFilterRequest;
use App\Models\Article;
use App\Models\Bon;
use App\Models\Fournisseur;
use Illuminate\Http\Request;


class BonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("test.form");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("test.form");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BonFilterRequest $request)
    {
        $dataRequest = $request->validated();

        $fournisseurRequest = $dataRequest['fournisseur'];
        $articlesRequest = $dataRequest['article'];
        $bonRequest = $dataRequest['bon'];

        $fournisseur = Fournisseur::where('code', $fournisseurRequest['code'])->first();

        //Si le fournisseur n'exist pas en va enregister le nouveau fourniseur
        if (!$fournisseur) {
            Fournisseur::create($fournisseurRequest);
        }

        // dd($articlesRequest);

        $articles = [];
        foreach ($articlesRequest as $key => $value) {

            $article = Article::where('code', $value['code'])->first();


            //Si le article n'exist pas en va enregister le nouveau article
            if (!$article) {
                //echo("creer un nouveau articles avec le code " . $value['code']);
                $articles[$key] = Article::create([
                    "nom" => $value['nom'],
                    "code" => $value['code'],
                    "prix" => "0",
                    "quantity" => "0"
                ]);

            }else{
                $articles[$key] = $article;
            }


        }

        foreach ($articles as $key => $article) {
            //Calculer CMP
            $cmp = ($article->prix + $articlesRequest[$key]['prix']*$articlesRequest[$key]['quantity']) / ($article->quantity + $articlesRequest[$key]['quantity']);

            $debug = $fournisseur->article()->attach($article,[
                'type' => $bonRequest['type'],
                'prix' => $articlesRequest[$key]['prix'],
                'quantity' => $articlesRequest[$key]['quantity'],
                'valeur' => $cmp,
                'numero_bon' => $bonRequest['numero'],
                'date' => $bonRequest['date']
            ]);

            $article->update([
                "prix"=> $cmp,
                "quantity"=> $article->quantity + $articlesRequest[$key]['quantity']
            ]);

        }

        return redirect()->back()->with('success', 'le bon est bien ajoute à base de données');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
