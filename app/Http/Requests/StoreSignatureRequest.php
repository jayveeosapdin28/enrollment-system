<?php

namespace App\Http\Requests;

use App\Models\Signature;
use Illuminate\Foundation\Http\FormRequest;

class StoreSignatureRequest extends FormRequest
{

    public function authorize()
    {
        return auth()->user()->can('insert student-info');
    }


    public function rules()
    {
        return Signature::validate();
    }
    public function attributes()
    {
        return Signature::attributes();
    }
}
