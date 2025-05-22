<?php

namespace App\Models;

use App\Traits\WhoColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use SoftDeletes;
    use WhoColumns;
    protected $fillable = [
        'name',
        'slug',
        'quantity',
        'product_id',
        'product_type',
        'warehouse_id',
        'attribute_value_id',
        'type',
        'source_entity_type',
        'instance_id',
        'source_entity_id',
        'serial_no',
        'batch',
        'status',
        'remarks',
    ];
}
