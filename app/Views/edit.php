    <h2>Editar Usuario</h2>
    <form action="<?= base_url('admin/user/update/' . $user['id']) ?>" method="post">
        <label for="name">Nombre:</label>
        <input type="text" id="name" name="name" value="<?= $user['name'] ?>" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= $user['email'] ?>" required><br><br>

        <button type="submit">Actualizar</button>
    </form>