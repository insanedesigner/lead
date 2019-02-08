<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class RolesModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps      =   false;
    protected $table        =   "user_roles";
    protected $primaryKey   =   "id_roles";
    protected $guarded      =   ['id_roles'];

}