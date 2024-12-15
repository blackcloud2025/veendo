document.addEventListener('DOMContentLoaded', function() {
    const deleteProfileBtn = document.getElementById('delete-profile');
    const confirmModal = document.getElementById('confirm-modal');
    const cancelDeleteBtn = document.getElementById('cancel-delete');
    const confirmDeleteBtn = document.getElementById('confirm-delete');
    const passwordForm = document.getElementById('password-form');

    deleteProfileBtn.addEventListener('click', function() {
        confirmModal.style.display = 'block';
    });

    cancelDeleteBtn.addEventListener('click', function() {
        confirmModal.style.display = 'none';
    });

    confirmDeleteBtn.addEventListener('click', function() {
        console.log('Perfil eliminado');
        confirmModal.style.display = 'none';
    });

    passwordForm.addEventListener('submit', function(e) {
        e.preventDefault();
        console.log('Cambio de contraseña solicitado');
    });
});

