<?php
// php artisan make:request StoreUserRequest
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Verifica se o usuario pode ou nao fazer a acao
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //regras de validacao para as requisicoes
            'name' => ['required'],
            'phone' => ['required', 'unique:users']
        ];
    }
}
