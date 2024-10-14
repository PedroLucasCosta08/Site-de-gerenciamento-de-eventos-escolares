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

if(isset($_GET['id'])){
    $idEvento = $_GET['id'];
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
    <title>Cadastro de Cursos</title>
</head>
<body>

    <div class="top-bar">
        <div class="menu-container">
            <button class="menu-btn">☰ </button>
            <div class="menu-content">
                <a href="relatorios.php?matricula=<?php echo htmlspecialchars($matricula); ?>">Relatorios</a>
            </div>
        </div>
    </div>

    <section class="container-atualizarPerfil">
        <div class="caixaAtualizarPerfil">
            <h1>Novo Curso</h1><br> 
            <?php if(isset($_GET['erro'])): ?>
                <div class="erro"><?php echo htmlspecialchars($_GET['erro']); ?></div>
            <?php endif; ?>
            <br>
            <form action="actionPaginaPrinc.php" method="post">
                <b><input type="hidden" name="action" value="cadastrarNovoCurso"></b>
                <b><input type="hidden" name="matricula" value="<?php echo $matricula ?>"></b>
                <b><input type="hidden" name="idEvento" value="<?php echo $idEvento ?>"></b>
                <b>Titulo: </b><input type="text" name="titulo" placeholder="Insira o titulo do curso"><br>
                <b>Descrição: </b><input type="text" name="descricao" placeholder="Insira a descricao do curso"><br>
                <b>Data(AAAA-MM-DD): </b><input type="text" name="data" placeholder="Insira a data do curso"><br>
                <b>Horario de Inicio(HH:MM:SS): </b><input type="text" name="horarioInic" placeholder="Insira o horario de inicio"><br>
                <b>Horario de Termino(HH:MM:SS): </b><input type="text" name="horarioFim" placeholder="Insira o horario de termino"><br>
                <b>ID: </b><input type="text" name="idCurso" placeholder="Insira o ID do curso"><br>
                <button type="submit" >Cadastrar</button> 
            </form>
        </div>
    </section>

</body>
</html>