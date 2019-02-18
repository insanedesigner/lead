<?php

namespace App\Models\Common\University;

use Illuminate\Database\Eloquent\Model;

class UniversityModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps      =   false;
    protected $table        =   "university";
    protected $primaryKey   =   "id";
    protected $guarded      =   ['id'];

}
