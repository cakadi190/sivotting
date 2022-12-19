<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get all candidate
     *
     * @return void
     */
    public function getCandidate()
    {
        return $this->belongsTo(Candidate::class, 'candidate', 'id');
    }
}
