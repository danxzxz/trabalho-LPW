<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'util/conexao.php'; // conecta com o banco

function mostrarErro($mensagem) {
    echo "<p style='color:red;'>Erro: $mensagem</p>";
    echo "<a href='formulario.php'>Voltar ao formulário</a>";
    exit;
}

$nome    = isset($_POST['nome']) ? $_POST['nome'] : '';
$autor   = isset($_POST['autor']) ? $_POST['autor'] : '';
$ano     = isset($_POST['ano']) ? $_POST['ano'] : '';
$genero  = isset($_POST['genero']) ? $_POST['genero'] : '';
$CI      = isset($_POST['CI']) ? $_POST['CI'] : '';
$sinopse = isset($_POST['sinopse']) ? $_POST['sinopse'] : '';
$link    = isset($_POST['link']) ? $_POST['link'] : '';


if (!$nome || !$autor || !$ano || !$genero || !$CI || !$sinopse || !$link) {
    mostrarErro("Todos os campos são obrigatórios.");
 }
 

$anoAtual = 2025;
if (!is_numeric($ano) || $ano > $anoAtual) {
    mostrarErro("O ano deve ser entre 0 e $anoAtual.");
}

$inicioValido = (str_starts_with($link, 'http://') || str_starts_with($link, 'https://'));

if (!$inicioValido) {
    mostrarErro("A URL da imagem deve começar com http:// ou https://");
}


$sql = "INSERT INTO livros (nome, autor, ano, genero, classificacao, sinopse, link) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
$conn = Conexao::getConexao();
$stmt = $conn->prepare($sql);
$stmt->execute([$nome, $autor, $ano, $genero, $CI, $sinopse, $link]);



