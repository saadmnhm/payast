<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'message',
        'is_read',
        'read_by_user_id',
        'read_at',
    ];

    protected $casts = [
        'confirmation' => 'boolean',
        'is_read' => 'boolean',
        'read_at' => 'datetime',
        'fiche' => 'array',
    ];
    public function readByUser()
    {
        return $this->belongsTo(User::class, 'read_by_user_id');
    }



    public function logs()
    {
        return $this->hasMany(DevisLog::class);
    }
}
