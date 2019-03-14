<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class UserTypeModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps      =   false;
    protected $table        =   "user_type";
    protected $primaryKey   =   "id_user_type";
    protected $guarded      =   ['id_user_type'];

}
