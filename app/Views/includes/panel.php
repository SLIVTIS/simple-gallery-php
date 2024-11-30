<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Lateral</title>
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
  <div class="container">
    <!-- Panel lateral -->
    <aside class="sidebar">
      <div class="user-info">
        <h2><?= esc($currentUser['name']) ?></h2>
        <a href="<?= base_url('logout/') ?>" class="logout-btn">Cerrar sesión</a>
      </div>
      <nav class="shortcuts">
        <a href="<?=base_url('/')?>" class="shortcut-link">Mis Fotos</a>
        <a href="<?=base_url('admin/user')?>" class="shortcut-link">Usuarios</a>
      </nav>
    </aside>

    <!-- Contenido principal -->
    <main class="main-content">
 
