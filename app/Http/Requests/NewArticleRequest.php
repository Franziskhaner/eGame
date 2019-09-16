<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;    //Así damos permiso a todos para que puedan enviar el formulario de creación de artículo.
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:50',
            'price' => 'required',
            'quantity' => 'required',
            'release_date' => 'required',
            'players_number' => 'required',
            'gender' => 'required|max:20',
            'platform' => 'required|max:25',
            'description' => 'required|max:255',
            'type' => 'required'
        ];
    }
}
