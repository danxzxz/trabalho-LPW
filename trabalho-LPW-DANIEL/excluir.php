<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once('util/conexao.php');

if (!isset($_GET['id'])) {
    echo "<script>alert('ID inexistente');</script>";
    echo "<a href='formulario.php'>Voltar para o cadastro</a>";
    exit;
}

$idExcluir = $_GET['id'];

$conn = Conexao::getConexao();
//exclusão no sql
$sql = "DELETE FROM livros WHERE id = ?";
$stm = $conn->prepare($sql);
$stm->execute([$idExcluir]);

header("Location: formulario.php");
exit;
