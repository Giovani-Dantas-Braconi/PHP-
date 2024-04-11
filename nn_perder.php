<?php

class Conexao {

    private $host; 
    private $dbname; 
    private $user; 
    private $password;
    private $pdo;

    public function __construct(){
      $this->host = "localhost";
      $this->dbname = "porco";
      $this->user = "root";
      $this->password = "";
    }     

    public function connect(){
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Erro ao conectar com o banco de dados: " . $e->getMessage());
        }
    }

    function select() {
        try {
            // Prepara a consulta SQL
            $sql = "SELECT * FROM alunos";
            $stmt = $this->pdo->prepare($sql);
            
            // Executa a consulta
            $stmt->execute();
    
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch(PDOException $e) {
            die("Erro ao executar consulta: " . $e->getMessage());
        }
    }
    

    public function verify($nome, $idade){
    $sql = "SELECT * FROM alunos WHERE nome = :nome AND idade = :idade";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':idade', $idade);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        // Se já existe
        return true;
    } else {
        // se já não existe
        return false;
    }
}


public function verifybank($codigo){
    $sql = "SELECT COUNT(*) AS contagem FROM alunos WHERE codigo = :codigo";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':codigo', $codigo);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $result['contagem'];

    // Se o código já existir, gera um novo até encontrar um código único
    while ($count > 0) {
        $codigo = rand(10000, 99999) . date("Y");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $count = $result['contagem'];
    }
} 

public function create(){
    // Gera um código único
    $codigo = rand(10000, 99999) . date("Y");
    $this->verifybank($codigo);
    // Recupera os dados do formulário
    $nome = $_REQUEST["txtnome"];
    $senha = $_REQUEST["txtsenha"];
    $idade = $_REQUEST["txtidade"];

    // Verifica se já existe um registro com o mesmo nome e idade
    if ($this->verify($nome, $idade)) {
        echo "Já existe um registro com o mesmo nome e idade. <a href='formulario_inicial.html'>Responder novamente </a>";
        return; 
    }

    // Insere os dados no banco de dados
    $sql = "INSERT INTO alunos(codigo, nome, senha, idade) VALUES (:codigo, :nome, :senha, :idade)";
    $stmt = $this->pdo->prepare($sql);
    $stmt->bindParam(':codigo', $codigo);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':senha', $senha);
    $stmt->bindParam(':idade', $idade);
    
    // Executa a inserção
    if ($stmt->execute()) {
        echo "Foi cadastrado corretamente no banco. <a href='dashboard.php'>Visualizar as infos já cadastradas</a>";
    } else {
        echo "Erro ao cadastrar.";
    }
}


    public function delete(){
        $codigo = $_REQUEST["codigo"];

        $sql = "DELETE FROM alunos WHERE codigo = :codigo";
        $stm = $this->pdo->prepare($sql);
        $stm->bindValue(':codigo', $codigo);

        $res = $stm->execute();

        if ($res) {
            echo 'Dados excluídos com sucesso!';
        } else {
            echo 'Erro ao excluir!';
        } 
        echo "<br><br>" ;
        echo "Foi excluido corretamente no banco. <a href='dashboard.php'>Visualizar as infos já cadastradas</a>";
    }





    public function update(){
       
        //txtnome=giovani+dantas&txtsenha=2344&txtidade=2024-04-02

    $codigo = $_REQUEST['codigo'];
    $nome = $_REQUEST["txtnome"];
    $senha = $_REQUEST["txtsenha"];
    $idade = $_REQUEST["txtidade"];


    $sql = 'SELECT * FROM alunos WHERE codigo=:codigo,nome=:nome,senha=:senha,idade=:idade';
    
    $stm = $this->pdo->prepare($sql);
    $stm->bindValue(':codigo', $codigo);
    $stm->bindValue(':nome', $nome);
    $stm->bindValue(':senha', $senha);
    $stm->bindValue(':idade', $idade);
    } 

    public function gravarAlteracao(){
    $codigo = $_REQUEST["txtcodigo"];
    $senha = $_REQUEST["txtsenha"];
    $nome = $_REQUEST["txtnome"];
    $idade = $_REQUEST["txtidade"];
 

    $sql = 'UPDATE alunos SET nome=:nome, idade=:idade, senha=:senha WHERE codigo=:codigo';

    $stm = $this->pdo->prepare($sql);
    $stm->bindValue(':codigo', $codigo);
    $stm->bindValue(':senha', $senha);
    $stm->bindValue(':nome', $nome);
    $stm->bindValue(':idade', $idade);

    $res = $stm->execute();

    if ($res) {
      echo 'Dados alterados com sucesso!';
    } else {
      echo 'Erro ao alterar!';
    }
    echo "<br><br>";
    echo "<a href='dashboard.php'>Voltar</a>";
 
    }
}