<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 5/30/2019
 * Time: 11:09 PM
 */

namespace App\Validation;


use Illuminate\Foundation\Http\FormRequest;

class RoleModValidation extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'user' => 'string',
            'role' => 'string'
        ];
    }
}