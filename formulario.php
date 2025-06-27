<?php
require_once('util/conexao.php');

$erros = [];
$sucesso = false;

if (isset($_POST['nome'], $_POST['autor'], $_POST['ano'], $_POST['genero'], $_POST['CI'], $_POST['sinopse'], $_POST['link'])) {
    // Captura dos dados do formulário
    $nome    = $_POST['nome'];
    $autor   = $_POST['autor'];
    $ano     = $_POST['ano'];
    $genero  = $_POST['genero'];
    $CI      = $_POST['CI'];
    $sinopse = $_POST['sinopse'];
    $link    = $_POST['link'];

    // Validações
    if (!$nome || !$autor || !$ano || !$genero || !$CI || !$sinopse || !$link) {
        $erros[] = "Todos os campos são obrigatórios.";
    }

    $anoAtual = date("Y");
    if (!is_numeric($ano) || $ano < 0 || $ano > $anoAtual) {
        $erros[] = "O ano deve ser entre 0 e $anoAtual.";
    }

    if (!str_starts_with($link, 'http://') && !str_starts_with($link, 'https://')) {
        $erros[] = "A URL da imagem deve começar com http:// ou https://";
    }

    if (trim($nome) === '' || trim($autor) === '' || trim($sinopse) === '') {
        $erros[] = "Os campos não podem conter apenas espaços em branco.";
    }

    // Inserção no banco
    if (empty($erros)) {
        try {
            $conn = Conexao::getConexao();
            $sql = "INSERT INTO livros (nome, autor, ano, genero, classificacao, sinopse, link, data_cadastro) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $data = date("Y");

            $stmt = $conn->prepare($sql);
            $stmt->execute([$nome, $autor, $ano, $genero, $CI, $sinopse, $link, $data]);

            $sucesso = true;
            $_POST = [];
        } catch (PDOException $e) {
            $erros[] = "Erro ao salvar no banco: " . $e->getMessage();
        }
    }
}

// Carregamento dos livros
try {
    $con = Conexao::getConexao();
    $stmt = $con->query("SELECT * FROM livros");
    $livros = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao buscar livros: " . $e->getMessage();
    $livros = [];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Livro</title>
    <link rel="stylesheet" href="css/estilo_form.css">
</head>

<body>
    <h2>Cadastro de Livro</h2>

    <!-- Mensagens -->
    <?php if (!empty($erros)): ?>
        <div class="erros">
            <?php foreach ($erros as $erro): ?>
                <p><?= $erro ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <?php if ($sucesso): ?>
        <div class="sucesso">
            Livro cadastrado com sucesso!
        </div>
    <?php endif; ?>

    <!-- Formulário -->
    <form method="POST">
        <input name="nome" placeholder="Título do Livro" value="<?= $_POST['nome'] ?? '' ?>" /><br>
        <input name="autor" placeholder="Autor" value="<?= $_POST['autor'] ?? '' ?>" /><br>
        <input name="ano" placeholder="Ano de Publicação" value="<?= $_POST['ano'] ?? '' ?>" /><br>

        <!-- Gênero -->
        <select name="genero" style="height: 35px; width: 270px; border-radius: 5px; color: gray;">
            <option value="">Selecione o gênero</option>
            <?php
            $generos = ["ficcao_cientifica", "fantasia", "romance", "suspense", "terror", "drama", "biografia", "historia", "autoajuda", "poesia", "infantil", "young_adult", "didatico", "outro"];
            foreach ($generos as $g) {
                $selected = ($_POST['genero'] ?? '') === $g ? 'selected' : '';
                echo "<option value=\"$g\" $selected>$g</option>";
            }
            ?>
        </select><br><br>

        <!-- Classificação -->
        <select name="CI" style="height: 35px; width: 270px; border-radius: 5px; color: gray;">
            <option value="">Selecione a classificação</option>
            <?php
            $classificacoes = [
                "livre" => "Livre",
                "6_anos" => "A partir de 6 anos",
                "10_anos" => "A partir de 10 anos",
                "12_anos" => "A partir de 12 anos",
                "14_anos" => "A partir de 14 anos",
                "16_anos" => "A partir de 16 anos",
                "adulto" => "Adulto (18+)"
            ];
            foreach ($classificacoes as $valor => $label) {
                $selected = ($_POST['CI'] ?? '') === $valor ? 'selected' : '';
                echo "<option value=\"$valor\" $selected>$label</option>";
            }
            ?>
        </select><br>

        <textarea name="sinopse" placeholder="Sinopse" rows="3" cols="29"><?= $_POST['sinopse'] ?? '' ?></textarea><br>
        <input name="link" placeholder="URL da capa do livro" value="<?= $_POST['link'] ?? '' ?>" /><br><br>

        <button class="cadastrar" type="submit">Cadastrar</button>
    </form>

    <a href="listar.php"><button type="button" style="margin-top: 15px;">Ver cards</button></a>

    <!-- Tabela de livros -->
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
                    <td><?=  ($livro['id']) ?></td>
                    <td><?=  ($livro['nome']) ?></td>
                    <td><?=  ($livro['genero']) ?></td>
                    <td><?=  ($livro['ano']) ?></td>
                    <td><?=  ($livro['autor']) ?></td>
                    <td><?=  ($livro['classificacao']) ?></td>
                    <td>
                        <a href="excluir.php?id=<?= $livro['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir?')" style="color: red;">
                            Excluir
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>
</html>
