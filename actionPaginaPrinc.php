<?php

include "connect.inc.php";
include "Usuario.php";
include "Eventos.php";
include "Cursos.php";
include "Usuario_Curso.php";

if (isset($_GET['action'])) {
    $action = $_GET['action'];
} else {
    $action = "";
}

if(!empty($_POST['action'])){
    $action = $_POST['action'];
}

if($action == 'inscrever'){
    if (isset($_GET['matricula'])) {
        $matricula = $_GET['matricula'];
    } else {
        $matricula = "";
    }
    if (isset($_GET['idEventos'])) {
        $idEventos = $_GET['idEventos'];
    } else {
        $idEventos = "";
    }
    if (isset($_GET['ID'])) {
        $idCurso = $_GET['ID'];
    } else {
        $idCurso = "";
    }

    $InscreverCurso = new UsuarioCurso($conn);
    if($InscreverCurso->checarCursoJaInscrito($matricula, $idCurso) == true){
        $erro = '*Já inscrito no Curso';
        header('Location: listagemCursos.php?erro=' . urlencode($erro) . '&id=' . urlencode($idEventos) . '&matricula=' . urlencode($matricula));
        exit();
    }else{
        $cursos = $InscreverCurso->readAllCursosInscritos($matricula);
        foreach($cursos as $curso){
            if($InscreverCurso->checarHorarios($curso, $idCurso) == true){
            $erro = "*Conflito de Horarios entre os Cursos";
            header('Location: listagemCursos.php?erro=' . urlencode($erro) . '&id=' . urlencode($idEventos) . '&matricula=' . urlencode($matricula));
            exit();
            }
        }
        $InscreverCurso->inscreverAlunoCurso($matricula, $idCurso,$idEventos);
        header('Location: eventosAlunos.php?matricula='. urlencode($matricula));
        exit();
    }
}

if($action == 'atualizar'){
    $nome = $email = $matricula = $curso = $senha = $tipo = "";
    $nomeErr = $emailErr = $matriculaErr = $cursoErr = $senhaErr = $tipoErr = "";
    $Usuario = new Usuario($conn);
    $matricula = $_POST['matPraAtualizar'];
    $tipoU = $_POST['tipoU'];

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
    if(empty($_POST['senha'])){
        $senhaErr = "*Não foi enviado nenhuma senha";
    }
    if(empty($_POST['curso'])){
        $cursoErr = "*Não foi enviado nenhum Curso";
    }else{
        $curso = ($_POST['curso']);
        if (!preg_match("/^[a-zA-Z-' ]*$/",$curso)) {
            $cursoErr = "Curso no formato incorreto";
        }
    }

    if(!empty($nomeErr) || !empty($emailErr) || !empty($cursoErr) || !empty($senhaErr)){
        $erro = "Insira os dados corretamente!";
        header("Location:perfil.php?erro=" . urlencode($erro) . "&matricula=" . urlencode($matricula));
        exit();
    }else{
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $curso = $_POST['curso'];
        $senha = $_POST['senha'];
        if($Usuario->updateUsuario($nome, $email, $curso, $senha, $_POST['matPraAtualizar']) == true){
            header('Location: eventos' . urlencode($tipoU) . '.php?matricula=' . urlencode($matricula));
            exit();
        }
    }
}

if($action == 'cadastrarNovoEvento'){
    $nome = $dataInic = $dataFim = $id = "";
    $nomeErr = $dataInicErr = $dataFimErr = $idErr = "";
    $novoEvento = new Evento($conn);
    $matricula = $_POST['matricula'];

    if(empty($_POST['nome'])){
        $nomeErr = "*Não foi enviado nenhum nome";
    }
    if(empty($_POST['dataInic'])){
        $dataInicErr = "*Não foi enviado nenhuma data de inicio";
    }
    if(empty($_POST['dataFim'])){
        $dataFimErr = "*Não foi enviado nenhuma data de fim";
    }
    if(empty($_POST['id'])){
        $idErr = "*Não foi enviado nenhum ID";
    }else{
        $id = $_POST['id'];
        if (!preg_match("/^[0-9]+$/", $matricula)) {
            $idErr = "id no formato incorreto";
        }
    }

    if(!empty($nomeErr) || !empty($dataInicErr) || !empty($dataFimErr) || !empty($idErr)){
        $erro = "Insira os dados corretamente!";
        header("Location:cadastrarEventos.php?erro=" . urlencode($erro) . "&matricula=" . urlencode($matricula));
        exit();
    }else{
        $nome = $_POST['nome'];
        $dataInic = $_POST['dataInic'];
        $dataFim = $_POST['dataFim'];
        $id = $_POST['id'];
        if($novoEvento->checarIdJaexistente($id) == true){
            $erro = "Id Já existente";
            header("Location:cadastrarEventos.php?erro=" . urlencode($erro) . "&matricula=" . urlencode($matricula));
            exit();
        }else if($novoEvento->createEvento($nome, $dataInic, $dataFim, $id) == true){
            header('Location: eventosGerente.php?matricula=' . $_POST['matricula']);
            exit();
        }
    }
}

