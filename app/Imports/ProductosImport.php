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
        return new Stock([
            'nombre' => $row['nombre'],
            'unidades' => $row['unidades'],
            'categoria_id' => $row['categoria_id'],
            'precio_venta' => $row['precio_venta'],
            'precio_compra' => $row['precio_compra'],
            'descripcion' => $row['descripcion'] ?? null,
        ]);
    }
}
