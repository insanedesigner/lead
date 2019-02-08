<?php

namespace App\Models\Common;

use Illuminate\Database\Eloquent\Model;

class AuditEventModel extends Model
{
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps      =   false;
    protected $table        =   "audit_trail";
    protected $primaryKey   =   "id";
    protected $guarded      =   ['id'];

}
