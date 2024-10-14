<?php

class UsuarioCurso{
    private $matriculaCurso;
    private $IDcurso;
    private $IDeventos;
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function inscreverAlunoCurso($matricula, $IDcurso, $IDevento){
        $sql = "INSERT INTO usuario_curso(matriculaCurso, IDcurso, IDeventos)
                VALUES('$matricula',
                        '$IDcurso',
                        '$IDevento')";
        if($this->conn->query($sql) == TRUE){
            return true;
        }else{
            echo "ERRO: $sql<br>".$this->conn->error."<br>";
            return false;
        }
    }

    public function checarCursoJaInscrito($matricula, $IDcurso){
        $sql = "SELECT IDcurso FROM usuario_curso WHERE matriculaCurso = $matricula";
        $result = $this->conn->query($sql);
        if($result->num_rows > 0){
            while ($row = $result->fetch_assoc()) {
                if ($row['IDcurso'] == $IDcurso) {
                    return true;
                }
            }
        }
        return false;
    }

    public function readAllCursosInscritos($matricula){
        $sql = "SELECT IDcurso FROM usuario_curso WHERE matriculaCurso = $matricula";
        $result = $this->conn->query($sql);
        if($result->num_rows > 0){
            $cursos = [];
            while($row = $result->fetch_assoc()){
                $cursos[] = $row['IDcurso'];
            }
            return $cursos;
        }else{
            return null;
        }
    }

    public function checarHorarios($cursosInscritos, $cursoInscrevendo){
        # 3 / 2011
        $sql = "SELECT horarioInic, horarioFim, data FROM curso WHERE ID = $cursoInscrevendo";
        $result = $this->conn->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $horarioInicio = $row['horarioInic'];
            $horarioFim = $row['horarioFim'];
            $data = $row['data'];
        }
        $sql2 = "SELECT horarioInic, horarioFim, data FROM curso WHERE ID = $cursosInscritos";
        $result2 = $this->conn->query($sql2);
        if($result2->num_rows > 0){
            $row2 = $result2->fetch_assoc();
            $horariosInicioInscrito = $row2['horarioInic'];
            $horariosFimInscrito = $row2['horarioFim'];
            $data2 = $row2['data'];
            if($data == $data2 && ($horarioInicio < $horariosFimInscrito  || $horarioInicio == $horariosInicioInscrito) && ($horarioFim > $horariosInicioInscrito)){
                return true;
            }
        }
        return false;
    }

    public function getAllMatriculas(){
        $sql = "SELECT DISTINCT matriculaCurso FROM usuario_curso";
        $result = $this->conn->query($sql);
        if($result->num_rows > 0){
            $matriculas = [];
            while($row = $result->fetch_assoc()){
                $matriculas[] = $row['matriculaCurso'];
            } 
            return $matriculas;
        }
    }

    public function getNumCursos($matricula){
        $sql = "SELECT count(IDcurso) as numCursos FROM usuario_curso WHERE matriculaCurso = $matricula";
        $result = $this->conn->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            $numCursosInscritos = $row['numCursos'];
            return $numCursosInscritos;
        }
    }

    public function getAlunosCursos(){
        $sql = "SELECT matriculaCurso, IDcurso FROM usuario_curso";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function deleteUsuarioCurso($idEvento){
        $sql = "DELETE FROM usuario_curso WHERE IDeventos = $idEvento";
        $result = $this->conn->query($sql);
        if($this->conn->query($sql) == TRUE){
            return true;
        }else{
            echo "ERRO: $sql<br>".$this->conn->error."<br>";
            return false;
        }
    }

    public function deleteUsuarioCurso2($idCurso){
        $sql = "DELETE FROM usuario_curso WHERE IDcurso = $idCurso";
        $result = $this->conn->query($sql);
        if($this->conn->query($sql) == TRUE){
            return true;
        }else{
            echo "ERRO: $sql<br>".$this->conn->error."<br>";
            return false;
        }
    }
}

?>