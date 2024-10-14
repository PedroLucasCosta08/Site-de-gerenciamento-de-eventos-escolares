<?php

class Curso{
    private $Titulo;
    private $descricao;
    private $data;
    private $horarioInic;
    private $horarioFim;
    private $IDeventos;
    private $ID;
    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function createCurso($titulo, $descricao, $data, $horarioInic, $horarioFim, $IDeventos, $ID){
        $sql = "INSERT INTO curso(titulo , descricao, data, horarioInic, horarioFim, IDeventos, ID)
                VALUES('$titulo',
                        '$descricao',
                        '$data',
                        '$horarioInic',
                        '$horarioFim',
                        '$IDeventos',
                        '$ID')";
        if($this->conn->query($sql) == TRUE){
            return true;
        }else{
            echo "ERRO: $sql<br>".$this->conn->error."<br>";
            return false;
        }
    }

    public function checkLoginReadOne($ID){
        $sql = "SELECT  * FROM curso WHERE ID = $ID";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            return $row;    
        }
    }

    public function getCursos($ID){
        $sql = "SELECT Titulo, descricao, data, horarioInic, horarioFim, ID FROM curso WHERE IDeventos = $ID";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC); 
    }

    public function getNomeCursos($ID){
        $sql = "SELECT Titulo FROM curso WHERE ID = $ID";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['Titulo'];
    }

    public function deleteCursos($idEvento){
        $sql = "DELETE FROM curso WHERE IDeventos = $idEvento";
        $result = $this->conn->query($sql);
        if($this->conn->query($sql) == TRUE){
            return true;
        }else{
            echo "ERRO: $sql<br>".$this->conn->error."<br>";
            return false;
        }
    }

    public function deleteCursos2($idCurso){
        $sql = "DELETE FROM curso WHERE ID = $idCurso";
        $result = $this->conn->query($sql);
        if($this->conn->query($sql) == TRUE){
            return true;
        }else{
            echo "ERRO: $sql<br>".$this->conn->error."<br>";
            return false;
        }
    }

    public function getAllDoCurso($idCurso){
        $sql = "SELECT * FROM curso WHERE ID = $idCurso";
        $result = $this->conn->query($sql);
        if($result->num_rows > 0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function updateCurso($titulo, $descricao, $data, $horarioInic, $horarioFim, $id){
        $sql = "UPDATE curso SET Titulo = '$titulo', descricao = '$descricao', data = '$data', horarioInic = '$horarioInic', horarioFim = '$horarioFim' WHERE ID = $id";
        $result = $this->conn->query($sql);
        if($this->conn->query($sql) == TRUE){
            return true;
        }else{
            echo "ERRO: $sql<br>".$this->conn->error."<br>";
            return false;
        }
    }

    public function checarIdJaexistente($id){
        $sql = "SELECT ID FROM curso";
        $result = $this->conn->query($sql);
        if($result->num_rows > 0){
            while ($row = $result->fetch_assoc()) {
                if ($row['ID'] == $id) {
                    return true;
                }
            }
        }
        return false;
    }
}

?>