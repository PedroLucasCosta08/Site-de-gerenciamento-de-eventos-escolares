#public function checarCursoJaInscrito($matricula, $IDcurso, $IDevento){
    #    $sql = "SELECT matriculaCurso, IDeventos FROM usuario_curso WHERE IDcurso = $IDcurso";
    #    $result = $this->conn->query($sql);
     #   if($result->num_rows > 0){
     #       while ($row = $result->fetch_assoc()) {
      #          if ($row['Matricula'] == $matricula) {
     #               return true;
     #           }
    #        }
    #    }
    #    return false;
    #}

------

    #if($InscreverCurso->checarCursoJaInscrito($matricula, $idCurso, $idEventos) == TRUE){
    #    $err = "Já Inscrito no curso";
    #    header('Location: listagemCursos.php?erro=' . urlencode($err));
    #    exit();
    #}else{
        $InscreverCurso->inscreverAlunoCurso($matricula, $idCurso,$idEventos);
    #    header('Location: eventosAlunos.php');
    #    exit();
    #}