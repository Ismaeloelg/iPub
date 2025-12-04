<?php

namespace Database\Seeders;

use App\Models\Categoria;
use App\Models\Mesa;
use App\Models\Stock;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear mesas
        Mesa::factory(20)->create();

        // Crear categorías
        $categoriasNombres = [
            'Cervezas',
            'Refrescos',
            'Whisky',
            'Ron',
            'Gin',
            'Vodka',
            'Vinos',
            'Cócteles',
            'Licores',
            'Chupitos',
        ];

        foreach ($categoriasNombres as $nombre) {
            Categoria::create(['nombre' => $nombre]);
        }

        // Crear usuarios
        User::factory(3)->create();

        User::create([
            'name' => 'Noadmin',
            'password' => bcrypt('1075'),
            'avatar' => 'images/shinchan.png',
            'role' => 'user',
        ]);

        User::create([
            'name' => 'admin',
            'password' => bcrypt('1075'),
            'avatar' => 'images/shinchan.png',
            'role' => 'admin',
        ]);

        $bebidasPorCategoria = [
            'Refrescos' => [
                'Coca-Cola', 'Coca-Cola Zero', 'Pepsi', 'Sprite', 'Fanta Naranja',
                'Fanta Limón', '7 Up', 'Agua mineral', 'Agua con gas', 'Jugo de naranja',
                'Jugo de manzana', 'Té frío', 'Limonada'
            ],
            'Cervezas' => [
                'Corona', 'Heineken', 'Budweiser', 'Stella Artois', 'Quilmes',
                'Modelo Especial', 'Dos Equis', 'Guinness', 'Paulaner', 'Bud Light'
            ],
            'Ron' => [
                'Havana Club 3', 'Havana Club 7', 'Bacardí Blanco', 'Bacardí Añejo',
                'Ron Abuelo 7', 'Zacapa 23', 'Flor de Caña 12', 'Diplomático', 'Captain Morgan', 'Matusalem'
            ],
            'Gin' => [
                'Beefeater', 'Tanqueray', 'Bombay Sapphire', 'Hendrick’s', 'Gordons',
                'Monkey 47', 'The Botanist', 'Seagram’s', 'Citadelle', 'Gin Mare'
            ],
            'Whisky' => [
                "Jack Daniel's", 'Johnnie Walker Black Label', 'Johnnie Walker Red Label',
                'Jameson', 'Chivas Regal', 'Old Parr', 'Bushmills', 'Ballantine’s', 'Macallan 12', 'Glenfiddich 12'
            ],
            'Vodka' => [
                'Smirnoff', 'Absolut', 'Grey Goose', 'Skyy Vodka', 'Belvedere',
                'Stolichnaya', 'Ciroc', 'Ketel One', 'Russian Standard', 'Finlandia'
            ],
            'Vinos' => [
                'Malbec', 'Cabernet Sauvignon', 'Merlot', 'Chardonnay', 'Sauvignon Blanc',
                'Pinot Noir', 'Syrah', 'Tempranillo', 'Riesling', 'Zinfandel'
            ],
            'Cócteles' => [
                'Mojito', 'Piña Colada', 'Daiquiri', 'Margarita', 'Sex on the Beach',
                'Cosmopolitan', 'Negroni', 'Bloody Mary', 'Mai Tai', 'Long Island Iced Tea'
            ],
            'Licores' => [
                'Baileys', 'Jägermeister', 'Amaretto', 'Frangelico', 'Fernet Branca',
                'Sambuca', 'Cointreau', 'Grand Marnier', 'Kahlúa', 'Campari'
            ],
            'Chupitos' => [
                'Tequila', 'Jägerbomb', 'Kamikaze', 'B52', 'Lemon Drop',
                'Sambuca Shot', 'Fireball', 'Goldschlager', 'Sour Apple', 'Peppermint Schnapps'
            ],
        ];


        foreach ($bebidasPorCategoria as $categoriaNombre => $bebidas) {
            $categoria = Categoria::where('nombre', $categoriaNombre)->first();

            foreach ($bebidas as $bebida) {
                Stock::create([
                    'nombre' => $bebida,
                    'precio_venta' => rand(2, 5),
                    'precio_compra' => rand(1, 2),
                    'unidades' => rand(10, 100),
                    'descripcion' => 'Deliciosa ' . $bebida,
                    'categoria_id' => $categoria->id,
                ]);
            }
        }
    }
}
