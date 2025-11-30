<?php

namespace App\Exports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StockExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Stock::with('categoria')
            ->get()
            ->map(function ($stock) {
                return [
                    'nombre' => $stock->nombre,
                    'unidades' => $stock->unidades,
                    'categoria_id' => $stock->categoria->id,
                    'categoria' => $stock->categoria->nombre,
                    'precio_venta' => $stock->precio_venta,
                    'precio_compra' => $stock->precio_compra,
                    'descripcion' => $stock->descripcion,
                ];
            });
    }

    public function headings(): array
    {
        return ['nombre', 'unidades', 'categoria_id', 'categoria', 'precio_venta', 'precio_compra', 'descripcion'];
    }
}
