<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    protected $model = Stock::class;

    public function definition(): array
    {
        // Se define aquí por seguridad, pero no se usará random
        return [
            'nombre' => 'Producto por definir',
            'precio_venta' => $this->faker->randomFloat(2, 100, 500), // Precio aleatorio
            'precio_compra' => $this->faker->randomFloat(2, 50, 250),
            'unidades' => $this->faker->numberBetween(10, 100),
            'descripcion' => $this->faker->sentence,
            'categoria_id' => null, // se asignará en el seeder
        ];
    }
}
