<?php

namespace App\Http\Requests;

use App\Models\FamilyInformation;
use Illuminate\Foundation\Http\FormRequest;

class StoreFamilyInformationRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('insert student-info');
    }

    public function rules()
    {
        return FamilyInformation::validate();
    }

    public function attributes()
    {
        return FamilyInformation::attributes();
    }
}
