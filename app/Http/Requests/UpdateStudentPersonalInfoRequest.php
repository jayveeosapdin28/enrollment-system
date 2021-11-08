<?php

namespace App\Http\Requests;

use App\Models\StudentPersonalInfo;
use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentPersonalInfoRequest extends FormRequest
{

    public function authorize()
    {
        return auth()->user()->can('insert student-info');
    }

    public function rules()
    {
        return StudentPersonalInfo::validate();
    }
    public function attributes()
    {
        return StudentPersonalInfo::attributes();
    }
}
