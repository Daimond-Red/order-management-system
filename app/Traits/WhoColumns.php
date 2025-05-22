<?php
namespace App\Traits;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

trait WhoColumns
{
    /**
     * Indicates if the model should be who columned.
     *
     * @var bool
     */
    public $who_columns = true;

    public static function bootWhoColumns()
    {
        static::creating(function ($table) {

            if(isset($table->who_columns) && $table->who_columns)   {

                $table->created_by = Auth::check() ? Auth::user()->id : (\request('user_id') ? \request('user_id') : 1);
            }
        });

        static::created(function ($table) {

            if (isset ($table->who_columns) && $table->who_columns) {

                $table->created_by = Auth::check() ? Auth::user()->id : 1;
            }
        });

        static::updating(function ($table) {

            if (isset ($table->who_columns) && $table->who_columns) {

                $table->updated_by = Auth::check() ? Auth::user()->id : 1;
            }
        });

        static::deleting(function ($table) {

            if (isset ($table->who_columns) && $table->who_columns) {

                $table->deleted_by = Auth::check() ? Auth::user()->id : 1;
                $table->save(); // Hack to save deleted by column
            }
        });

        // TODO: Issue with restoring and restored event
        // static::restoring(function($table)  {
        //     $table->deleted_by = '';
        //     // $table->save(); // Hack to save deleted by column
        // });
    }

    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function updated_by_user()
    {
        return $this->belongsTo(User::class, 'updated_by', 'id');
    }

    public function deleted_by_user()
    {
        return $this->belongsTo(User::class, 'deleted_by', 'id');
    }

    public function scopeWithWho($query)
    {
        return $query->with(['created_by_user', 'updated_by_user', 'deleted_by_user']);
    }
}
