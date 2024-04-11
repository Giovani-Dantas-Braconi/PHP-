<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
require_once("gravarPDO.php");
$visualizao = new Conexao();
$visualizao->connect();
$visualizao->update();
?>

<form name="form1" action="gravar_alteracao.php" method="post">
              
                    Código:
                    <input type="text" name="txtcodigo" readonly value="<?php echo $_REQUEST['codigo'] ; ?>">
                     
                    <br> <br>

                    Nome:
                    <input type="text" name="txtnome" value="<?php echo $_REQUEST['txtnome'] ; ?>"> 
                    <br> <br>

                    Senha:
                    <input type="text" name="txtsenha" value="<?php echo $_REQUEST['txtsenha'] ; ?>">  <br> <br>

                    Idade:
                    <input type="text" name="txtidade" value="<?php echo $_REQUEST['txtidade'] ; ?>">  <br> <br> <br>


                    <input type="submit" value="Alterar" > <br>
                    <div id="mensagem"></div>
                </form>

    
</body>
</html>



