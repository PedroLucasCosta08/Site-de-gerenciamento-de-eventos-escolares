<?php

include "connect.inc.php";
include "Usuario.php";
include "Eventos.php";
include "Cursos.php";
include "Usuario_Curso.php";

$relatoriosUsuarios = new Usuario($conn);
$res = $relatoriosUsuarios->getDadosUsuarios();
$relatorioEventos = new Evento($conn);
$res2 = $relatorioEventos->readAll();
$relatoriosAlunosCursos = new UsuarioCurso($conn);
$res3 = $relatoriosAlunosCursos->getAlunosCursos();
$nomeCursos = new Curso($conn);

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

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesEventos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Relatorios</title>
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

    <section class="container">
        <h2 class="table-title">Relatorio de usuarios cadastrados</h2>
        <table>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Matricula</th>
                <th>Curso</th>
                <th>Tipo</th>
            </tr>
            <?php 
            foreach ($res as $r) {
                echo ("
                    <tr>
                        <td>{$r['Nome']}</td>
                        <td>{$r['Email']}</td>
                        <td>{$r['Matricula']}</td>
                        <td>{$r['Curso']}</td>
                        <td>{$r['Tipo']}</td>
                    </tr>");
            }
            ?>
        </table>
    </section>

    <section class="container">
        <h2 class="table-title">Relatorio de Eventos</h2>
        <table>
            <tr>
                <th>Nome</th>
                <th>Data de Inicio</th>
                <th>Data Final</th>
                <th>ID</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <?php 
            foreach ($res2 as $r) {
                echo ("
                <tr>
                    <td>{$r['nome']}</td>
                    <td>{$r['dataInic']}</td>
                    <td>{$r['dataFim']}</td>
                    <td>{$r['ID']}</td>
                    <td><a href='cadastrarCursos.php?id={$r['ID']}&matricula=$matricula'>Inserir Cursos</a></td>
                    <td><a href='listagemCursosGerentes.php?id={$r['ID']}&matricula=$matricula'>Cursos</a></td>
                </tr>");
            }
            ?>
        </table>
    </section>

    <section class="container">
        <h2 class="table-title">Relatorio de Inscrições</h2>
        <table>
            <tr>
                <th>Nome Aluno</th>
                <th>Matricula Aluno</th>
                <th>Nome Curso Inscrito</th>
                <th>ID Curso Inscrito</th>
            </tr>
            <?php 
            foreach ($res3 as $r) {
                $nomeAluno = $relatoriosUsuarios->getNome($r['matriculaCurso']);
                $nomeCurso = $nomeCursos->getNomeCursos($r['IDcurso']);
                echo ("
                    <tr>
                        <td>$nomeAluno</td>
                        <td>{$r['matriculaCurso']}</td>
                        <td>$nomeCurso</td>
                        <td>{$r['IDcurso']}</td>
                    </tr>");
            }
            ?>
        </table>
    </section>
        

</body>
</html>
