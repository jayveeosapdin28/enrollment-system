<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    use HasFactory;
    protected $fillable= ['path','user_id','id_picture'];

    public static function validate(){
        return [
            'signature_path' => "required_without:signature|file|max:2000",
            'signature' =>"required_without:signature_path",
            'id_picture' =>'required|file|max:2000',
        ];
    }
    public static function attributes()
    {
        return [
            'signature_path' => 'signature image',
        ];
    }

}
