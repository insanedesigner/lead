<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class MediaCategoryModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps      =   false;
    protected $table        =   "media_categories";
    protected $primaryKey   =   "id";
    protected $guarded      =   ['id'];

}
