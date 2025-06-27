<?php
require 'util/conexao.php';

$conn = Conexao::getConexao();

$sql = "SELECT * FROM livros ORDER BY id DESC";
$stmt = $conn->query($sql);
$livros = $stmt->fetchAll();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="UTF-8" />
   <title>Lista de Livros</title>
   <link rel="stylesheet" href="css/estilo_card.css" />
</head>

<body>

   <h1>Livros Cadastrados</h1>

   <?php if (count($livros) === 0): ?>
      <p>Nenhum livro cadastrado ainda.</p>
   <?php else: ?>
      <?php foreach ($livros as $livro): ?>
         <div class="card">
            <h2><?= ($livro['nome']) ?></h2>
            <p><strong>Autor:</strong> <?= ($livro['autor']) ?></p>
            <p><strong>Ano:</strong> <?= ($livro['ano']) ?></p>
            <p><strong>Gênero:</strong> <?= ($livro['genero']) ?></p>
            <p><strong>Classificação Indicativa:</strong> <?= ($livro['classificacao']) ?></p>
            <p><strong>Sinopse:</strong><br><?= (($livro['sinopse'])) ?></p>
            <img src="<?= ($livro['link']) ?>" alt="Capa do Livro" />
         </div>
      <?php endforeach; ?>
   <?php endif; ?>

   <a href="formulario.php">Cadastrar novo livro</a>

</body>

</html>