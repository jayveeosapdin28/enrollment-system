<?php

namespace App\Http\Requests;

use App\Models\EducationalBackground;
use Illuminate\Foundation\Http\FormRequest;

class StoreEducationalBackgroundRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('insert student-info');
    }

    public function rules()
    {
        return EducationalBackground::validate();
    }

    public function attributes()
    {
        return EducationalBackground::attributes();
    }
}
