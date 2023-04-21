<?php

namespace App\Models;

use App\Enums\AdStatus;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ad extends Model
{
    use HasFactory;

    /**
     * Get the options for generating the slug.
     */

    /**
     * Get the route key for the model.
     *
     * @return string
     */


    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ads';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The data type of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * Indicates if the model's ID is auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */


    /**
     * fields ordering in filteration
     */
    const ORDER = [''];

    /**
     * Upload Path
     */
    const UPLOADPATH = '';

    /**
     * fields that will handle upload document
     */
    const UPLOADFIELDS = [];

    ##--------------------------------- RELATIONSHIPS
    public function user()
    {
        return $this->belongsTo(User::class);
    }



    ##--------------------------------- ATTRIBUTES


    ##--------------------------------- CUSTOM FUNCTIONS


    ##--------------------------------- SCOPES

    public function scopeUserAds($query)
    {
        $query->where('user_id', Auth::user()->id);
    }


    ##--------------------------------- ACCESSORS & MUTATORS
}
