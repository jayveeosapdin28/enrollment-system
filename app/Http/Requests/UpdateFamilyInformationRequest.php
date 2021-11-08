<?php

namespace App\Http\Requests;

use App\Models\FamilyInformation;
use Illuminate\Foundation\Http\FormRequest;

class UpdateFamilyInformationRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('update student-info');
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
