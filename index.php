<?php

require_once('classes/Crud.php');
require_once('conexao/conexao.php');

$database = new Database ();
$db = $database->Conex();
$crud =new Crud ($db);


if(isset($_GET['action'])){
    switch($_GET['action']){
        case 'create':
            $crud->create($_POST);
            $rows = $crud->read();
            break;
        case 'read';
            $rows = $crud->read();
            break;
        case 'update':
            if(isset($_POST['id'])){
                $crud->update($_POST);
            }
            $rows = $crud->read();
            break;
        
        case 'delete':
            $crud->delete($_GET['id']);
            $rows = $crud->read();
            break;

        default:
            $rows = $crud->read();
            break;
    }
}else{
    $rows = $crud->read();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD REVISAO</title>
    <style>
        form{
            max-width:500px;
            margin: 0 auto;
        }
        label{
            display: flex;
            margin-top: 10px;
        }
        input[type=text]{
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        input[type=submit]{
            background-color: #4caf50;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor:pointer;
            float: right;
        }
        input [type=submit]:hover{
            background-color: #45a049;
        }
        table{
            border-collapse: collapse;
            width: 100%;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            color:#333
        }
        th,td{
            text-align: left;
            padding: 8px;
            border: 1px solid #ddd;
        }
        th{
            background-color: #f2f2f2f2;
            font-weight: bold;
        }
        a{
            display: inline-block;
            padding: 4px 8px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }
        a:hover{
            background-color: #0069d9;
        }
        a.delete{
            background-color: #dc3545;
        }
        a.delete:hover{
            background-color: #c82333;
        }
    </style>
</head>
<body>
<?php

if(isset($_GET['action'])&& $_GET['action'] == 'update' && isset ($_GET['id'])){
    $id = $_GET['id'];
    $result = $crud->readOne($id);

    if(!$result){
        echo "Registro não encontrado.";
        exit();
    }
    $nome = $result ['nome'];
    $idade = $result ['idade'];
    $sexo = $result ['sexo'];
    $email = $result ['email'];
    $telefone = $result ['telefone'];

?>
<form action="?action=update" method="POST">
    <input type="hidden" name="id" value="<?php echo $id ?>">
    <label for="nome">Nome</label>
    <input type="text" name="nome" value="<?php echo $nome?>">

    <label for="idade">Idade</label>
    <input type="text" name="idade" value="<?php echo $idade ?>">

    <label for="sexo">Sexo</label>
    <input type="text" name="sexo" value="<?php echo $sexo ?>">

    
    <label for="email">Email</label>
    <input type="text" name="email" value="<?php echo $email ?>">

    
    <label for="telefone">Telefone</label>
    <input type="text" name="telefone" value="<?php echo $telefone ?>">

    <input type="submit" value = "Atualizar" name="enviar" onclick="return confirm('Certeza que deseja atualizar?')">
</form>
<?php
        }else{

?>       
    <form action="?action=create" method="POST">
        <label for="">Nome</label>
        <input type="text" name="nome">

        <label for="">Idade</label>
        <input type="text" name="idade">

        <label for="">Sexo</label>
        <input type="text" name="sexo">

        <label for="">Email</label>
        <input type="text" name="email">

        <label for="">Telefone</label>
        <input type="text" name="telefone">

        <input type="submit" value="Cadastrar" name="enviar">
    </form>
    <?php
        }
    ?>

    <table>
        <tr>
            <td>Id</td>
            <td>Nome</td>
            <td>Idade</td>
            <td>Sexo</td>
            <td>Email</td>
            <td>Telefone</td>
            <td>Ações</td>
        </tr>
        <?php
        if(isset($rows)){
            foreach($rows as $row){
                echo "<tr>";
                echo "<td>". $row ['id']. "</td>";
                echo "<td>". $row ['nome']. "</td>";
                echo "<td>". $row ['idade']. "</td>";
                echo "<td>". $row ['sexo']. "</td>";
                echo "<td>". $row ['email']. "</td>";
                echo "<td>". $row ['telefone']. "</td>";
                echo "<td>";
                echo "<a href ='?action=update&id=" .$row ['id']."'>Editar</a>";
                echo "<a href ='?action=delete&id=" .$row ['id']."'onclick='return confirm(\"Tem certeza que deseja deletar esse registro?\")' class = 'delete'>Deletar</a>";
                echo "</td>";
                echo "</tr>";

            }

        }else{
                echo "Não há registros a serem exibidos";
            }
        
        ?>
    </table>
</body>
</html>