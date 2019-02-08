<?php

namespace App\Models\Common\Streams;

use Illuminate\Database\Eloquent\Model;

class StreamsModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps      =   false;
    protected $table        =   "streams";
    protected $primaryKey   =   "id";
    protected $guarded      =   ['id'];

}
