<div class="container-gallery">
    <h2><?= isset($nameGallery) ? $nameGallery : "" ?></h2>
    <div class="upload-form">
        <form id="uploadForm" enctype="multipart/form-data">
            <label for="imageInput">Subir imagen</label>
            <input type="file" id="imageInput" name="image" accept="image/*">
        </form>
        <button id="deleteSelectedBtn" style="display: none;" onclick="deleteSelectedImages()">Eliminar seleccionados</button>
    </div>
    <div class="gallery" id="gallery">
        <?php foreach ($images as $image): ?>
            <div class="card">
            <div class="image-card" draggable="true" data-id="<?= $image['id'] ?>">
                <input type="checkbox" class="select-checkbox" data-id="<?= $image['id'] ?>" style="display: none;">
                <img src="<?= base_url('image/' . $image['path']) ?>" alt="Imagen">
            </div>
                <p hidden><?=$image['name'] ?></p>     
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    const gallery = document.getElementById('gallery');
    const uploadForm = document.getElementById('uploadForm');
    const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');

    // Eliminar imagen
    async function deleteImage(id) {
        if (!confirm('¿Estás seguro de que deseas eliminar esta imagen?')) return;
        const response = await fetch(`<?= site_url('image/') ?>${id}`, { method: 'DELETE' });
        if (response.ok) {
            location.reload(); // Recargar página tras eliminar imagen
        } else {
            alert('Error al eliminar la imagen.');
        }
    }

    //Sube la imagen desde el boton
    imageInput.addEventListener('change', async (event) => {
            const file = event.target.files[0]; // Selecciona el primer archivo
            if (!file) {
                alert('No se seleccionó ninguna imagen.');
                return;
            }

            const formData = new FormData(uploadForm);
            formData.append('image', file); // Asegúrate de que la clave sea la que espera tu API

            try {
                const response = await fetch('<?= base_url("image") ?>', {
                    method: 'POST',
                    body: formData,
                });

                if (response.ok) {
                    location.reload(); // Recargar página tras subir imagen
                    //alert('Imagen subida exitosamente');
                } else {
                    alert('Error al subir la imagen');
                }
            } catch (error) {
                console.error('Error en la subida:', error);
                alert('Hubo un problema al subir la imagen');
            }
        });


    //Función que permite arrastrar las imagenes directamente y las sube
    gallery.addEventListener('dragover', (e) => {
            e.preventDefault(); // Evita la acción predeterminada del navegador
            gallery.classList.add('drag-over');
        });

        gallery.addEventListener('dragleave', () => {
            gallery.classList.remove('drag-over');
        });

        gallery.addEventListener('drop', async (e) => {
            e.preventDefault();
            gallery.classList.remove('drag-over');

            const files = e.dataTransfer.files;
            if (files.length === 0) {
                alert('No se arrastró ningún archivo.');
                return;
            }

            const file = files[0]; // Solo procesaremos el primer archivo
            const formData = new FormData();
            formData.append('image', file); // La clave 'image' debe coincidir con la esperada en tu API

            try {
                const response = await fetch('<?= base_url('image') ?>', {
                    method: 'POST',
                    body: formData,
                });

                if (response.ok) {
                    //const result = await response.json();
                    location.reload(); // Recargar página tras subir imagen
                    //alert('Imagen subida exitosamente');
                } else {
                    alert('Error al subir la imagen');
                }
            } catch (error) {
                console.error('Error en la subida:', error);
                alert('Hubo un problema al subir la imagen');
            }
        });

     // Mostrar todas las casillas si hay una seleccionada
     gallery.addEventListener('change', () => {
        const selectedCheckboxes = document.querySelectorAll('.select-checkbox:checked');

        if (selectedCheckboxes.length > 0) {
            showAllCheckboxes(); // Mostrar todas las casillas
            deleteSelectedBtn.style.display = 'block'; // Mostrar botón eliminar
        } else {
            hideAllCheckboxes(); // Ocultar todas las casillas si no hay seleccionadas
            deleteSelectedBtn.style.display = 'none'; // Ocultar botón eliminar
        }
    });

    // Mostrar casilla al pasar el mouse sobre la tarjeta
    gallery.addEventListener('mouseover', (e) => {
        if (e.target.closest('.image-card')) {
            const checkbox = e.target.closest('.image-card').querySelector('.select-checkbox');
            checkbox.style.display = 'block';
        }
    });

    gallery.addEventListener('mouseout', (e) => {
        if (e.target.closest('.image-card')) {
            const checkbox = e.target.closest('.image-card').querySelector('.select-checkbox');
            if (!checkbox.checked) {
                checkbox.style.display = 'none';
            }
        }
    });

    // Función para mostrar todas las casillas
    function showAllCheckboxes() {
        checkboxes.forEach(checkbox => {
            checkbox.style.display = 'block';
        });
    }

    // Función para ocultar todas las casillas
    function hideAllCheckboxes() {
        checkboxes.forEach(checkbox => {
            if (!checkbox.checked) {
                checkbox.style.display = 'none';
            }
        });
    }

    // Mostrar botón "Eliminar seleccionados" si hay casillas marcadas
    gallery.addEventListener('change', () => {
        const selectedCheckboxes = document.querySelectorAll('.select-checkbox:checked');
        deleteSelectedBtn.style.display = selectedCheckboxes.length > 0 ? 'block' : 'none';
    });

    // Eliminar imágenes seleccionadas
    async function deleteSelectedImages() {
        const selectedCheckboxes = document.querySelectorAll('.select-checkbox:checked');
        if (selectedCheckboxes.length === 0) return;

        if (!confirm('¿Estás seguro de que deseas eliminar las imágenes seleccionadas?')) return;

        const idsToDelete = Array.from(selectedCheckboxes).map(cb => cb.getAttribute('data-id'));
        console.log(JSON.stringify({ ids: idsToDelete }));
        try {
            const response = await fetch('<?= base_url("image/delete-selected") ?>', {
                method: 'DELETE',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ ids: idsToDelete }),
            });

            if (response.ok) {
                location.reload();
            } else {
                console.log(response);
                alert('Error al eliminar las imágenes.');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Hubo un problema al eliminar las imágenes.');
        }
    }

</script>


