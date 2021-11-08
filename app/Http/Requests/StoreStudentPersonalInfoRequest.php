<?php

namespace App\Http\Requests;

use App\Models\StudentPersonalInfo;
use Illuminate\Foundation\Http\FormRequest;

class StoreStudentPersonalInfoRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('update student-info');
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
