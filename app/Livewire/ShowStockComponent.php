<?php

namespace App\Livewire;

use App\Models\Categoria;
use App\Models\Stock;
use Illuminate\Database\QueryException;
use Livewire\Component;

class ShowStockComponent extends Component
{
    public $productos;

    public function mount()
    {
        $this->productos = Stock::with('categoria')->get();
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
