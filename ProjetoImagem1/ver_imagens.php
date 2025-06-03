<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ob_clean();//Limpa qualquer saida inesperada antes do header
// filepath: /c:/xampp/htdocs/ProjetoImagem1/ver_imagens.php
require_once 'conecta.php';

// Obtém o ID da imagem da URL, garantindo que seja um número inteiro
$id_imagem = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Cria consulta para buscar a imagem no banco de dados
$querySelecionaPorCodigo = "SELECT tipo_imagem, imagem FROM tabela_imagem WHERE codigo = ?";

// Usa prepared statement para maior segurança
$stmt = $conexao->prepare($querySelecionaPorCodigo);
$stmt->bind_param("i", $id_imagem);
$stmt->execute();
$resultado = $stmt->get_result();

// Verifica se a imagem existe no banco de dados
if ($resultado->num_rows > 0) {
    $imagem = $resultado->fetch_object();

    // Define o tipo correto da imagem (fallback para JPEG caso esteja vazio)
    $tipo_imagem = !empty($imagem->tipo_imagem) ? $imagem->tipo_imagem : 'image/jpeg';
    header("Content-type: " . $tipo_imagem);

    // Exibe a imagem armazenada no banco de dados
    echo $imagem->imagem;
} else {
    echo "Imagem não encontrada.";
}

// Fecha a consulta
$stmt->close();
?>