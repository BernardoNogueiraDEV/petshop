create DATABASE petshop;
USE petshop;
create table usuarios
(
    id int auto_increment primary key,
    nome varchar(100) not null,
    email varchar(100) not null,
    cpf varchar(11) not null,
    telefone varchar(11) not null,
    cep varchar(20) not null,
    rua varchar(100) not null,
    numero int not null,
    bairro varchar(100) not null,
    cidade varchar(100) not null,
    estado varchar(100) not null,
    senha varchar(100) not null,
    profile_photo longblob,
    cover_photo longblob,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(cpf)
);
SELECT * FROM usuarios;
DESCRIBE usuarios profile_photo;
ALTER TABLE usuarios
  MODIFY profile_photo LONGBLOB
  NULL DEFAULT NULL;
  
  ALTER TABLE usuarios
  MODIFY cover_photo MEDIUMBLOB
  NULL DEFAULT NULL;



DROP TABLE usuarios;

TRUNCATE TABLE usuarios;

create table pets
(
    id_pet int auto_increment primary key,
    nomePet varchar(100) not null,
    tipoPet varchar(100) not null,
    idadePet int not null,
    racaPet varchar(100) not null,
    nascimentoPet date not null,
    observacoesPet varchar(255) not null,
    cpf varchar(11),
    id_usuario int,
    foreign key(id_usuario) references usuarios(id)
);

create table carrinho
(
    id int auto_increment primary key,
    produto varchar(100) not null,
    preco decimal(10, 2) not null,
    quantidade int not null,
    id_usuario int,
    foreign key(id_usuario) references usuarios(id)
);
SELECT * FROM carrinho;

SELECT * FROM pets;
TRUNCATE TABLE pets;