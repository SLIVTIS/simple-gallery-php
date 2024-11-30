<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Lateral</title>
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
  <div class="container-user">
    <!-- Panel lateral -->
    <header class="header">
      <div class="user-menu">
        <h2><?= esc($currentUser['name'])?></h2>
        <a href="<?= base_url('logout/') ?>" class="logout-btn">Cerrar sesión</a>
      </div>
    </header>

    <!-- Contenido principal -->
    <main class="main-content">
 