<?php
/**
 * Created by PhpStorm.
 * User: bitch
 * Date: 5/31/2019
 * Time: 4:08 PM
 */

namespace App\Validation;


use Illuminate\Foundation\Http\FormRequest;

class RoleValidation extends FormRequest
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'name' => 'string',
            'description' => 'string'
        ];
    }
}
