<?php

include "connect.inc.php";
include "Usuario.php";
include "Eventos.php";
include "Cursos.php";
include "Usuario_Curso.php";

if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];
} else {
    $matricula = "";
}

if (isset($_GET['idEvento'])) {
    $idEvento = $_GET['idEvento'];
} else {
    $idEvento = "";
}

$updateEvento = new Evento($conn);

$res = $updateEvento->getAllDoEvento($idEvento);

$nome = $res[0]['nome'];
$dataInic = $res[0]['dataInic'];
$dataFim = $res[0]['dataFim'];
$ID = $res[0]['ID'];

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesEventos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="js/scripts.js"></script>
    <title>Editar Eventos</title>
</head>
<body>

    <div class="top-bar">
        <div class="menu-container">
            <button class="menu-btn">☰ </button>
            <div class="menu-content">
                <a href="eventosGerente.php?matricula=<?php echo htmlspecialchars($matricula); ?>">Eventos</a>
            </div>
        </div>
    </div>

    <section class="container-atualizarPerfil">
        <div class="caixaAtualizarPerfil">
            <h1>Editar Evento</h1><br> 
            <?php if(isset($_GET['erro'])): ?>
                <div class="erro"><?php echo htmlspecialchars($_GET['erro']); ?></div>
            <?php endif; ?>
            <br>
            <form action="actionPaginaPrinc.php" method="post">
                <b><input type="hidden" name="action" value="atualizarEvento"></b>
                <b><input type="hidden" name="matricula" value="<?php echo $matricula ?>"></b>
                <b><input type="hidden" name="id" value="<?php echo $ID ?>"></b>
                <b>Nome: </b><input type="text" name="nome" value="<?php echo $nome ?>"><br>
                <b>Data de Inicio(AAAA-MM-DD): </b><input type="text" name="dataInic" value="<?php echo $dataInic ?>"><br>
                <b>Data de Fim(AAAA-MM-DD): </b><input type="text" name="dataFim" value="<?php echo $dataFim ?>"><br>
                <b>ID: </b><h3><?php echo $ID ?></h3>
                <button type="submit" >Atualizar</button> 
            </form>
        </div>
    </section>

</body>
</html>