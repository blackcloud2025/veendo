
document.getElementById('images').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = ''; // Limpiar preview existente
    
    if (this.files.length > 10) {
        alert('Solo puedes subir un máximo de 10 imágenes');
        this.value = '';
        return;
    }

    [...this.files].forEach(file => {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'preview-item';
                
                div.innerHTML = `
                    <img src="${e.target.result}" class="preview-image">
                    <button type="button" class="remove-image">×</button>
                `;
                
                div.querySelector('.remove-image').onclick = function() {
                    div.remove();
                };
                
                preview.appendChild(div);
            };
            
            reader.readAsDataURL(file);
        }
    });
});
