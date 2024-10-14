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

$checkTipoUsuario = new Usuario($conn);
$tipo = $checkTipoUsuario->checkTipo($matricula);
if($tipo == 'aluno'){
    $tipo = 'Alunos';
}else if($tipo == 'gerente'){
    $tipo = 'Gerente';
}

$usuarioAtual = new Usuario($conn);

$res = $usuarioAtual->getAll($matricula);

$nome = $res[0]['Nome'];
$email = $res[0]['Email'];
$curso = $res[0]['Curso'];
$senha = $res[0]['Senha'];

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesEventos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="js/scripts.js"></script>
    <title>Perfil</title>
</head>
<body>

    <div class="top-bar">
        <div class="menu-container">
            <button class="menu-btn">☰ </button>
            <div class="menu-content">
                <a href="eventos<?php echo htmlspecialchars($tipo); ?>.php?matricula=<?php echo htmlspecialchars($matricula); ?>">Eventos</a>
            </div>
        </div>
    </div>

    <section class="container-atualizarPerfil">
        <div class="caixaAtualizarPerfil">
            <h1>Perfil</h1><br> 
            <?php if(isset($_GET['erro'])): ?>
                <div class="erro"><?php echo htmlspecialchars($_GET['erro']); ?></div>
            <?php endif; ?>
            <br>
            <form action="actionPaginaPrinc.php" method="post">
                <b><input type="hidden" name="action" value="atualizar"></b>
                <b><input type="hidden" name="matPraAtualizar" value="<?php echo $matricula ?>"></b>
                <b><input type="hidden" name="tipoU" value="<?php echo $tipo ?>"></b>
                <b>Nome: </b><input type="text" name="nome" value="<?php echo $nome ?>"><br>
                <b>Email: </b><input type="text" name="email" value="<?php echo $email ?>"><br>
                <b>Curso: </b><input type="text" name="curso" value="<?php echo $curso ?>"><br>
                <b>Senha: </b><input type="password" name="senha" value="<?php echo $senha ?>"><br>
                <b>Tipo: </b><h3><?php echo $tipo ?></h3>
                <b>Matricula: </b><h3><?php echo $matricula ?></h3>
                <button type="submit" >Atualizar</button> 
            </form>
        </div>
    </section>

</body>
</html>