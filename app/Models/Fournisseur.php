<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fournisseur extends Model
{
    use HasFactory;

    public function article(){
        return $this->belongsToMany(Article::class)->withPivot('type', 'prix', 'quantity', 'numero_bon','date','value');
    }

    protected $guarded = ['created_at','udated_at','id'];
}
