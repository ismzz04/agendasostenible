<?php
session_start();
if ($_SESSION['user_role'] !== 'admin') {
    header('Location: agendasostenible.php');
    exit;
}
?>


<!DOCTYPE html>
<html lang="ca">
<head>
    <meta charset="UTF-8">
    <title>Panell d'Administració</title>
    <link rel="stylesheet" href="estils.css">
</head>
<body>
<div class="navbar">
    <a href="admin_panel.php">Panell d'Administració</a>
</div>

<div class="admin-panel">
<main>
    <h1>Benvingut al Panell d'Administració</h1>
    <section>
        <h2>Gestió d'Esdeveniments</h2>
        <a href="admin_event_create.php">Crear Esdeveniment</a>
        <a href="admin_event_list.php">Veure,Editar i Eliminar Esdeveniments</a>
    </section>

    <section>
        <h2>Gestió d'Usuaris</h2>
        <a href="admin_usuarios.php">Crear Usuari</a>
        <a href="admin_user_list.php">Veure,Editar i Eliminar Usuaris</a>
    </section>

    <section>
        <h2>Gestió de Consells de Sostenibilitat</h2>
        <a href="admin_consell_create.php">Crear Consell</a>
        <a href="admin_consell_list.php">Veure,Editar i Eliminar Consells</a>

    </section>

    <section>
        <h2>Gestió d'Anuncis Classificats</h2>
        <a href="admin_anunci_create.php">Crear Anunci</a>
        <a href="admin_anunci_list.php">Veure,Editar i Eliminar Anuncis</a>

    </section>

    <section>
        <h2>Gestió de Categories</h2>
        <a href="admin_categories.php">Crear,veure,editar i eliminar Categoria</a>
    </section>

    <section>
    <h2>Gestió de Valoracions</h2>
    <a href="admin_valoracions.php">Veure, Modificar i Eliminar Valoracions</a>
</section>

    <section>
        <h2>Gestió de Comentaris</h2>
        <a href="admin_comment_list.php">Veure i Editar Comentaris</a>
    </section>

</main>
</div>

</body>
</html>