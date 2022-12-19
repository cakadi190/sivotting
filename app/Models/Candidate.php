<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Get All Votes - Mengambil semua hasil perolehan suara.
     *
     * @return Illuminate\Database\Eloquent\Model
     */
    public function getVotes()
    {
        return $this->hasMany(Vote::class, 'candidate', 'id');
    }
}
