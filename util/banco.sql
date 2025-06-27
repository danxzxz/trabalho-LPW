CREATE DATABASE biblioteca;

USE biblioteca;

CREATE TABLE  livros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    autor VARCHAR(255) NOT NULL,
    ano INT NOT NULL,
    genero VARCHAR(50) NOT NULL,
    classificacao VARCHAR(50) NOT NULL,
    sinopse TEXT NOT NULL,
    link TEXT NOT NULL,
    data_cadastro CHAR(4)
);


