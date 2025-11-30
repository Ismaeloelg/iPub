<?php

namespace App\Livewire;

use App\Imports\ProductosImport;
use App\Models\Categoria;
use App\Models\Stock;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StockExport;

class ShowStockComponent extends Component
{


    use WithFileUploads;

    public $productos;

    public $excelFile;

    public function mount()
    {
        $this->productos = Stock::with('categoria')->get();
    }

    public function exportExcel()
    {
        return Excel::download(new StockExport, 'stock.xlsx');
    }


    public function importExcel()
    {
        $this->validate([
            'excelFile' => 'required|file|mimes:xlsx,xls',
        ], [
                'excelFile.required' => 'Falta importar el archivo excel',
                'excelFile.mimes' => 'Solo se permiten formatos xlsx o xls',
            ]

        );

        try {
            Excel::import(new ProductosImport, $this->excelFile);
            session()->flash('message', '✅ Productos importados correctamente.');
        } catch (QueryException $e) {
            $mensajeUsuario = $this->interpretarError($e);
            session()->flash('error', "❌ Error al importar: $mensajeUsuario");
            \Log::error('Error al importar productos: ' . $e->getMessage());
        } catch (\Exception $e) {
            session()->flash('error', '❌ Ha ocurrido un error inesperado durante la importación.');
            \Log::error('Error inesperado al importar productos: ' . $e->getMessage());
        }

        $this->productos = Stock::with('categoria')->get();
    }

    /**
     * Devuelve un mensaje amigable según el error de MySQL
     */
    private function interpretarError(QueryException $e)
    {
        $codigo = $e->errorInfo[1] ?? null; // Código numérico de MySQL

        switch ($codigo) {
            case 1062:
                // Duplicado
                return "El nombre de uno o varios productos ya existe en el stock.";
            case 1452:
                // Foreign key
                return "Se ha intentado usar una categoría que no existe. Verifica las categorías.";
            case 1048:
                // Campo obligatorio nulo
                return "Faltan datos obligatorios en uno o varios productos.";
            default:
                return "Ocurrió un error de base de datos. Por favor, revisa los datos.";
        }
    }


    public function delete($productoId)
    {
        $producto = Stock::find($productoId);

        if ($producto) {
            try {
                $producto->delete();
                session()->flash('message', ' ✅ Producto eliminado correctamente.');
            } catch (\Exception $e) {
                if ($e->getCode() == 23000) {
                    session()->flash('error', '❌ El productos se está usando');

                }
            }
        } else {
            session()->flash('error', '❌ Producto no encontrado o ya fue eliminado.');
        }

        // Refrescar siempre la lista
        $this->productos = Stock::with('categoria')->get();
    }


    public function render()
    {
        return view('livewire.show-stock-component');
    }
}
