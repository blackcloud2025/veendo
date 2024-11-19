document.addEventListener('DOMContentLoaded', () => {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('images');
    const imagePreview = document.getElementById('imagePreview');

    // Prevent default drag behaviors
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
        document.body.addEventListener(eventName, preventDefaults, false);
    });

    // Highlight drop zone when item is dragged over
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    // Handle dropped files
    dropZone.addEventListener('drop', handleDrop, false);

    // Handle selected files from file input
    fileInput.addEventListener('change', handleFiles, false);

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    function highlight() {
        dropZone.classList.add('highlight');
    }

    function unhighlight() {
        dropZone.classList.remove('highlight');
    }

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        
        // Set files to the input element
        fileInput.files = files;
        
        handleFiles(files);
    }

    function handleFiles(files) {
        // If called from file input event, get files from event
        files = files.target ? files.target.files : files;

        // Check file count
        if (files.length > 10) {
            alert('Solo puedes subir un máximo de 10 imágenes');
            return;
        }

        // Clear previous previews
        imagePreview.innerHTML = '';

        // Create previews for each file
        Array.from(files).forEach(file => {
            // Validate file type and size
            if (!['image/jpeg', 'image/png', 'image/gif'].includes(file.type)) {
                alert('Solo se permiten archivos PNG, JPG y GIF');
                return;
            }

            if (file.size > 10 * 1024 * 1024) { // 10MB
                alert('El archivo es demasiado grande. Máximo 10MB');
                return;
            }

            const reader = new FileReader();
            reader.onload = (e) => {
                const div = document.createElement('div');
                div.className = 'preview-item';

                div.innerHTML = `
                    <img src="${e.target.result}" class="preview-image">
                    <button type="button" class="remove-image">×</button>
                `;

                div.querySelector('.remove-image').onclick = function() {
                    div.remove();
                };

                imagePreview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
});
