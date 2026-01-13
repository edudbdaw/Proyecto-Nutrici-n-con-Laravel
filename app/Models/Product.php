<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'bedca_id',      // Necesario para guardar el ID externo
        'name',          // Necesario para el nombre
        'category_id',   // Necesario para la relación
        'user_id',       // Necesario para saber de quién es
        // Y todos los macros...
        'calories', 'proteins', 'carbohydrates', 'fats', 
        'fiber', 'cholesterol', 'fats_sat', 'fats_mono', 'fats_poly'
    ];

    // Relación: Un producto "PERTENECE A" una Categoría
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relación: Un producto "PERTENECE A" un Usuario (opcionalmente)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dishes()
    {
        return $this->belongsToMany(Dish::class)->withPivot('amount');
    }
}
