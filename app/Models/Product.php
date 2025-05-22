<?php

namespace App\Models;

use App\Traits\WhoColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    use WhoColumns;
    protected $fillable = [
        'name',
        'slug',
        'brand_id',
        'summary',
        'description',
        'sku',
        'cover',
        'warranty_in_months',
        'warranty_in_days',
        'service_type',
        'type',
        'active',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }
}
