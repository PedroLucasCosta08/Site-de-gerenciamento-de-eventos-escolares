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

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesEventos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="js/scripts.js"></script>
    <title>Cadastro de Eventos</title>
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
            <h1>Novo Evento</h1><br> 
            <?php if(isset($_GET['erro'])): ?>
                <div class="erro"><?php echo htmlspecialchars($_GET['erro']); ?></div>
            <?php endif; ?>
            <br>
            <form action="actionPaginaPrinc.php" method="post">
                <b><input type="hidden" name="action" value="cadastrarNovoEvento"></b>
                <b><input type="hidden" name="matricula" value="<?php echo $matricula ?>"></b>
                <b>Nome: </b><input type="text" name="nome" placeholder="Insira o nome do evento"><br>
                <b>Data de Inicio(No Formato AAAA-MM-DD com os traços): </b><input type="text" name="dataInic" placeholder="Insira a data de inicio do evento"><br>
                <b>Data de Termino(No Formato AAAA-MM-DD com os traços): </b><input type="text" name="dataFim" placeholder="Insira a data de termino do evento"><br>
                <b>ID: </b><input type="text" name="id" placeholder="Insira o ID do evento"><br>
                <button type="submit" >Cadastrar</button> 
            </form>
        </div>
    </section>

</body>
</html>