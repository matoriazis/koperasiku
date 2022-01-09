<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Saving extends Model
{
    use HasFactory;

    public const POKOK = 'Pokok';
    public const WAJIB = 'Wajib';
    public const SUKARELA = 'Sukarela';

    public const LUNAS = 'Lunas';

    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    
}
