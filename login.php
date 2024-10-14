<?php

include "connect.inc.php";
include "Usuario.php";
include "Eventos.php";
include "Cursos.php";
include "Usuario_Curso.php";

$User = new Usuario($conn);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <section class="container">
        <div class="caixalogin">
            <h1>Login </h1><br> 
            <?php if(isset($_GET['erro'])): ?>
                <div class="erro"><?php echo htmlspecialchars($_GET['erro']); ?></div>
            <?php endif; ?>
            <form action="action.php" method="post">
                <input type="hidden" name="action" value="check">
                <b>Matricula: </b><input type="text" name="matricula" placeholder="Insira sua matricula" value=""><br>
                <b>Senha: </b><input type="password" name="senha" placeholder="Insira sua senha" value=""><br>
                <button type="submit">Logar</button> 
            </form>
            <P class="p">Não possui uma conta ?</P>            
            <a href="cadastro.php" class="ref">Cadastrar</a>
        </div>
    </section>

</body>
</html>