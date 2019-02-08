<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class BusinessKeyDetailsModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps      =   false;
    protected $table        =   "business_key_details";
    protected $primaryKey   =   "id";
    protected $guarded      =   ['id'];

}
