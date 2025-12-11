<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use StaticKidz\BedcaAPI\BedcaClient; // Importamos la librería

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Instanciamos el cliente de la API
        $client = new BedcaClient();

        // 2. Pedimos los grupos de alimentos
        $groups = $client->getFoodGroups();

        // 3. Recorremos y guardamos
        // La API devuelve un objeto con una propiedad "food" que es el array
        foreach ($groups->food as $group) {
            Category::create([
                // Guardamos el ID original de la API por si nos sirve para buscar productos luego
                'id' => $group->fg_id, 
                'name' => $group->fg_ori_name, // "Lácteos y derivados", etc.
            ]);
        }
    }
}