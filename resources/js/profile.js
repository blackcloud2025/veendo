 // Manejo de pestañas
 document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');

    function switchTab(tabId) {
        // Desactivar todas las pestañas
        tabButtons.forEach(button => {
            button.classList.remove('active');
        });
        tabContents.forEach(content => {
            content.classList.remove('active');
        });

        // Activar la pestaña seleccionada
        const selectedButton = document.querySelector(`[data-tab="${tabId}"]`);
        const selectedContent = document.getElementById(`${tabId}-tab`);
        
        selectedButton.classList.add('active');
        selectedContent.classList.add('active');
    }

    // Agregar eventos click a los botones
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            switchTab(button.dataset.tab);
        });
    });

    // Mostrar la pestaña de edición si hay errores
    if (window.hasErrors) {
        switchTab('edit');
    }

    // Ocultar alertas después de 5 segundos
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.display = 'none';
        }, 5000);
    });
});