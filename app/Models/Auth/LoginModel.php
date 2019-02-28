<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class LoginModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps      =   false;
    protected $table        =   "user";
    protected $primaryKey   =   "id";
    protected $guarded      =   ['id'];

    /*public function userType(){
        return $this->hasOne('App\Models\Users\UserTypeModel');
    }*/

}
