<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    protected $fillable = ['name', 'user_id'];

    // Un plato pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Un plato tiene muchos ingredientes (Productos)
    // withPivot('amount') es VITAL para poder leer los gramos luego
    public function products()
    {
        return $this->belongsToMany(Product::class)->withPivot('amount');
    }
    
    // CALCULAR CALORÍAS TOTALES DEL PLATO
    public function getTotalCaloriesAttribute()
    {
        // Recorremos los productos y sumamos: (CaloriasProducto * Gramos / 100)
        return $this->products->sum(function($product) {
            return ($product->calories * $product->pivot->amount) / 100;
        });
    }
}

