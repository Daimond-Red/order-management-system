<?php

namespace App\Models;

use App\Traits\WhoColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use SoftDeletes;
    use WhoColumns;
    protected $fillable = [
        'name',
        'slug',
        'type',
        'code',
        'parent_id',
        'active',
    ];
}
