<?php

include "connect.inc.php";
include "Usuario.php";
include "Eventos.php";
include "Cursos.php";
include "Usuario_Curso.php";

$newUser = new Usuario($conn);

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
        <div class="caixacadastro">
            <h1>Criar conta </h1><br>
            <?php if(isset($_GET['erro'])): ?>
                <div class="erro"><?php echo htmlspecialchars($_GET['erro']); ?></div>
            <?php endif; ?>
            <form action="action.php" method="post">
                <input type="hidden" name="action" value="cadastrar">
                <b>Nome: </b><input type="text" name="nome" placeholder="Insira seu nome" value=""><br>
                <b>Email: </b><input type="text" name="email" placeholder="Insira seu email" value=""><br>
                <b>Matricula: </b><input type="text" name="matricula" placeholder="Insira sua matricula" value=""><br>
                <b>Curso: </b><input type="text" name="curso" placeholder="Insira seu curso" value=""><br>
                <b>Senha: </b><input type="password" name="senha" placeholder="Insira sua senha" value=""><br>
                <b>Tipo de usuario:</b> 
                <input type="radio" name="tipoU" <?php if (isset($tipoU) && $tipoU=="gerente") echo "checked";?> value="gerente">Gerente
                <input type="radio" name="tipoU" <?php if (isset($tipoU) && $tipoU=="aluno") echo "checked";?> value="aluno">Aluno
                <br><br>
                <button type="submit" >Cadastrar</button> 
            </form>
            <P class="p">Já possui uma conta ?</P>            
            <a href="login.php" class="ref">Login</a>
        </div>
    </section>

</body>
</html>