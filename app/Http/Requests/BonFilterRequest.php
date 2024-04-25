<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BonFilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'bon.date' => ['required'],
            'bon.numero' => ['required'],
            'bon.type' => ['required'],
            'fournisseur.nom' => ['required'],
            'fournisseur.code' => ['required'],
            'fournisseur.post' => ['required'],
            'fournisseur.email' => ['required'],
            'fournisseur.telephon' => ['required'],
            'fournisseur.siege' => ['required'],
            'article.*.nom' => ['required'],
            'article.*.code' => ['required'],
            'article.*.prix' => ['required'],
            'article.*.quantity' => ['required'],
            'articles'
        ];
    }

    public function messages()
    {
        return [
            'fournisseur.nom.required'=> 'Le champ nom de fournisseur est obligatoire.',
            'fournisseur.min'=> 'Le champ nom fournisseur est obligatoire 2.'
        ];
    }
}
