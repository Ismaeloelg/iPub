<?php

namespace App\Imports;

use App\Models\Stock;
use App\Models\Categoria;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductosImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Limpiar y asignar valores
        $nombre = trim($row['nombre'] ?? '');
        $unidades = (int) ($row['unidades'] ?? 0);
        $precio_venta = (float) ($row['precio_venta'] ?? 0);
        $precio_compra = (float) ($row['precio_compra'] ?? 0);
        $descripcion = trim($row['descripcion'] ?? '');
        $categoriaId = (int) ($row['categoria_id'] ?? 0);

        // Validaciones
        if (!$nombre) {
            throw new \Exception("Nombre del producto vacío en una fila del Excel. Elimine las celdas vacias si la hubiere");
        }

        $categoria = Categoria::find($categoriaId);
        if (!$categoria) {
            throw new \Exception("La categoría con ID '{$categoriaId}' no existe. Producto '{$nombre}' no se importó.");
        }

        // Insertar o actualizar producto
        return Stock::updateOrCreate(
            ['nombre' => $nombre],
            [
                'unidades' => $unidades,
                'categoria_id' => $categoria->id,
                'precio_venta' => $precio_venta,
                'precio_compra' => $precio_compra,
                'descripcion' => $descripcion,
            ]
        );
    }
}
