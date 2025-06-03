<?php  
    
//Funçao para dimenesionar a imagem
function redimensionarImagem($imagem, $largura, $altura){
    list($larguraOriginal, $alturaOriginal, $tipo) = getimagesize($imagem);

    if($tipo != IMAGETYPE_JPEG){
        die("Erro: Apenas imagens JPEG são suportadas.");
    }

    $novaImagem = imagecreatetruecolor($largura, $altura);
    $imagemOriginal = imagecreatefromjpeg($imagem);

    imagecopyresampled($novaImagem, $imagemOriginal, 0, 0, 0, 0, $largura, $altura, $larguraOriginal, $alturaOriginal);

    ob_start();
    imagejpeg($novaImagem);
    $dadosImagem = ob_get_clean();

    imagedestroy($novaImagem);
    imagedestroy($imagemOriginal);

    return $dadosImagem;
}


//CONEXAO COM O BANCO DE DADOS
$host = 'localhost';
$dbname = 'bd_imagem';
$username = 'root';
$password = 'root';

try{
    //CRIA UMA NOVA INSTANCIA DE PDO PARA CONECTAR AO BANCO DE DADOS
    $pdo = new PDO("mysql:host=$host;port=3307; dbname=$dbname;", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//DEFINE O MODO DE ERRO DO PDO PARA EXCEÇÕES
    
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto'])){
        //CODIGO ABAIXO VERIFICA SE NAO HOUVE ERRO NO UPLOAD DA FOTO
        if($_FILES['foto']['error'] == 0){
            $nome = $_POST['nome'];
            $telefone = $_POST['telefone'];
            $nomeFoto = $_FILES['foto']['name'];
            $tipoFoto = $_FILES['foto']['type'];
            
            //REDIMENSIONA A IMAGEM PARA 300X400 PIXELS
            $foto = redimensionarImagem($_FILES['foto']['tmp_name'], 300, 400);

            //PREPARA A INSTRUÇÃO SQL PARA INSERIR OS DADOS DO FINCIONARIO NO BANCO DE DADOS
            $sql = "INSERT INTO funcionarios (nome, telefone, nome_foto, tipo_foto, foto) VALUES (:nome, :telefone, :nome_foto, :tipo_foto, :foto)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':telefone', $telefone);
            $stmt->bindParam(':nome_foto', $nomeFoto);
            $stmt->bindParam(':tipo_foto', $tipo_foto);
            //O CÓDIGO ABAIXO DEFINE O PARAMENTRO DA FOTO COM 'LARGE OBJECT'(LOB)
            $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB);

            if($stmt->execute()){
                echo "Funcionario cadastrado com sucesso!";

            }else{
                echo "Erro ao cadastrar o funcionario";
            }
            }else{
                echo "Erro ao fazer UPLOAD da foto".$_FILES['foto']['error'];
            }

    }

}catch (PDOException $e){
    echo "Erro.".$e->getMessage();
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista Imagens</title>
    <link rel="stylesheet" href="styles.css">

</head>
<body>
    <h1>Lista de Imagens</h1>

    <!-- LINK PARA LISTAR FUNCIONARIOS -->
     <a href="consulta_funcionario.php">Listar Funcionários</a>
    
</body>
</html>