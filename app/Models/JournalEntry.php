<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JournalEntry extends Model
{
    protected $fillable = [
        'reference', 'description', 'entry_date', 'admin_id',
    ];

    public function journalLines()
    {
        return $this->hasMany(JournalLine::class);
    }
}
