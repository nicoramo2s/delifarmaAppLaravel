<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class TicketComponent extends Component
{
    public $cliente;
    public $obraSocial;
    public $cantidadDeRecetas;
    public $formaDePago;
    public $direccion;
    public $ubicacion;
    public $telefono;
    public $total;
    public $numeroCadete;

    public string $whatsappUrl = '';

    public function mount()
    {
        $this->cliente = request()->get('cliente', '');
        $this->obraSocial = request()->get('obraSocial', '');
        $this->cantidadDeRecetas = request()->get('cantidadDeRecetas', 0);
        $this->formaDePago = request()->get('formaDePago', '');
        $this->direccion = request()->get('direccion', '');
        $this->ubicacion = request()->get('ubicacion', '');
        $this->telefono = request()->get('telefono', '');
        $this->total = request()->get('total', 0);
        $this->numeroCadete = request()->get('numeroCadete', '');
        // 👇 esto genera y despacha el evento con el link de WhatsApp
        $this->generarLinkWhatsapp();
    }
    private function generarLinkWhatsapp()
    {
        $clienteUpper = strtoupper($this->cliente);
        $mensaje = "🧾 *Nuevo pedido DeliFarma*\n"
            . "\n"
            . "*{$clienteUpper}*\n"
            . "\n"
            . "*Obra Social:* {$this->obraSocial}\n"
            . "*Recetas:* {$this->cantidadDeRecetas}\n"
            . "*Forma de Pago:* {$this->formaDePago}\n"
            . "*Direccion:* {$this->direccion}\n"
            . "*Ubicacion:* {$this->ubicacion}\n"
            . "*Teléfono:* {$this->telefono}\n"
            . "*Total:* \${$this->total}\n"
            . "\n"
            . "🛵 *Enviar al cadete*";


        $numero = $this->numeroCadete; // Reemplazar con el número de destino

        $whatsappUrl = "https://wa.me/{$numero}?text=" . urlencode($mensaje);
        $this->dispatch('imprimir-ticket', whatsappUrl: $whatsappUrl);

    }

    public function render()
    {
        return view('livewire.ticket-component');
    }
}
