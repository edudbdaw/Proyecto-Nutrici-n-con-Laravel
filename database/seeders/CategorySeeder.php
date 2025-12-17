<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

// ... imports ...
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $client = new \StaticKidz\BedcaAPI\BedcaClient();
        $groups = $client->getFoodGroups();

        foreach ($groups->food as $group) {
            Category::create([
                // Izquierda: NUESTRA columna en BBDD
                // Derecha: EL DATO que viene de la API
                'bedca_id' => $group->fg_id,     
                'name'     => $group->fg_ori_name, 
            ]);
        }
    }
}