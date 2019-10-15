<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Company;
class Invoice extends Model
{
    protected $fillable=['description','credit','debit','duedate','company_id'];

    public function company(){
        return $this->belongsTo(Company::class);
    }

}
