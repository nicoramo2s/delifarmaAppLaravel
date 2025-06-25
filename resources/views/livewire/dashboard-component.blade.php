<div class="shadow-2xl p-6 rounded-xl mt-10 border-base-300 border w-full max-w-md mx-auto">
    <h1 class="text-secondary text-6xl font-medium mb-5 text-center">
        Deli<span class="text-primary font-black">Farma</span>
    </h1>

    <form wire:submit.prevent="submit" class="space-y-4 px-6">
        <h3 class="text-3xl font-bold mb-2">Pedido Delivery</h3>

        {{-- Cliente --}}
        <div class="flex flex-col relative">
            <label for="cliente" class="label label-text mb-1">Nombre del Cliente</label>
            <input id="cliente" type="text" class="input w-full uppercase" wire:model.live.debounce.300ms="cliente"
                autocomplete="off">

            <span wire:loading class="mt-1 loading loading-dots loading-md"></span>

            @error('cliente')
                <span class="text-error text-xs mt-1">{{ $message }}</span>
            @enderror

            @if (count($clientes))
                <ul class="absolute top-full z-10 menu bg-base-200 rounded w-full mt-1 shadow-lg">
                    @foreach ($clientes as $c)
                        <li><a wire:click.prevent="selectCliente('{{ json_encode($c) }}')"
                                class="uppercase">{{ $c['nombre'] }}</a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- Obra Social --}}
        <div class="flex flex-col">
            <label class="label label-text mb-1">Obra Social / Particular</label>
            <input type="text" class="input w-full uppercase placeholder:normal-case" wire:model.defer="obra_social"
                placeholder="Ej: OSDE, PARTICULAR">
            @error('obra_social')
                <span class="text-error text-xs">{{ $message }}</span>
            @enderror
        </div>

        {{-- Recetas --}}
        <div class="flex flex-col">
            <label class="label label-text mb-1">Cantidad de Recetas</label>
            <input type="number" min="0" class="input w-full" wire:model.defer="recetas" placeholder="0">
            @error('recetas')
                <span class="text-error text-xs">{{ $message }}</span>
            @enderror
        </div>

        {{-- Dirección --}}
        <div class="flex flex-col">
            <label class="label label-text mb-1">Dirección / Descripción</label>
            <textarea class="textarea w-full rounded resize-none" wire:model.defer="direccion"
                placeholder="Ej: Casa blanca, rejas rojas"></textarea>
            @error('direccion')
                <span class="text-error text-xs">{{ $message }}</span>
            @enderror
        </div>

        {{-- Teléfono --}}
        <div class="flex flex-col">
            <label class="label label-text mb-1">Teléfono</label>
            <input type="tel" class="input w-full" wire:model.defer="telefono" placeholder="Ej: 264 123 4567"
                autocomplete="off">
            @error('telefono')
                <span class="text-error text-xs">{{ $message }}</span>
            @enderror
        </div>

        {{-- Ubicación --}}
        <div class="flex flex-col">
            <label class="label label-text mb-1">Ubicación (link)</label>
            <input type="url" class="input w-full" wire:model.defer="ubicacion" placeholder="Enlace de Google Maps">
            @error('ubicacion')
                <span class="text-error text-xs">{{ $message }}</span>
            @enderror
        </div>

        {{-- Forma de pago --}}
        <div class="flex flex-col">
            <label class="label label-text mb-1">Forma de Pago</label>
            <select class="select w-full rounded" wire:model="forma_de_pago">
                <option value="">-- Selecciona Método de Pago --</option>
                @foreach (['CREDITO', 'DEBITO', 'EFECTIVO', 'MERCADO PAGO', 'COBERTURA 100%', 'VALE'] as $opcion)
                    <option value="{{ $opcion }}">{{ $opcion }}</option>
                @endforeach
            </select>
            @error('forma_de_pago')
                <span class="text-error text-xs">{{ $message }}</span>
            @enderror
        </div>

        {{-- Total a cobrar (condicional) --}}
        @if (!($forma_de_pago == 'COBERTURA 100%' || $forma_de_pago == 'MERCADO PAGO' || $forma_de_pago == 'VALE'))
            <div class="flex flex-col">
                <label class="label label-text mb-1">Total a Cobrar</label>
                <input type="number" min="0" class="input w-full" wire:model.defer="total" placeholder="0">
            </div>
        @endif
        @error('total')
            <span class="text-error text-xs">{{ $message }}</span>
        @enderror

        <div class="flex flex-col">
            <label class="label label-text mb-1">Cadete</label>
            <select class="select w-full rounded" wire:model="numero_de_cadete">
                <option value="" disabled selected>-- Selecciona el Cadete --</option>
                @foreach (['GONZALO' => '5491163540082', 'ENZO' => '5492643179886'] as $nombre => $numero)
                    <option value="{{ $numero }}">{{ $nombre }}</option>
                @endforeach
            </select>
            @error('numero_de_cadete')
                <span class="text-error text-xs">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary w-full rounded mt-2">
            Imprimir y Enviar
        </button>

        @if (session()->has('success'))
            <div class="alert alert-success mt-4">{{ session('success') }}</div>
        @endif
    </form>
</div>
