<?php

namespace App\Models\Common\University;

use Illuminate\Database\Eloquent\Model;

class UniversityCourseMappingModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps      =   false;
    protected $table        =   "mapping_university_courses";
    protected $primaryKey   =   "id";
    protected $guarded      =   ['id'];

}
