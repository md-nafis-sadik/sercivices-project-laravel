<?php

// app/Models/Feature.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $fillable = ['plan_id', 'description']; // 'plan_id' is the foreign key now

    /**
     * Define the relationship between Feature and Plan.
     * Each feature belongs to one plan.
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class); // Default foreign key is 'plan_id'
    }
}
