<?php

include "connect.inc.php";
include "Usuario.php";
include "Eventos.php";
include "Cursos.php";
include "Usuario_Curso.php";

$evento = new Evento($conn);
$cursos = new Curso($conn);

$res = $evento->readAll();

if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];
} else {
    $matricula = "";
}

if(!empty($_POST['matricula'])){
    $matricula = $_POST['matricula'];
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesEventos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="js/scripts.js"></script>
    <title>Pagina Principal de Aluno</title>
</head>
<body>

    <div class="top-bar">
        <div class="menu-container">
            <button class="menu-btn">☰ </button>
            <div class="menu-content">
                <a href="ranking.php?matricula=<?php echo $matricula ?>">Ranking</a>
            </div>
        </div>
        <div class="user-container">
            <button class="user-btn"><i class="fas fa-user"></i></button>
            <div class="user-content">
                <a href="perfil.php?matricula=<?php echo $matricula ?>">Perfil</a>
                <a href="login.php">Logout</a>
            </div>
        </div>
    </div>

    <section class="container">
        <h2 class="table-title">Eventos</h2>  
            <table>
                <tr>
                    <th>Nome</th>
                    <th>Data de Inicio</th>
                    <th>Data Final</th>
                    <th>ID</th>
                    <th>&nbsp;</th>
                </tr>
    <?php 
    foreach ($res as $r) {
        echo ("
            <tr>
                <td>{$r['nome']}</td>
                <td>{$r['dataInic']}</td>
                <td>{$r['dataFim']}</td>
                <td>{$r['ID']}</td>
                <td><a href='listagemCursos.php?id={$r['ID']}&matricula=$matricula'>Cursos</a></td>
                </tr>");
    }
    ?>
            </table>
        </section>

</body>
</html>