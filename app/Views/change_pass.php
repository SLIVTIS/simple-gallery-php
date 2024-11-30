<form class="form-add-user" id="form-add-user">
    <h2>Cambiar contraseña</h2>
    <label for="pass">Contraseña:</label>
    <input type="password" id="pass" name="pass" required>
    
    <label for="confirm-pass">Confirmar Contraseña:</label>
    <input type="password" id="confirm-pass" name="confirm-pass" required>
    
    <button type="submit">Guardar</button>
</form>

<script>  
document.getElementById('form-add-user').addEventListener('submit', async function(event) {
    event.preventDefault(); // Evita el envío tradicional del formulario

    const form = event.target;
    const pass = form.pass.value;
    const confirmPass = form['confirm-pass'].value;

    // Validar que las contraseñas coincidan
    if (pass !== confirmPass) {
        alert('Las contraseñas no coinciden. Por favor, verifícalas.');
        return;
    }

    // Crear el objeto JSON
    const data = {
        pass: pass
    };

    // Realizar la solicitud POST
    const url = "<?= $url ?>"; // Usa la URL proporcionada en PHP
    try {
        const response = await fetch(url, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data), // Convertir los datos a JSON
        });

        if (response.ok) {
            const result = await response.json();
            alert('Contraseña guardad correctamente.');
            console.log(result); // Mostrar el resultado de la API
            // Limpiar los campos de contraseña
            form.pass.value = '';
            form['confirm-pass'].value = '';
        } else {
            alert('Error al guardar el usuario. Por favor, inténtalo de nuevo.');
            console.error(await response.text());
        }
    } catch (error) {
        alert('Ocurrió un error al enviar los datos.');
        console.error(error);
    }
});
</script>