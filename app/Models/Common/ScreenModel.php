<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class ScreenModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps      =   false;
    protected $table        =   "user_screens";
    protected $primaryKey   =   "id_user_screen";
    protected $guarded      =   ['id_user_screen'];

}