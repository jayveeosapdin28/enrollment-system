<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyInformation extends Model
{
    use HasFactory;

    protected $fillable = [
        'fathnam3',
        'fathnam2',
        'fathnam1',
        'fathnam4',
        'fathoccup',
        'mothnam3',
        'mothnam2',
        'mothnam1',
        'mothoccup',
        'guardian',
        'relationship',
        'phone2',
        'annualfamincome',
        'parentstatus',
        'user_id',
        'guardian_country',
        'guardian_barangay',
        'guardian_city',
        'guardian_province',
        'guardian_street',
        'guardian_house',
    ];

    public static function validate()
    {
        return [
            'fathnam3' => 'required|max:50',
            'fathnam2' => 'required|max:50',
            'fathnam1' => 'required|max:50',
            'fathnam4' => 'nullable|max:5',
            'fathoccup' => 'required|max:100',
            'mothnam3' => 'required|max:50',
            'mothnam2' => 'required|max:50',
            'mothnam1' => 'required|max:50',
            'mothoccup' => 'required|max:50',
            'guardian' => 'required|max:50',
            'relationship' => 'required',
            'phone2' => 'required|max:15',
            'annualfamincome' => 'required',
            'parentstatus' => 'required',
            'guardian_country' => 'required',
            'guardian_barangay' => 'required',
            'guardian_city' => 'required',
            'guardian_province' => 'required',
            'guardian_street' => 'nullable',
            'guardian_house' => 'nullable',
        ];
    }

    public static function attributes()
    {
        return [
            'fathnam3' => 'first name',
            'fathnam2' => 'middle name',
            'fathnam1' => 'last name',
            'fathnam4' => 'extension name',
            'fathoccup' => 'occupation',
            'mothnam3' => 'first name',
            'mothnam2' => 'middle name',
            'mothnam1' => 'last name',
            'mothoccup' => 'occupation',
            'guardian' => 'guardian name',
            'relationship' => 'relationship to guardian',
            'phone2' => 'guardian\'s phone number',
            'annualfamincome' => 'annual income',
            'parentstatus' => 'parent status',
            'guardian_country' => 'guardian\'s country',
            'guardian_barangay' => 'guardian\'s barangay',
            'guardian_city' => 'guardian\'s city',
            'guardian_province' => 'guardian\'s province',
            'guardian_street' => 'guardian\'s street',
            'guardian_house' => 'guardian\'s house number',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
