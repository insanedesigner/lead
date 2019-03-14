<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class LeadTypeModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps      =   false;
    protected $table        =   "lead_type";
    protected $primaryKey   =   "id_lead_type";
    protected $guarded      =   ['id_lead_type'];

}
