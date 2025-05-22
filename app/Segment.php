<?php

namespace App;

use App\Traits\WhoColumns;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Segment extends Model
{
    use SoftDeletes;
    use WhoColumns;
    protected $fillable = [
        'name',
        'slug',
        'cover',
        'type',
        'active',
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }
}