if($action == 'atualizarEvento'){
    $nome = $dataInic = $dataFim = $id = "";
    $nomeErr = $dataInicErr = $dataFimErr = "";
    $updateEvento = new Evento($conn);
    $matricula = $_POST['matricula'];

    if(empty($_POST['nome'])){
        $nomeErr = "*Não foi enviado nenhum nome";
    }
    if(empty($_POST['dataInic'])){
        $dataInicErr = "*Não foi enviado nenhuma data de inicio";
    }
    if(empty($_POST['dataFim'])){
        $dataFimErr = "*Não foi enviado nenhuma data de fim";
    }

    if(!empty($nomeErr) || !empty($dataInicErr) || !empty($dataFimErr) || !empty($idErr)){
        $erro = "Insira os dados corretamente!";
        header("Location:editEventos.php?erro=" . urlencode($erro) . "&matricula=" . urlencode($matricula) . "&idEvento=" . urlencode($_POST['id']));
        exit();
    }else{
        $nome = $_POST['nome'];
        $dataInic = $_POST['dataInic'];
        $dataFim = $_POST['dataFim'];
        $id = $_POST['id'];
        if($updateEvento->updateEvento($nome, $dataInic, $dataFim, $id) == true){
            header('Location: eventosGerente.php?matricula=' . $_POST['matricula']);
            exit();
        }
    }
}

if($action == 'delete'){
    $idEvento = $_GET['idEvento'];
    $matricula = $_GET['matricula'];
    
    $deleteEvento = new Evento($conn);
    $deleteCursos = new Curso($conn);
    $deleteUsuarioCurso = new UsuarioCurso($conn);

    $deleteEvento->deleteEvento($idEvento);
    $deleteCursos->deleteCursos($idEvento);
    $deleteUsuarioCurso->deleteUsuarioCurso($idEvento); 
    header('Location: eventosGerente.php?matricula=' . $_GET['matricula']);
    exit();
}

if($action == 'atualizarCurso'){
    $titulo = $descricao = $data = $horarioInic = $horarioFim = "";
    $tituloErr = $descricaoErr = $dataErr = $horarioInicErr = $horarioFimErr = "";
    $updateCurso = new Curso($conn);
    $matricula = $_POST['matricula'];
    $id = $_POST['id'];
    $idEvento = $_POST['idEvento'];

    if(empty($_POST['titulo'])){
        $tituloErr = "*Não foi enviado nenhum titulo";
    }
    if(empty($_POST['descricao'])){
        $descricaoErr = "*Não foi enviado nenhuma descrição";
    }
    if(empty($_POST['data'])){
        $dataErr = "*Não foi enviado nenhuma data";
    }else{
        $data = $_POST['data'];
        if (!preg_match("/^[0-9\-]+$/", $data)) {
            $dataErr = "data no formato incorreto";
        }
    }
    if(empty($_POST['horarioInic'])){
        $horarioInicErr = "*Não foi enviado nenhum horario de Inicio";
    }else{
        $horarioInic = $_POST['horarioInic'];
        if (!preg_match("/^[0-9:]+$/", $horarioInic)) {
            $horarioInicErr = "horario de inicio no formato incorreto";
        }
    }
    if(empty($_POST['horarioFim'])){
        $horarioFimErr = "*Não foi enviado nenhum horario de termino";
    }else{
        $horarioFim = $_POST['horarioFim'];
        if (!preg_match("/^[0-9:]+$/", $horarioFim)) {
            $horarioFimErr = "horario de termino no formato incorreto";
        }
    }

    if(!empty($tituloErr) || !empty($descricaoErr) || !empty($dataErr) || !empty($horarioInicErr) || !empty($horarioFimErr)){
        $erro = "Insira os dados corretamente!";
        header("Location:editCursos.php?erro=" . urlencode($erro) . "&matricula=" . urlencode($matricula) . "&idEvento=" . urlencode($idEvento));
        exit();
    }else{
        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        $data = $_POST['data'];
        $horarioInic = $_POST['horarioInic'];
        $horarioFim = $_POST['horarioFim'];
        if($updateCurso->updateCurso($titulo, $descricao, $data, $horarioInic, $horarioFim, $id) == true){
            header('Location: listagemCursosGerentes.php?matricula=' . urlencode($matricula) . "&id=" . urlencode($idEvento));
            exit();
        }
    }
}

