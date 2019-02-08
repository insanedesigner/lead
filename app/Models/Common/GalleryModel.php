<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class GalleryModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps      =   false;
    protected $table        =   "gallery";
    protected $primaryKey   =   "id";
    protected $guarded      =   ['id'];

}
