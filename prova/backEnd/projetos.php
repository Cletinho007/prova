<?php
header('Access-Control-Allow-Origin: *'); //Permite acesso de todas as origens
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
//Permite acesso dos métodos GET, POST, PUT, DELETE
//PUT é utilizado para fazer um UPDATE no banco
//DELETE é utilizado para deletar algo do banco
header('Access-Control-Allow-Headers: Content-Type'); //Permite com que qualquer header consiga acessar o sistema
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
    exit;
}
include 'conexao.php';
//inclui os dados de conexão com o bd no sistema abaixo

//Rota para obter todos os livros
//Utilizando o GET
if($_SERVER['REQUEST_METHOD'] === 'GET'){
    $stmt = $conn->prepare("SELECT * FROM projetos");
    $stmt -> execute();
    $projetos = $stmt ->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($projetos);
    //converter dados em json
}
//-------------------------------------------------
//Rota para inserir livros
//Utilizando o POST
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nome = $_POST['nome'];
    $cliente = $_POST['cliente'];
    $dataProjeto = $_POST['dataProjeto'];
    $statusProjeto = $_POST['statusProjeto'];
    //inserir outros campos caso necessario ....

    $stmt = $conn->prepare("INSERT INTO projeto ( idcarro, nome, cliente, dataProjeto, statusProjeto) VALUES (:idcarro, :nome, :cliente, :dataProjeto, :statusProjeto)");
    $stmt -> bindParam(':nome', $nome);
    $stmt -> bindParam(':cliente', $cliente);
    $stmt -> bindParam(':dataProjeto', $dataProjeto);
    $stmt -> bindParam(':statusProjeto', $statusProjeto);
    $stmt -> bindParam(':idcarro', $idcarro);
    //Outros bindParams ....

    if($stmt->execute()){
        echo "projeto agendada com sucesso!!";
    }else{
        echo "Erro ao agendadar projeto";
    }
}

//Rota para atualizar uma rota existente
if($_SERVER['REQUEST_METHOD']==='PUT' && isset($_GET['id'])){
    //convertendo dados recebidos em string
    parse_str(file_get_contents("php://input"), $_PUT);

    $id = $_GET['id'];
    $novo_nome = $_PUT['nome'];
    $novo_cliente = $_PUT['cliente'];
    $novo_dataProjeto = $_PUT['dataProjeto'];
    $novo_statusProjeto = $_PUT['statusProjeto'];

    $stmt = $conn->prepare("UPDATE projeto SET nome = :nome, cliente = :cliente, dataProjeto, = :dataProjeto, statusProjeto = :statusProjeto WHERE id = :id");
    $stmt->bindParam(':nome', $novo_nome);
    $stmt->bindParam(':cliente', $novo_cliente);
    $stmt->bindParam(':dataProjeto', $novo_dataProjeto);
    $stmt->bindParam(':statusProjeto', $novo_statusProjeto);
    $stmt->bindParam(':id', $id);

    if($stmt->execute()){
        echo "projeto atualizada com sucesso!!";
    } else {
        echo "Erro ao atualizar a projeto :( ";
    }
}

//rota para deletar uma projeto exister
if($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])){
    $id = $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM projeto WHERE id = :id");
    $stmt->bindParam(':id', $id);

    if($stmt->execute()){
        echo "projeto excluida com sucesso!!";
    } else {
        echo "erro ao excluir projeto";
    }
}

