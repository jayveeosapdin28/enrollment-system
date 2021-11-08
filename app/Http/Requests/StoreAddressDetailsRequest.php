<?php

namespace App\Http\Requests;

use App\Models\AddressDetails;
use Illuminate\Foundation\Http\FormRequest;

class StoreAddressDetailsRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->user()->can('insert student-info');
    }

    public function rules()
    {
        return AddressDetails::validate();
    }

    public function attributes()
    {
        return AddressDetails::attributes();
    }
}
