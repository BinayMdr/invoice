<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterMenu extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function subFooterMenu()
    {
        return $this->hasMany(SubFooterMenu::class);
    }
}
