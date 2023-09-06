
<?php 


include_once ('conexao/conexao.php');


$db = new Database();

class Crud {
    private $conn;
    private $table_name = "user";

    public function __construct($db){
        $this->conn = $db;
    }
    public function create ($postValues){
        $nome = $postValues['nome'];
        $idade = $postValues['idade'];
        $sexo = $postValues['sexo'];
        $email = $postValues['email'];
        $telefone = $postValues['telefone'];

        $query = "INSERT INTO ". $this->table_name. "(nome,idade,sexo,email,telefone) VALUES (?,?,?,?,?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$nome);
        $stmt->bindParam(2,$idade);
        $stmt->bindParam(3,$sexo);
        $stmt->bindParam(4,$email);
        $stmt->bindParam(5,$telefone);
        $rows = $this->read();
        if($stmt->execute()){
            print "<script>alert('Cadastro Ok!')</script>";
            print "<script> location.href='?action=read'; </script>";
            return true;
        }else{
            return false;
        }
    }

    public function read(){
        $query = "SELECT * FROM ". $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute(); 
        return $stmt;

    }

    public function update($postValues){
        $id = $postValues['id'];
        $nome = $postValues['nome'];
        $idade = $postValues['idade'];
        $sexo = $postValues['sexo'];
        $email = $postValues['email'];
        $telefone = $postValues['telefone'];


        
        if(empty($id) || empty($nome) || empty($idade) || empty($sexo) || empty($email) || empty($telefone)){
            return false;
        }

        $query = "UPDATE ". $this->table_name."SET nome = ?, idade = ?, sexo = ?, email = ?, telefone = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$nome);
        $stmt->bindParam(2,$idade);
        $stmt->bindParam(3,$sexo);
        $stmt->bindParam(4,$email);
        $stmt->bindParam(5,$telefone);
        $stmt->bindParam(6,$id);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

    }
    public function readOne($id){
        $query = "SELECT * FROM ". $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);

    }
    public function delete ($id){
        $query = "DELETE FROM  ". $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1,$id);
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
        }

    }


?>