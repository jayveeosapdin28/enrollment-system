<?php

namespace App\Http\Requests;

use App\Models\AdditionalInformation;
use Illuminate\Foundation\Http\FormRequest;

class StoreAdditionalInformationRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('insert student-info');
    }

    public function rules()
    {
        return AdditionalInformation::validate();
    }

    public function attributes()
    {
        return AdditionalInformation::attributes();
    }
}
