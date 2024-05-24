<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('article_fournisseur', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Article::class)->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Fournisseur::class);
            $table->integer("type");
            $table->integer("prix");
            $table->integer("cmp")->default('0');
            $table->integer("quantity");
            $table->integer("value");
            $table->integer("numero_bon");
            $table->integer("date");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('article_fournisseur');
    }
};
