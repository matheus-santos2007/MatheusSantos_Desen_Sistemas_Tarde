<?php
require_once 'conecta.php';


//obtem o ID da imagem da URL,garantindo que seja um numero inteiro
$id_imagem = isset($_GET['id']) ? intval($_GET['id']) : 0;

//VERIFICA SE O ID É VALIDO (MAIOR QUE ZERO)
if($id_imagem > 0 ){
    //Cria a QUERRY segura usando o prepared statement
    $queryExclusao = "DELETE FROM tabela_imagem WHERE codigo = ?";

    //PREPARA A QUERRY
    //USA PREPARED STATEMENT PARA MAIOR SEGURANÇA
    $stmt = $conexao->prepare($queryExclusao);
    $stmt->bind_param("i", $id_imagem);//DEFINE O ID COMO UM INTEIRO

    //EXECUTA A EXCLUSÃO
    if($stmt->execute()){
        echo "Imagem excluida com sucesso!";

    }else{
        die("Erro ao excluir a imagem: " . $stmt->error);
    }

    //FECHA A CONSULTA
    $stmt->close();

}else{
    echo "ID inválido";

}

//REDIRECIONA PARA A INDEX.PHP E GARANTE QUE O SCRIPT PARE
header('Location: index.php');
exit();


?>