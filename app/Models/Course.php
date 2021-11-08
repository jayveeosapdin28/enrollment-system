<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $appends =['name'];

    public function getNameAttribute(){
        return ($this->cormajor === 'NONE')
            ? '('.$this->corcode.') - '.$this->cordesc
            : '('.$this->corcode.' - '.$this->cormajor.') - '.$this->cordesc.' MAJOR IN '.$this->cormajor;
    }
}
