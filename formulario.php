<?php 
require_once('util/conexao.php');

try {
    $con = Conexao::getConexao(); // Corrigido aqui
    $stmt = $con->query("SELECT * FROM livros");
    $livros = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar livros: " . $e->getMessage();
    $livros = []; // Garante que $livros esteja definido
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilo_form.css">
    <title>Cadastro de Livro</title>


</head>

<body>
    <h2>Cadastro de Livro</h2> 
    <form method="POST" action="card.php">
        <input name="nome" placeholder="Título do Livro" />
        <br>
        <input name="autor" placeholder="Autor" />
        <br>
        <input name="ano" placeholder="Ano de Publicação" />
        <br>
        <select style="height: 35px; width: 270px; border-radius: 5px; color: gray;" name="genero" id="genero">
            <option value="">Selecione o gênero</option>
            <option value="ficcao_cientifica">Ficção Científica</option>
            <option value="fantasia">Fantasia</option>
            <option value="romance">Romance</option>
            <option value="suspense">Suspense</option>
            <option value="terror">Terror</option>
            <option value="drama">Drama</option>
            <option value="biografia">Biografia</option>
            <option value="historia">História</option>
            <option value="autoajuda">Autoajuda</option>
            <option value="poesia">Poesia</option>
            <option value="infantil">Infantil</option>
            <option value="young_adult">Young Adult (YA)</option>
            <option value="didatico">Didático</option>
            <option value="outro">Outro</option>
    </select>
    <br>
    <br>
    <select style="height: 35px; width: 270px; border-radius: 5px; color: gray;" name="CI" id="CI">
        <option value="">Selecione a classificação</option>
        <option value="livre">Livre</option>
        <option value="6_anos">A partir de 6 anos</option>
        <option value="10_anos">A partir de 10 anos</option>
        <option value="12_anos">A partir de 12 anos</option>
        <option value="14_anos">A partir de 14 anos</option>
        <option value="16_anos">A partir de 16 anos</option>
        <option value="adulto">Adulto (18+)</option>
    </select>
    <br>
        <textarea name="sinopse" placeholder="Sinopse" rows="3" cols="29"></textarea>
        <br>
        <input name="link" placeholder="URL da capa do livro" />
        <br><br>
        <button class="cadastrar" type="submit">Cadastrar</button>
    </form>

        <a href="listar.php"><button type="button" style="margin-top: 15px;">Ver cards</button></a>

    <!-- Tabela de livros (dentro do container ocultável) -->
    <div id="tabelaLivros" style="margin-top: 20px;">
        <table border="1" style="width: 100%; text-align: center; color: white; border-collapse: collapse;">
            <tr style="background-color: #333;">
                <th>ID</th>
                <th>Título</th>
                <th>Gênero</th>
                <th>Ano</th>
                <th>Autor</th>
                <th>Classificação</th>
                <th>Excluir</th>
            </tr>

            <?php foreach ($livros as $livro): ?>
                <tr>
                    <td><?= $livro['id'] ?></td>
                    <td><?= htmlspecialchars($livro['nome']) ?></td>
                    <td><?= htmlspecialchars($livro['genero']) ?></td>
                    <td><?= htmlspecialchars($livro['ano']) ?></td>
                    <td><?= htmlspecialchars($livro['autor']) ?></td>
                    <td><?= htmlspecialchars($livro['classificacao']) ?></td>
                    <td>
                        <a href="excluir.php?id=<?= $livro['id'] ?>" 
                           onclick="return confirm('Tem certeza que deseja excluir?')"
                           style="color: red;">Excluir</a>
                    </td>   
                </tr>
            <?php endforeach; ?>
        </table>

    </div>

</body>
</html>



