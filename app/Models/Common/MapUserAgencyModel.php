<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class MapUserAgencyModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps      =   false;
    protected $table        =   "mapping_user_agency";
    protected $primaryKey   =   "id";
    protected $guarded      =   ['id'];

}
