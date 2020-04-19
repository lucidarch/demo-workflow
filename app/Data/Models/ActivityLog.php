<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity';

    protected $fillable = ['user_id', 'description'];

    public function actor()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
