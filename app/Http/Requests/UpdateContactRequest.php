<?php

namespace App\Http\Requests;

use App\Models\Contact;
use Illuminate\Foundation\Http\FormRequest;

class UpdateContactRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('update student-info');
    }

    public function rules()
    {
        return Contact::validate();
    }

    public function attributes()
    {
        return Contact::attributes();
    }
}
