<?php

namespace App\Http\Requests;

use App\Models\EnrollmentApplication;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEnrollmentApplicationRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('update student-info');
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
