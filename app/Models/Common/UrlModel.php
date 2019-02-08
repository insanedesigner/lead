<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class UrlModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps      =   false;
    protected $table        =   "urls";
    protected $primaryKey   =   "id_url";
    protected $guarded      =   ['id_url'];

}