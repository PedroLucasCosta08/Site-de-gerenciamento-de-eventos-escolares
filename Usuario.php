<?php

class Usuario{
    private $nome;
    private $email;
    private $matricula;
    private $curso;
    private $senha;
    private $tipo;

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    public function createUser($post){
        $sql = "INSERT INTO usuario(Nome, Email, Matricula, Curso, Senha, Tipo)
                VALUES('{$post['nome']}',
                        '{$post['email']}',
                        '{$post['matricula']}',
                        '{$post['curso']}',
                        '{$post['senha']}',
                        '{$post['tipoU']}')";
        if($this->conn->query($sql) == TRUE){
            return true;
        }else{
            echo "ERRO: $sql<br>".$this->conn->error."<br>";
            return false;
        }
    }

    public function checkLoginReadOne($matricula, $senha){
        $sql = "SELECT  matricula, senha FROM usuario WHERE matricula = $matricula";
        $result = $this->conn->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if($row['senha'] == $senha){
                return true;
            }    
        } else {
            return false;
        }
    }

    public function getTipoU($matricula){
        $sql = "SELECT Tipo FROM usuario WHERE matricula = $matricula";
        $result = $this->conn->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            return $row['Tipo'];
        }else{
            return null;
        }
    }
    public function checarMatriculaJaexistente($matricula){
        $sql = "SELECT Matricula FROM usuario";
        $result = $this->conn->query($sql);
        if($result->num_rows > 0){
            while ($row = $result->fetch_assoc()) {
                if ($row['Matricula'] == $matricula) {
                    return true;
                }
            }
        }
        return false;
    }
    public function getAll($matricula){
        $sql = "SELECT Nome, Email, Curso, Senha FROM usuario WHERE Matricula = $matricula";
        $result = $this->conn->query($sql);
        if($result->num_rows > 0){
            return $result->fetch_all(MYSQLI_ASSOC);
        }
    }

    public function updateUsuario($nome, $email, $curso, $senha, $matricula){
        $sql = "UPDATE usuario SET Nome = '$nome', Email = '$email', Curso = '$curso', Senha = '$senha' WHERE Matricula = $matricula";
        $result = $this->conn->query($sql);
        if($this->conn->query($sql) == TRUE){
            return true;
        }else{
            echo "ERRO: $sql<br>".$this->conn->error."<br>";
            return false;
        }
    }

    public function checkTipo($matricula){
        $sql = "SELECT Tipo FROM usuario WHERE Matricula = $matricula";
        $result = $this->conn->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            return $row['Tipo'];
        }
    }

    public function getNome($matricula){
        $sql = "SELECT Nome FROM usuario WHERE Matricula = $matricula";
        $result = $this->conn->query($sql);
        $row = $result->fetch_assoc();
        return $row['Nome'];
    }

    public function getDadosUsuarios(){
        $sql = "SELECT Nome, Email, Matricula, Curso, Tipo FROM usuario";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}

?>