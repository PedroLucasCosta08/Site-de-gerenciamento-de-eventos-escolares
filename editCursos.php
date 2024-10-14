<?php

include "connect.inc.php";
include "Usuario.php";
include "Eventos.php";
include "Cursos.php";
include "Usuario_Curso.php";

if (isset($_GET['idCurso'])) {
    $idCurso = $_GET['idCurso'];
} else {
    $idCurso = "";
}

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

$updateCurso = new Curso($conn);

$res = $updateCurso->getAllDoCurso($idCurso);

$titulo = $res[0]['Titulo'];
$descricao = $res[0]['descricao'];
$data = $res[0]['data'];
$horarioInic = $res[0]['horarioInic'];
$horarioFim = $res[0]['horarioFim'];
$IDeventos = $res[0]['IDeventos'];

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesEventos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="js/scripts.js"></script>
    <title>Editar Curso</title>
</head>
<body>

    <div class="top-bar">
        <div class="menu-container">
            <button class="menu-btn">☰ </button>
            <div class="menu-content">
            <a href="listagemCursosGerentes.php?matricula=<?php echo htmlspecialchars($matricula); ?>&id=<?php echo htmlspecialchars($IDeventos); ?>">Cursos</a>
            </div>
        </div>
    </div>

    <section class="container-atualizarPerfil">
        <div class="caixaAtualizarPerfil">
            <h1>Editar Curso</h1><br> 
            <?php if(isset($_GET['erro'])): ?>
                <div class="erro"><?php echo htmlspecialchars($_GET['erro']); ?></div>
            <?php endif; ?>
            <br>
            <form action="actionPaginaPrinc.php" method="post">
                <b><input type="hidden" name="action" value="atualizarCurso"></b>
                <b><input type="hidden" name="matricula" value="<?php echo $matricula ?>"></b>
                <b><input type="hidden" name="id" value="<?php echo $idCurso ?>"></b>
                <b><input type="hidden" name="idEvento" value="<?php echo $IDeventos ?>"></b>
                <b>Titulo: </b><input type="text" name="titulo" value="<?php echo $titulo ?>"><br>
                <b>Descrição: </b><input type="text" name="descricao" value="<?php echo $descricao ?>"><br>
                <b>Data(AAAA-MM-DD): </b><input type="text" name="data" value="<?php echo $data ?>"><br>
                <b>Horario de Inicio(HH:MM:SS): </b><input type="text" name="horarioInic" value="<?php echo $horarioInic ?>"><br>
                <b>Horario de Termino(HH:MM:SS): </b><input type="text" name="horarioFim" value="<?php echo $horarioFim ?>"><br>
                <b>ID do evento: </b><h3><?php echo $IDeventos ?></h3>
                <b>ID do curso: </b><h3><?php echo $idCurso ?></h3>
                <button type="submit" >Atualizar</button> 
            </form>
        </div>
    </section>

</body>
</html>