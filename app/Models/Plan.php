<?php

// app/Models/Plan.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'price', 'icon', 'color']; // No need for 'feature_id'

    /**
     * Define the relationship between Plan and Feature.
     * Each plan can have many features associated with it.
     */
    public function features()
    {
        return $this->hasMany(Feature::class); // No need to specify 'feature_id', it's inferred
    }
}
