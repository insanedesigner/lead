<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class ScreenRolesMapModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps      =   false;
    protected $table        =   "user_screen_role_map";
    protected $primaryKey   =   "id_screen_role_map";
    protected $guarded      =   ['id_screen_role_map'];

}