<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DevisLog extends Model
{
    protected $table = 'devislogs';
    
    protected $fillable = [
        'devis_id',
        'etatdevis',
        'etatcommentaire',
        'etatdate',
        'user_id'
    ];
    
    protected $casts = [
        'etatdate' => 'datetime',
    ];
    
    public function devis()
    {
        return $this->belongsTo(Devis::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}