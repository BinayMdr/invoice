<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function hasRole($roleId)
    {
        return GroupHasRole::where('group_id',$this->id)
                            ->where('role_id',$roleId)->first();
    }

    public function roles()
    {
        return $this->hasMany(GroupHasRole::class);
    }
}
