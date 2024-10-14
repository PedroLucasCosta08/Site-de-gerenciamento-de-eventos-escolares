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

$rankingAlunos = new UsuarioCurso($conn);
$top1 = $top2 = $top3 = [
    'matricula' => null,
    'cursos' => 0
];

$matriculasInscritas = $rankingAlunos->getAllMatriculas();

foreach ($matriculasInscritas as $mats) {
    $countAtual = $rankingAlunos->getNumCursos($mats);

    if ($countAtual > $top1['cursos']) {
        $top3 = $top2;

        $top2 = $top1;

        $top1 = [
            'matricula' => $mats,
            'cursos' => $countAtual
        ];
    } elseif ($countAtual > $top2['cursos']) {
        $top3 = $top2;

        $top2 = [
            'matricula' => $mats,
            'cursos' => $countAtual
        ];
    } elseif ($countAtual > $top3['cursos']) {
        $top3 = [
            'matricula' => $mats,
            'cursos' => $countAtual
        ];
    }
}

$nomeTop1 = $checkTipoUsuario->getNome($top1['matricula']);
$nomeTop2 = $checkTipoUsuario->getNome($top2['matricula']);
$nomeTop3 = $checkTipoUsuario->getNome($top3['matricula']);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesEventos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="js/scripts.js"></script>
    <title>Ranking</title>
</head>
<body>

    <div class="top-bar">
        <div class="menu-container">
            <button class="menu-btn">☰ </button>
            <div class="menu-content">
                <a href="eventos<?php echo $tipo ?>.php?matricula=<?php echo $matricula ?>">Eventos</a>
            </div>
        </div>
    </div>

    <section class="container">
        <h2 class="table-title">Ranking dos Alunos</h2>
        <table>
            <tr>
                <th>Posição</th>
                <th>Nome</th>
                <th>Aluno de Matricula</th>
                <th>Cursos Inscritos</th>
            </tr>
            <?php 
                echo ("
                <tr>
                    <td class='tdTop1'>Top 1</td>
                    <td>$nomeTop1</td>
                    <td>{$top1['matricula']}</td>
                    <td>{$top1['cursos']}</td>
                </tr>");
                echo ("
                <tr>
                    <td class='tdTop2'>Top 2</td>
                    <td>$nomeTop2</td>
                    <td>{$top2['matricula']}</td>
                    <td>{$top2['cursos']}</td>
                </tr>");
                echo ("
                <tr>
                    <td class='tdTop3'>Top 3</td>
                    <td>$nomeTop3</td>
                    <td>{$top3['matricula']}</td>
                    <td>{$top3['cursos']}</td>
                </tr>");
            ?>
        </table>
    </section>

</body>
</html>