<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class MapLeadAgencyModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps      =   false;
    protected $table        =   "mapping_lead_agency";
    protected $primaryKey   =   "id";
    protected $guarded      =   ['id'];

}
