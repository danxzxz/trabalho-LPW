<?php

class Conexao {
    private static $conn = null;

    public static function getConexao(){
        if(self::$conn == null){
            $opcoes = array(
                // Define o charset da conexão
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                // Define o tipo do erro como exceção
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                // Define o tipo do retorno das consultas
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            );

            try {
                self::$conn = new PDO("mysql:host=localhost:3306;dbname=biblioteca","root", "", $opcoes);
                // echo "Conexão estabelecida com sucesso!"; // mensagem de sucesso
            } catch (PDOException $e) {
                die("Erro de conexão: " . $e->getMessage());
            }
        }
        return self::$conn;
    }
}

//Conexao::getConexao(); // Chama o método estático diretamente na classe

