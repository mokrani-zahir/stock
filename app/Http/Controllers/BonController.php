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

            if($bonRequest['type']=="sorte"){
                if(!$article){
                    return redirect()->back()->with('error', 'L\'article '.$value['nom'].' n\'exist pas');
                }

                if($article->quantity < $value['quantity']){
                    return redirect()->back()->with('error', 'pour l\'article <b>'.$value['nom'].'</b> vous ne pouvez pas dépasser : '.$article->quantity);
                }


            }

            //Si le article n'exist pas en va enregister le nouveau article
            if (!$article) {


                $articleCreate = new Article;
                $articleCreate->nom = $value['nom'];
                $articleCreate->code = $value['code'];
                $articleCreate->prix = 0;
                $articleCreate->quantity = 0;
                $articleCreate->save();

                $articles[$key] = $articleCreate;

            }else{
                $articles[$key] = $article;
            }


        }

        foreach ($articles as $key => $article) {
            //Calculer CMP
            // $cmp = $articlesRequest[$key]['prix'];
            // $quantityTotal = $article->quantity + $articlesRequest[$key]['quantity'];

            if($bonRequest['type']=='entre'){
                $valueInit = $article->prix * $article->quantity;
                $valueRequest = (int) $articlesRequest[$key]['prix'] * (int) $articlesRequest[$key]['quantity'];
                $quantityTotal = $article->quantity + (int) $articlesRequest[$key]['quantity'];
                $cmp = ($valueInit+$valueRequest)/$quantityTotal;
            }else if($bonRequest['type']=='sorte'){
                $valueInit = $article->prix * $article->quantity;
                $valueRequest = $article->prix * (int) $articlesRequest[$key]['quantity'];
                $quantityTotal = $article->quantity - (int) $articlesRequest[$key]['quantity'];
                $cmp = ($valueInit-$valueRequest)/$quantityTotal;
            }else if($bonRequest['type']=='retour'){
                $valueInit = $article->prix * $article->quantity;
                $valueRequest = $article->prix * (int) $articlesRequest[$key]['quantity'];
                $quantityTotal = $article->quantity + (int) $articlesRequest[$key]['quantity'];
                $cmp = ($valueInit+$valueRequest)/$quantityTotal;
            }else{
                return redirect()->back()->with('error', 'What');
            }


            $debug = $fournisseur->article()->attach($article,[
                'type' => $bonRequest['type'],
                'cmp' => $cmp,
                'prix' => ($articlesRequest[$key]['prix'] == "CMP") ? $cmp : $articlesRequest[$key]['prix'],
                'quantity' => $articlesRequest[$key]['quantity'],
                'numero_bon' => $bonRequest['numero'],
                'date' => $bonRequest['date'],
                'value' => $cmp * $articlesRequest[$key]['quantity']
            ]);

            $article->update([
                "prix"=> $cmp,
                "quantity"=> $quantityTotal
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
