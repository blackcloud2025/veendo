document.addEventListener('DOMContentLoaded', () => {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('images');
    const imagePreview = document.getElementById('imagePreview');
    let allFiles = []; // Arreglo para almacenar todos los archivos seleccionados

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
    fileInput.addEventListener('change', handleFileSelect, false);

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
        const files = Array.from(dt.files);

        // Add dropped files to the list of all files
        allFiles = allFiles.concat(files);

        // Update file input files for form submission
        updateFileInput();

        handleFiles(allFiles);
    }

    function handleFileSelect(e) {
        const files = Array.from(e.target.files);

        // Add selected files to the list of all files
        allFiles = allFiles.concat(files);

        // Update file input files for form submission
        updateFileInput();

        handleFiles(allFiles);
    }

    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        allFiles.forEach(file => dataTransfer.items.add(file));
        fileInput.files = dataTransfer.files;
    }

    function handleFiles(files) {
        // Check file count
        if (files.length > 10) {
            alert('Solo puedes subir un máximo de 10 imágenes');
            allFiles = allFiles.slice(0, 10); // Limitar a 10 archivos
            updateFileInput();
        }

        // Clear previous previews
        imagePreview.innerHTML = '';

        // Create previews for each file
        allFiles.forEach(file => {
            // Validate file type and size
            if (!['image/jpeg', 'image/png', 'image/gif'].includes(file.type)) {
                alert('Solo se permiten archivos PNG, JPG y GIF');
                allFiles = allFiles.filter(f => f !== file); // Eliminar archivo inválido
                updateFileInput();
                return;
            }

            if (file.size > 10 * 1024 * 1024) { // 10MB
                alert('El archivo es demasiado grande. Máximo 10MB');
                allFiles = allFiles.filter(f => f !== file); // Eliminar archivo demasiado grande
                updateFileInput();
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
                    allFiles = allFiles.filter(f => f !== file); // Eliminar archivo de la lista
                    div.remove();
                    updateFileInput();
                };

                imagePreview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
});
