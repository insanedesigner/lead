<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class UserModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps      =   false;
    protected $table        =   "user";
    protected $primaryKey   =   "id_user";
    protected $guarded      =   ['id_user'];

}
