<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bon extends Model
{
    use HasFactory;
    protected $table = 'article_fournisseur';

    public function fournisseur(){
        return $this->belongsTo(Fournisseur::class);
    }

    public function article(){
        return $this->belongsTo(Article::class);
    }

}
