function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
}

window.saveOrder = function() {
    const loading = document.getElementById('loading');
    const actions = document.querySelector('.modal-actions');
    
    if (loading) loading.style.display = 'block';
    if (actions) actions.style.display = 'none';

    const csrfToken = getCsrfToken();
    
    fetch('/order/store', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({})
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Venta guardada correctamente. Orden #' + data.order_id);
            window.location.href = '/Cart';
        } else {
            alert('Error: ' + (data.message || 'Error al guardar la venta'));
            if (loading) loading.style.display = 'none';
            if (actions) actions.style.display = 'flex';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al procesar la solicitud: ' + error.message);
        if (loading) loading.style.display = 'none';
        if (actions) actions.style.display = 'flex';
    });
};

window.printTicket = function() {
    const content = document.getElementById('ticket-content').innerHTML;
    const printWindow = window.open('', '', 'width=400,height=600');
    printWindow.document.write(`
        <html>
            <head>
                <title>Ticket de Compra</title>
                <style>
                    body { font-family: Arial, sans-serif; padding: 20px; max-width: 400px; }
                    .ticket-header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 15px; margin-bottom: 20px; }
                    .ticket-item { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #ddd; }
                    .ticket-totals { margin-top: 20px; padding-top: 15px; border-top: 2px solid #000; }
                    .total-row { display: flex; justify-content: space-between; font-weight: bold; }
                </style>
            </head>
            <body>
                ${content}
            </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
};

window.cancelOrder = function() {
    document.getElementById('checkout-modal').style.display = 'none';
};