<?php

namespace App\Livewire;

use App\Models\Cliente;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class DashboardComponent extends Component
{
    public $cliente = '';
    public $obra_social = '';
    public $recetas = 0;
    public $direccion = '';
    public $telefono = '';
    public $ubicacion = '';
    public $forma_de_pago = '';
    public $total = 0;
    public $numero_de_cadete = '';
    public $isLoading = false;
    public $clientes = []; // Acá irían los datos para autocompletar

    public function selectCliente($clienteData)
    {
        // Decodificar los datos del cliente (se pasan como JSON)
        $cliente = json_decode($clienteData, true);

        // Rellenar todos los campos
        $this->cliente = $cliente['nombre'];
        $this->telefono = $cliente['telefono'] ?? '';
        $this->direccion = $cliente['direccion'] ?? '';
        $this->ubicacion = $cliente['ubicacion'] ?? '';

        // Ocultar la lista de sugerencias
        $this->clientes = [];
        $this->isLoading = false;
    }
    public function createCliente()
    {
        // Verificar si el cliente ya existe
        $existingCliente = Cliente::where('nombre', $this->cliente)->first();

        if ($existingCliente) {
            // Opcional: Mostrar un mensaje de error o notificación
            $this->addError('cliente', 'El cliente con este nombre ya existe.');
            return;
        }

        Cliente::create([
            'nombre' => $this->cliente,
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'ubicacion' => $this->ubicacion
        ]);
    }

    public function updatedCliente()
    {
        $this->isLoading = true;

        if (strlen($this->cliente) > 3) {
            // Buscar clientes en la base de datos
            $this->clientes = Cliente::where('nombre', 'LIKE', '%' . strtolower($this->cliente) . '%')
                ->take(5)
                ->get(['nombre', 'telefono', 'direccion', 'ubicacion'])
                ->toArray();
        } else {
            $this->clientes = [];
        }

        $this->isLoading = false;
    }

    public function updatedFormaDePago($value)
    {
        if (in_array($value, ['COBERTURA 100%', 'VALE', 'MERCADO PAGO'])) {
            $this->total = 0;
        }
    }

    public function submit()
    {
        $this->validate([
            'cliente' => 'required|string|max:255',
            'obra_social' => 'required|string|max:255',
            'recetas' => 'required|integer|min:0',
            'direccion' => 'required|string',
            'telefono' => 'required|string',
            'ubicacion' => 'nullable|url',
            'forma_de_pago' => 'required|string',
            'total' => 'nullable|numeric|min:0',
        ]);
        $this->createCliente();

        return redirect()->route('ticket', [
            'cliente' => $this->cliente,
            'obraSocial' => $this->obra_social,
            'cantidadDeRecetas' => $this->recetas,
            'formaDePago' => $this->forma_de_pago,
            'direccion' => $this->direccion,
            'ubicacion' => $this->ubicacion,
            'telefono' => $this->telefono,
            'total' => $this->total,
            'numeroCadete' => $this->numero_de_cadete
        ]);
    }
    public function render()
    {
        return view('livewire.dashboard-component');
    }
}
