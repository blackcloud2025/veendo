document.addEventListener('DOMContentLoaded', () => {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('images');
    const imagePreview = document.getElementById('imagePreview');
    let allFiles = []; // Arreglo para almacenar todos los archivos seleccionados

    // Función de compresión de imágenes
    function compressImage(file, { maxWidth = 740, maxHeight = 650, quality = 0.8 }) {
        return new Promise((resolve, reject) => {
            if (!file || !file.type.startsWith('image/')) {
                reject(new Error('Archivo inválido'));
                return;
            }

            const img = new Image();
            img.src = URL.createObjectURL(file);
            
            img.onload = () => {
                URL.revokeObjectURL(img.src);
                
                let width = img.width;
                let height = img.height;
                
                if (width > maxWidth) {
                    height = Math.round((height * maxWidth) / width);
                    width = maxWidth;
                }
                
                if (height > maxHeight) {
                    width = Math.round((width * maxHeight) / height);
                    height = maxHeight;
                }
                
                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;
                
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);
                
                canvas.toBlob(
                    (blob) => {
                        // Crear un nuevo File objeto a partir del Blob
                        const compressedFile = new File([blob], file.name, {
                            type: 'image/jpeg',
                            lastModified: Date.now()
                        });
                        resolve(compressedFile);
                    },
                    'image/jpeg',
                    quality
                );
            };
            
            img.onerror = reject;
        });
    }

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

    function highlight(e) {
        preventDefaults(e);
        dropZone.classList.add('highlight');
    }

    function unhighlight(e) {
        preventDefaults(e);
        dropZone.classList.remove('highlight');
    }

    async function handleDrop(e) {
        preventDefaults(e);
        const dt = e.dataTransfer;
        const droppedFiles = Array.from(dt.files).filter(file => 
            file.type.startsWith('image/') && 
            ['image/jpeg', 'image/png', 'image/gif'].includes(file.type)
        );
        
        if (droppedFiles.length === 0) {
            alert('Por favor, arrastra solo archivos de imagen (JPG, PNG, GIF)');
            return;
        }

        try {
            // Comprimir las imágenes antes de agregarlas
            const compressedFiles = await Promise.all(
                droppedFiles.map(file => compressImage(file, {
                    maxWidth: 800,
                    maxHeight: 800,
                    quality: 0.8
                }))
            );

            // Añadir a la lista existente
            allFiles = [...allFiles, ...compressedFiles];

            // Validar límite de 10 imágenes
            if (allFiles.length > 10) {
                allFiles = allFiles.slice(0, 10);
                alert('Solo se permiten hasta 10 imágenes. Se han seleccionado las primeras 10.');
            }

            // Actualizar input file y mostrar previsualizaciones
            await updateFileInput();
            handleFiles(allFiles);
        } catch (error) {
            console.error('Error al procesar las imágenes:', error);
            alert('Hubo un error al procesar algunas imágenes');
        }
    }

    async function handleFileSelect(e) {
        const selectedFiles = Array.from(e.target.files).filter(file => 
            file.type.startsWith('image/') && 
            ['image/jpeg', 'image/png', 'image/gif'].includes(file.type)
        );

        if (selectedFiles.length === 0) {
            alert('Por favor, selecciona solo archivos de imagen (JPG, PNG, GIF)');
            return;
        }

        try {
            const compressedFiles = await Promise.all(
                selectedFiles.map(file => compressImage(file, {
                    maxWidth: 800,
                    maxHeight: 800,
                    quality: 0.8
                }))
            );

            allFiles = [...allFiles, ...compressedFiles];

            if (allFiles.length > 10) {
                allFiles = allFiles.slice(0, 10);
                alert('Solo se permiten hasta 10 imágenes. Se han seleccionado las primeras 10.');
            }

            await updateFileInput();
            handleFiles(allFiles);
        } catch (error) {
            console.error('Error al procesar las imágenes:', error);
            alert('Hubo un error al procesar algunas imágenes');
        }
    }

    async function updateFileInput() {
        const dataTransfer = new DataTransfer();
        
        allFiles.forEach(file => {
            if (file instanceof File) {
                dataTransfer.items.add(file);
            }
        });

        if (fileInput) {
            fileInput.files = dataTransfer.files;
        }
    }

    function handleFiles(files) {
        // Clear previous previews
        imagePreview.innerHTML = '';

        // Create previews for each file
        files.forEach((file, index) => {
            if (!file || !file.type.startsWith('image/')) return;

            const reader = new FileReader();
            reader.onload = (e) => {
                const div = document.createElement('div');
                div.className = 'preview-item';

                div.innerHTML = `
                    <img src="${e.target.result}" class="preview-image">
                    <button type="button" class="remove-image">×</button>
                    <div class="file-info">
                        <small>${file.name} (${(file.size / 1024).toFixed(2)} KB)</small>
                    </div>
                `;

                div.querySelector('.remove-image').onclick = function() {
                    allFiles = allFiles.filter(f => f !== file);
                    div.remove();
                    updateFileInput();
                };

                imagePreview.appendChild(div);
            };

            reader.readAsDataURL(file);
        });
    }
});