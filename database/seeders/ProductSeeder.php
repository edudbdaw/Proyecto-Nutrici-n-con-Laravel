<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use StaticKidz\BedcaAPI\BedcaClient;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Instanciamos el cliente de la API (El Camión)
        $client = new BedcaClient();

        // 2. Traemos todas las categorías que ya tienes en tu BBDD
        // (Necesitamos sus IDs para saber qué pedirle a la API)
        $categories = Category::all();

        // 3. BUCLE MAYOR: Vamos pasillo por pasillo (Categoría por Categoría)
        foreach ($categories as $category) {

            // Esto es solo para que veas en la consola qué está pasando
            $this->command->info("📡 Buscando productos para: " . $category->name);

            // 4. Pedimos la LISTA SIMPLE de productos de esa categoría
            // Usamos $category->bedca_id porque la API no conoce nuestros IDs internos (1, 2...),
            // conoce sus propios IDs (Lácteos = 1, Frutas = 5...)
            $productsList = $client->getFoodsInGroup($category->bedca_id);

            // Si la categoría está vacía en la API, saltamos a la siguiente
            if (!isset($productsList->food)) {
                continue;
            }

            // ⚠️ TRUCO DE DESARROLLADOR: 
            // Como descargar 500 productos tarda mucho, cortamos el array.
            // "Dame solo desde el 0 hasta el 7". Así probamos rápido.
            $productsSlice = array_slice($productsList->food, 0, 7);

            // 5. BUCLE MENOR: Vamos producto a producto (Manzana, Pera...)
            foreach ($productsSlice as $apiProduct) {

                // VALIDACIÓN: Si ya tenemos este producto (por su ID bedca), no lo creamos otra vez.
                // Evita duplicados si ejecutas el seeder dos veces.
                if (Product::where('bedca_id', $apiProduct->f_id)->exists()) {
                    continue;
                }

                try {
                    // 6. LA PETICIÓN PESADA: "Dame la ficha técnica completa de este ID"
                    $fullData = $client->getFood($apiProduct->f_id);

                    // CORRECCIÓN AQUÍ: Accedemos primero a 'food' y luego a 'foodvalue'
                    // A veces la API devuelve 'food' como array si hay fallo, validamos que sea objeto.
                    if (!isset($fullData->food) || !isset($fullData->food->foodvalue)) {
                        continue; // Si viene vacío o roto, saltamos
                    }

                    $nutrients = $fullData->food->foodvalue;

                    // 7. PREPARACIÓN DE DATOS (LA REFINERÍA)

                    // CALORÍAS (Especial): Viene en KJ (ID 409), hay que pasar a Kcal
                    $energyKJ = $this->extractValue($nutrients, 409);
                    $caloriesKcal = $energyKJ / 4.184;

                    // 8. GUARDADO EN BASE DE DATOS
                    Product::create([
                        'bedca_id'      => $apiProduct->f_id,
                        'name'          => $apiProduct->f_ori_name,
                        'category_id'   => $category->id,
                        'user_id'       => null,

                        'calories'      => $caloriesKcal,
                        'fats'          => $this->extractValue($nutrients, 410),
                        'proteins'      => $this->extractValue($nutrients, 416),
                        'carbohydrates' => $this->extractValue($nutrients, 53),
                        'fiber'         => $this->extractValue($nutrients, 307),
                        'cholesterol'   => $this->extractValue($nutrients, 433),
                        'fats_sat'      => $this->extractValue($nutrients, 299),
                        'fats_mono'     => $this->extractValue($nutrients, 282),
                        'fats_poly'     => $this->extractValue($nutrients, 287),
                    ]);

                    $this->command->getOutput()->write('.');
                } catch (\Exception $e) {
                    // Si falla, mostramos el error real
                    $this->command->error("Error en ID " . $apiProduct->f_id . ": " . $e->getMessage());
                }
            }
            // Salto de línea en consola al terminar una categoría
            $this->command->newLine();
        }
    }

    /**
     * 🧠 FUNCIÓN AYUDANTE (HELPER)
     * ¿Por qué existe? Para no repetir el mismo bucle foreach 10 veces arriba.
     * Recibe: El array gigante de nutrientes y el ID que buscamos (ej: 416).
     * Devuelve: El valor (ej: 10.5) o 0 si no lo encuentra.
     */
    /**
     * Versión 2.0 (Blindada contra objetos raros)
     */
    private function extractValue(array $nutrientList, int $targetId): float
    {
        foreach ($nutrientList as $nutrient) {
            if ($nutrient->c_id == $targetId) {
                
                // --- NUEVA PROTECCIÓN ---
                // Si el valor es un objeto o un array (ej: trazas), devolvemos 0
                if (is_object($nutrient->best_location) || is_array($nutrient->best_location)) {
                    return 0.0;
                }
                // ------------------------

                return (float) $nutrient->best_location;
            }
        }
        return 0.0;
    }
}
