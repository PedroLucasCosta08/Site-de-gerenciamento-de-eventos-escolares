<?php

include "connect.inc.php";
include "Usuario.php";
include "Eventos.php";
include "Cursos.php";
include "Usuario_Curso.php";

if (isset($_GET['id'])) {
    $idEventos = $_GET['id'];
} else {
    $idEventos = "";
}

if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];
} else {
    $matricula = "";
}

$Curso = new Curso($conn);
$res = $Curso->getCursos($idEventos);
$nomeEvento = new Evento($conn);
$res2 = $nomeEvento->getNome($idEventos);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesEventos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="js/scripts.js"></script>
    <title>Cursos</title>
</head>
<body>

    <div class="top-bar">
    <div class="menu-container">
            <button class="menu-btn">☰ </button>
            <div class="menu-content">
                <a href='eventosAlunos.php?matricula=<?php echo $matricula; ?>'>Eventos</a>
            </div>
        </div>
    </div>

    <section class="container">
        <h2 class="table-title">Cursos do evento <?php echo $res2?></h2>    
            <table>
                <tr>
                    <th>Titulo</th>
                    <th>Descrição</th>
                    <th>Data</th>
                    <th>Horario Inicio</th>
                    <th>Horario de Termino</th>
                    <th>ID</th>                    
                    <th>
                        <?php if(isset($_GET['erro'])): ?>
                            <div class="erro"><?php echo htmlspecialchars($_GET['erro']); ?></div>
                        <?php else: ?>
                            <div class="erro">&nbsp;</div>
                        <?php endif; ?>
                    </th>
                </tr>
    <?php 
    foreach ($res as $r) {
        echo ("
            <tr>
                <td>{$r['Titulo']}</td>
                <td>{$r['descricao']}</td>
                <td>{$r['data']}</td>
                <td>{$r['horarioInic']}</td>
                <td>{$r['horarioFim']}</td>
                <td>{$r['ID']}</td>
                <td><a href='actionPaginaPrinc.php?action=inscrever&matricula=$matricula&idEventos=$idEventos&ID={$r['ID']}'>Inscrever</a></td>
                </tr>");
    }
    ?>
            </table>
        </section>

</body>
</html>