<?php

namespace App\Http\Requests;

use App\Models\EnrollmentApplication;
use Illuminate\Foundation\Http\FormRequest;

class StoreEnrollmentApplicationRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('insert student-info');
    }

    public function rules()
    {
        return EnrollmentApplication::validate();
    }

    public function attributes()
    {
        return EnrollmentApplication::attributes();
    }
}
