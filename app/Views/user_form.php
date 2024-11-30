<form class="form-add-user" action="<?= $url ?>" method="post">
    <h2><?=$title?></h2>    
    <label for="name">Nombre:</label>
    <input type="text" id="name" name="name" value="<?= isset($user) ? $user['name'] : "" ?>" required>
    <?php if (!isset($user)) { ?>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>
        <label for="pass">Contraseña:</label>
        <input type="password" id="pass" name="pass" required>
        <?php } ?>
    <label for="admin">Administrador:</label>
    <input type="checkbox" id="admin" name="admin" <?= isset($user) && $user['admin'] ? 'checked' : '' ?>>
    <button type="submit">Guardar</button>
</form>

<script>
function validatePasswords(event) {
    const pass = document.getElementById('pass').value;
    const confirmPass = document.getElementById('confirm-pass').value;

    if (pass !== confirmPass) {
        alert('Las contraseñas no coinciden. Por favor, verifícalas.');
        event.preventDefault(); // Evita que el formulario se envíe
        return false;
    }
    return true; // Permite el envío del formulario si las contraseñas coinciden
}
</script>