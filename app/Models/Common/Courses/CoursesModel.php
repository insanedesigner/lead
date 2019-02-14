<?php

namespace App\Models\Common\Courses;

use Illuminate\Database\Eloquent\Model;

class CoursesModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps      =   false;
    protected $table        =   "courses";
    protected $primaryKey   =   "id";
    protected $guarded      =   ['id'];

}
