<?php

namespace App\Models\Common\Courses;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps      =   false;
    protected $table        =   "courses_categories";
    protected $primaryKey   =   "id";
    protected $guarded      =   ['id'];

}
