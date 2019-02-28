<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class AgencyModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps      =   false;
    protected $table        =   "agency";
    protected $primaryKey   =   "id_agency";
    protected $guarded      =   ['id_agency'];

}
