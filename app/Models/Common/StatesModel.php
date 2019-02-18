<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class StatesModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps      =   false;
    protected $table        =   "states";
    protected $primaryKey   =   "id";
    protected $guarded      =   ['id'];

}
