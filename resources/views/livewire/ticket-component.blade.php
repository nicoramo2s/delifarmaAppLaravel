<div id="ticket" class="ticket-content">
    <h2 class="text-center text-lg font-bold mb-2">Farmacia Desamparados 3</h2>
    <hr class="border my-2" />
    <p><strong>Cliente:</strong> <span class="uppercase text-xl">{{ $cliente }}</span></p>
    <p><strong>Obra Social:</strong> <span class="uppercase">{{ $obraSocial }}</span></p>
    <p><strong>Recetas para firmar:</strong> <span class="uppercase">{{ $cantidadDeRecetas }}</span></p>
    <p><strong>Forma de pago:</strong> <span class="uppercase">{{ $formaDePago }}</span></p>
    <p><strong>Dirección:</strong> <span class="uppercase">{{ $direccion }}</span></p>
    <p><strong>Teléfono:</strong> <span class="uppercase">{{ $telefono }}</span></p>
    <p><strong>Total:</strong> <span class="uppercase">{{ $total }}</span></p>
    <hr class="border my-2" />
    <p class="text-center text-xs mt-2">¡Gracias por su pedido!</p>
</div>

<script>
    window.addEventListener('imprimir-ticket', e => {
        const width = 600;
        const height = 700;
        const left = (window.screen.width / 2) - (width / 2);
        const top = (window.screen.height / 2) - (height / 2);
        setTimeout(() => {
            const ticket = document.getElementById('ticket');
            if (!ticket) {
                alert('No se encontró el ticket.');
                return;
            }

            const contenido = ticket.innerHTML;
            const win = window.open('', '', 'width=600,height=800');

            win.document.write(`
                <html>
                <head>
                    <title>Ticket</title>
                    <style>
                        body {
                            font-family: monospace;
                            padding: 0;
                            margin: 0;
                            width: 80mm;
                            font-size: 14px;
                        }
                        @media print {
                            @page {
                                size: 80mm auto;
                                margin: 0;
                            }
                        }
                    </style>
                </head>
                <body onload="window.print(); setTimeout(() => { window.close(); }, 500)">
                    ${contenido}
                </body>
                </html>
            `);

            win.document.close();

            // ✅ Abre WhatsApp (si se envió desde Livewire)
            const whatsappUrl = e.detail?.whatsappUrl;
            if (whatsappUrl) {
                setTimeout(() => {
                    window.open(whatsappUrl, 'wspPopup',
                        `width=${width},height=${height},top=${top},left=${left},toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes`
                    );
                }, 800); // pequeño delay para evitar conflictos con print
            }
            console.log("WSP link:", e.detail?.whatsappUrl);

            // ✅ Redirige al formulario principal
            setTimeout(() => {
                window.location.href = '/';
            }, 1500);
        }, 300);
    });
</script>