if($action == 'cadastrarNovoCurso'){
    $titulo= $descricao = $data = $horarioInic = $horarioFim = $id = "";
    $tituloErr = $descricaoErr = $dataErr = $horarioInicErr = $horarioFimErr = $idErr = "";
    $novoCurso = new Curso($conn);
    $matricula = $_POST['matricula'];
    $idEvento = $_POST['idEvento'];

    if(empty($_POST['titulo'])){
        $tituloErr = "*Não foi enviado nenhum titulo";
    }
    if(empty($_POST['descricao'])){
        $descricaoErr = "*Não foi enviado nenhuma descrição";
    }
    if(empty($_POST['data'])){
        $dataErr = "*Não foi enviado nenhuma data";
    }else{
        $data = $_POST['data'];
        if (!preg_match("/^[0-9\-]+$/", $data)) {
            $dataErr = "data no formato incorreto";
        }
    }
    if(empty($_POST['horarioInic'])){
        $horarioInicErr = "*Não foi enviado nenhum horario de inicio";
    }else{
        $horarioInic = $_POST['horarioInic'];
        if (!preg_match("/^[0-9:]+$/", $horarioInic)) {
            $horarioInicErr = "horario de inicio no formato incorreto";
        }
    }
    if(empty($_POST['horarioFim'])){
        $horarioFimErr = "*Não foi enviado nenhum horario de termino";
    }else{
        $horarioFim = $_POST['horarioFim'];
        if (!preg_match("/^[0-9:]+$/", $horarioFim)) {
            $horarioFimErr = "horario de termino no formato incorreto";
        }
    }
    if(empty($_POST['idCurso'])){
        $idErr = "*Não foi enviado nenhum ID";
    }else{
        $id = $_POST['idCurso'];
        if (!preg_match("/^[0-9]+$/", $id)) {
            $idErr = "Id no formato incorreto";
        }
    }

    if(!empty($tituloErr) || !empty($descricaoErr) || !empty($dataErr) || !empty($horarioInicErr) || !empty($horarioFimErr) || !empty($idErr)){
        $erro = "Insira os dados corretamente!";
        header("Location:cadastrarCursos.php?erro=" . urlencode($erro) . "&matricula=" . urlencode($matricula) . "&id=" . urlencode($idEvento));
        exit();
    }else{
        $titulo = $_POST['titulo'];
        $descricao = $_POST['descricao'];
        $data = $_POST['data'];
        $horarioInic = $_POST['horarioInic'];
        $horarioFim = $_POST['horarioFim'];
        $id = $_POST['idCurso'];
        if($novoCurso->checarIdJaexistente($id) == true){
            $erro = "Id Já existente";
            header("Location:cadastrarCursos.php?erro=" . urlencode($erro) . "&matricula=" . urlencode($matricula) . "&id=" . urlencode($idEvento));
            exit();
        }else if($novoCurso->createCurso($titulo, $descricao, $data, $horarioInic, $horarioFim, $idEvento, $id) == true){
            header('Location: relatorios.php?matricula=' . urlencode($matricula));
            exit();
        }
    }

}

if($action == "deleteCurso"){
    $idCurso = $_GET['idCurso'];
    $matricula = $_GET['matricula'];
    $idEventos = $_GET['idEventos'];

    $deleteCursos = new Curso($conn);
    $deleteUsuarioCurso = new UsuarioCurso($conn);

    $deleteCursos->deleteCursos2($idCurso);
    $deleteUsuarioCurso->deleteUsuarioCurso2($idCurso); 
    header('Location: listagemCursosGerentes.php?matricula=' . $_GET['matricula'] . "&id=" . htmlspecialchars($idEventos));
    exit();
}

?>