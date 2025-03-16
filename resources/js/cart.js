// Funciones para aumentar y disminuir la cantidad
window.decreaseQuantity = function(button) {
    const input = button.parentElement.querySelector('.quantity-input');
    const currentValue = parseInt(input.value);
    
    if (currentValue > 1) {
        input.value = currentValue - 1;
        updateItemTotals(input);
        updateCartTotals();
    }
}

window.increaseQuantity = function(button) {
    const input = button.parentElement.querySelector('.quantity-input');
    const currentValue = parseInt(input.value);
    
    input.value = currentValue + 1;
    updateItemTotals(input);
    updateCartTotals();
}

// Función para actualizar los totales de un item
function updateItemTotals(input) {
    const cartItem = input.closest('.cart-item');
    const quantity = parseInt(input.value);
    
    // Obtener información de precio
    const priceElement = cartItem.querySelector('.product-price');
    let price = 0;
    let discountPercentage = 0;
    
    // Verificar si hay descuento
    const originalPriceElement = priceElement.querySelector('.original-price');
    const discountBadge = priceElement.querySelector('.discount-badge');
    
    if (originalPriceElement) {
        // Producto con descuento
        price = parseFloat(originalPriceElement.textContent.replace('$', '').replace(/,/g, ''));
        discountPercentage = parseFloat(discountBadge.textContent.replace('-', '').replace('%', ''));
    } else {
        // Sin descuento
        price = parseFloat(priceElement.querySelector('span').textContent.replace('$', '').replace(/,/g, ''));
    }
    
    // Calcular totales
    const subtotal = price * quantity;
    const discountAmount = subtotal * (discountPercentage / 100);
    const total = subtotal - discountAmount;
    
    // Actualizar totales del item en la UI
    const itemTotals = cartItem.querySelector('.item-price-details');
    itemTotals.querySelector('div:nth-child(1) span').textContent = '$' + formatNumber(subtotal);
    
    const discountElement = itemTotals.querySelector('.discount-amount');
    if (discountPercentage > 0 && discountElement) {
        discountElement.textContent = '-$' + formatNumber(discountAmount);
    }
    
    itemTotals.querySelector('.item-total span').textContent = '$' + formatNumber(total);
    
    // Activar el botón de actualizar automáticamente después de un retraso
    const form = cartItem.querySelector('.quantity-form');
    if (form.updateTimeout) {
        clearTimeout(form.updateTimeout);
    }
    
    form.updateTimeout = setTimeout(() => {
        // Mostrar indicador visual de actualización
        const updateBtn = form.querySelector('.update-btn');
        updateBtn.classList.add('updating');
        
        // Enviar el formulario
        form.submit();
    }, 800);
}

// Función para actualizar los totales del carrito
function updateCartTotals() {
    const cartItems = document.querySelectorAll('.cart-item');
    
    let cartSubtotal = 0;
    let cartDiscount = 0;
    let cartTotal = 0;
    
    // Calcular totales de todos los items
    cartItems.forEach(item => {
        const itemTotals = item.querySelector('.item-price-details');
        const subtotalText = itemTotals.querySelector('div:nth-child(1) span').textContent;
        const subtotal = parseFloat(subtotalText.replace('$', '').replace(/,/g, ''));
        
        const discountElement = itemTotals.querySelector('.discount-amount');
        let discount = 0;
        if (discountElement) {
            discount = parseFloat(discountElement.textContent.replace('-$', '').replace(/,/g, ''));
        }
        
        const totalText = itemTotals.querySelector('.item-total span').textContent;
        const total = parseFloat(totalText.replace('$', '').replace(/,/g, ''));
        
        cartSubtotal += subtotal;
        cartDiscount += discount;
        cartTotal += total;
    });
    
    // Actualizar resumen en la UI
    const summary = document.querySelector('.order-summary');
    if (summary) {
        summary.querySelector('.summary-row:nth-child(2) span:nth-child(2)').textContent = '$' + formatNumber(cartSubtotal);
        summary.querySelector('.discount-row span:nth-child(2)').textContent = '-$' + formatNumber(cartDiscount);
        summary.querySelector('.total-row span:nth-child(2)').textContent = '$' + formatNumber(cartTotal);
    }
}

// Función para formatear números con separador de miles
function formatNumber(number) {
    return number.toFixed(2).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}

// Inicializar eventos cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function() {
    // Agregar event listeners a los inputs de cantidad para actualizar cuando se cambia manualmente
    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('change', function() {
            updateItemTotals(this);
            updateCartTotals();
        });
    });
    
    // Agregar confirmación al botón de vaciar carrito
    const clearCartBtn = document.querySelector('.clear-cart-btn');
    if (clearCartBtn) {
        clearCartBtn.addEventListener('click', function(e) {
            if (!confirm('¿Estás seguro de que deseas vaciar el carrito?')) {
                e.preventDefault();
            }
        });
    }
    
    // Agregar estilos CSS para la animación de actualización
    const style = document.createElement('style');
    style.textContent = `
        .update-btn.updating {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    `;
    document.head.appendChild(style);
});