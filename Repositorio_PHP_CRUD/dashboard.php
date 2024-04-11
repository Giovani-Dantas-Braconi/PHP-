<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Linda</title>
</head>
<body>

<div class="select">
    <?php
    // Inclua o arquivo com a definição da classe Conexao
    require_once("gravarPDO.php");

    // Crie um objeto Conexao
    $conexao = new Conexao();

    // Conecte-se ao banco de dados
    $conexao->connect();

    // Execute a consulta SQL usando a função select() da classe Conexao
    $resultados = $conexao->select();

    // Verifique se existem resultados
    if ($resultados) {
        // Itere sobre os resultados e exiba as informações dentro de uma tabela




        //txtnome=giovani+dantas&txtsenha=2344&txtidade=2024-04-02

        echo "<table border='1'>";
        echo "<tr><th>Codigo</th><th>Nome</th><th>Senha</th><th>Idade</th><th>Excluir</th><th>Update</th></tr>";
        foreach ($resultados as $aluno) {
            echo "<tr>";
            echo "<td>" . $aluno['codigo'] . "</td>";
            echo "<td>" . $aluno['nome'] . "</td>";
            echo "<td>" . $aluno['senha'] . "</td>";
            echo "<td>" . $aluno['idade'] . "</td>";
            echo "<td><a href='delete.php?codigo={$aluno['codigo']}'>Excluir Aluno</a></td>";
            echo "<td><a href='update.php?codigo={$aluno['codigo']}&txtnome={$aluno['nome']}&txtidade={$aluno['idade']}&txtsenha={$aluno['senha']}'>Udpaita arquivos do Aluno</a></td>";
            echo "</tr>";

            
        }
        
        echo "</table>";
    } else {
        echo "Não foram encontrados registros.";
    }
    ?>
</div>

</body>
</html>
