<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class UserInfoModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps      =   false;
    protected $table        =   "users_info";
    protected $primaryKey   =   "id_users_info";
    protected $guarded      =   ['id_users_info'];

}