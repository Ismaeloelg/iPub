<?php

namespace App\Livewire;

use App\Models\Categoria;
use Livewire\Component;

class CategoriaComponent extends Component
{
    public $nombre;
    public $categorias;

    public function mount()
    {
        $this->categorias = Categoria::all();
    }

    public function delete($categoriaId)
    {
        $categoria = Categoria::find($categoriaId);

        if ($categoria) {
            try {
                $categoria->delete();
                session()->flash('message', ' ✅ Categoria eliminada correctamente');
            } catch (\Exception $e) {
                if ($e->getCode() == 23000) {
                    session()->flash('error', '❌ Esta Categoria se esta usando');
                }
                session()->flash('message', '❌ Categoria no se ha podido eliminar!! ');
            }
        }
        $this->categorias = Categoria::all();

    }

    public function guardarCategoria()
    {
        $this->validate(
            ['nombre' => 'required|unique:categorias,nombre'],
            ['nombre.required' => ' ❌ El campo nombre es requerido',
                'nombre.unique' => ' ❌ Esta categoria ya existe'
            ]
        );

        Categoria::create(
            ['nombre' => $this->nombre]
        );

        return redirect(route('stock'));
    }


    public function render()
    {
        return view('livewire.categoria-component');
    }
}
