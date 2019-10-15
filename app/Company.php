<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Invoice;
class Company extends Model
{
    protected $fillable=['name','owner','type','address','phones'];

    public function invoice(){
        return $this->hasMany(Invoice::class);
    }
}
