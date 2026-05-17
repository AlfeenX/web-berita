<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id','bio','avatar','phone'])]
class Profile extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
