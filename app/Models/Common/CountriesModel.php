<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class CountriesModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps      =   false;
    protected $table        =   "countries";
    protected $primaryKey   =   "id";
    protected $guarded      =   ['id'];

}
