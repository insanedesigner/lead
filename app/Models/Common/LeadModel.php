<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class LeadModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps      =   false;
    protected $table        =   "lead";
    protected $primaryKey   =   "id_lead";
    protected $guarded      =   ['id_lead'];

}
