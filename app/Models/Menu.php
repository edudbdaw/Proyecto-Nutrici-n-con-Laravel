<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = ['user_id', 'dish_id', 'date'];

    // Relación: Una entrada del menú es UN plato
    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
}