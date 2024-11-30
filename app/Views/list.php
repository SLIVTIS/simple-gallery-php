<div class="user-list">
    <h2 class="title">Usuarios</h2>
    <a href="<?= base_url('admin/user/create') ?>" class="button">Crear Nuevo Usuario</a><br><br>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Email</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= $user['id'] ?></td>
            <td><?= $user['name'] ?></td>
            <td><?= $user['email'] ?></td>
            <td>
                <a href="<?= base_url('admin/gallery/' . $user['id']) ?>" class="button">Ver galería</a> |
                <a href="<?= base_url('admin/user/edit/' . $user['id']) ?>" class="button">Editar</a> |
                <a href="<?= base_url('admin/user/delete/' . $user['id']) ?>" class="button" onclick="return confirm('¿Estás seguro de eliminar este usuario? Tambien se borraran todas las imagenes que pertenecen al usuario.');">Eliminar</a>|
                <a href="<?= base_url('admin/user/changepass/' . $user['id']) ?>" class="button">Cambiar contraseña</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>