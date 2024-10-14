<?php

include "connect.inc.php";
include "Usuario.php";
include "Eventos.php";
include "Cursos.php";
include "Usuario_Curso.php";


$action = $_POST['action'];
$nome = $email = $matricula = $curso = $senha = $tipo = "";
$nomeErr = $emailErr = $matriculaErr = $cursoErr = $senhaErr = $tipoErr = "";
$erro = "";

if(empty($_POST['nome'])){
    $nomeErr = "*Não foi enviado nenhum nome";
}else{
    $nome = ($_POST['nome']);
    if (!preg_match("/^[a-zA-Z-' ]*$/",$nome)){
        $nomeErr = "Insira seu nome somente com letras";
    }
}
if(empty($_POST['email'])){
    $emailErr = "*Não foi enviado nenhum email";
}else{
    $email = ($_POST['email']);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Email com formato incorreto";
    }
}
if(empty($_POST['matricula'])){
    $matriculaErr = "*Não foi enviado nenhuma matricula";
}else{
    $matricula = ($_POST['matricula']);
    if (!preg_match("/^[0-9]+$/", $matricula)) {
        $matriculaErr = "Matricula no formato incorreto";
    }
}
if(empty($_POST['senha'])){
    $senhaErr = "*Não foi enviado nenhuma senha";
}
if(empty($_POST['curso'])){
    $cursoErr = "*Não foi enviado nenhum Curso";
}
if(empty($_POST['tipoU'])){
    $tipoErr = "*Não foi enviado nenhum tipo";
}else{
    $tipo = $_POST['tipoU'];
}

if($action == "check"){
    if(!empty($matriculaErr) || !empty($senhaErr)){
        $erro = "Matricula ou Senha erradas!";
        header("Location: login.php?erro=" . urlencode($erro));
        exit();
    }
}else if($action == "cadastrar"){
    if(!empty($nomeErr) || !empty($emailErr) || !empty($matriculaErr) || !empty($cursoErr) || !empty($senhaErr) || !empty($tipoErr)){
        $erro = "Insira os dados corretamente!";
        header("Location: cadastro.php?erro=" . urlencode($erro));
        exit();
    }
}

$Usuario = new Usuario($conn);

if($action == 'cadastrar'){
    if($Usuario->checarMatriculaJaexistente($matricula) == true){
        $erro = "Matricula Já existente";
        header('Location: cadastro.php?erro=' . urlencode($erro));
        exit();
    }else{
        $Usuario->createUser($_POST);
        if($_POST['tipoU'] == "gerente"){
            header('Location: eventosGerente.php?matricula=' . $_POST['matricula']);
            exit();
        }else if($_POST['tipoU'] == "aluno"){
            header('Location: eventosAlunos.php?matricula=' . $_POST['matricula']);
            exit();
        }
    }
}else if($action == 'check'){
    if($Usuario->checkLoginReadOne($_POST['matricula'], $_POST['senha']) == true){
        #usuario encontrado
        $verificacaoUsuario = $Usuario->getTipoU($_POST['matricula']);
        if($verificacaoUsuario == "gerente"){
            header('Location: eventosGerente.php?matricula=' . $_POST['matricula']);
            exit();
        }else if($verificacaoUsuario == "aluno"){
            header('Location: eventosAlunos.php?matricula=' . $_POST['matricula']);
            exit();
        }
    }else if($Usuario->checkLoginReadOne($_POST['matricula'], $_POST['senha']) == false){
        #usuario não encontrado
        $erro = "Matricula ou Senha erradas!";
        header("Location: login.php?erro=" . urlencode($erro));
        exit();
    }
}

?>