create database if not exists db_ordemservico;

-- drop database db_ordemservico; --


use db_ordemservico;

create table if not exists tb_usuario (
usuario_id int auto_increment,
nome varchar (100) not null,
email varchar (100) not null,
senha varchar (255) not null,

primary key (usuario_id)
); 

create table if not exists tb_empresa_responsavel (
empresa_id int auto_increment,
nome_fantasia varchar (100) not null,
cnpj varchar (30) not null,
email varchar (100) not null,
telefone varchar(15) not null,

primary key (empresa_id),
unique (cnpj)
);

create table if not exists tb_cliente (
cliente_id int auto_increment,
nome varchar (100) not null, 
cpf_cnpj varchar (20) not null,
telefone varchar (15) not null,
email varchar (100),

primary key (cliente_id)
);

create table if not exists tb_ativo (
ativo_id int auto_increment,
nome varchar (100) not null,
marca varchar (30) not null,
modelo varchar (30) not null,
patrimonio varchar (30) not null,
cliente_id int not null,

primary key (ativo_id),
foreign key (cliente_id) references tb_cliente (cliente_id),
unique (patrimonio)
);

create table if not exists tb_ordem_servico (
os_id int auto_increment,
empresa_id int not null,
cliente_id int not null,
ativo_id int not null,
situacao enum ("Pendente", "Finalizada") not null default ("Pendente"),
data_chegada date not null,
data_saida date,
servico text,
valor decimal (10, 2) not null,


primary key (os_id),
foreign key (cliente_id) references tb_cliente (cliente_id),
foreign key (empresa_id) references tb_empresa_responsavel (empresa_id),
foreign key (ativo_id) references tb_ativo (ativo_id) ON UPDATE CASCADE
);


CREATE TABLE if not exists tb_image_ativo (
image_id int auto_increment,
nome varchar(255) not null,
caminho varchar(255) not null,
data_upload datetime DEFAULT current_timestamp,
ativo_id int,

primary key (image_id),
foreign key (ativo_id) references tb_ativo (ativo_id) ON DELETE CASCADE ON UPDATE CASCADE 

);

CREATE TABLE if not exists tb_endereco (
endereco_id int auto_increment,
endereco varchar (100) not null, 
bairro varchar (100) not null,
cidade varchar (100)  not null,
cep varchar (9) not null,
uf varchar (2) not null,
cliente_id int not null,

primary key (endereco_id),
foreign key (cliente_id) references tb_cliente (cliente_id) ON DELETE CASCADE ON UPDATE CASCADE 
);

CREATE INDEX idx_cliente_id ON tb_ordem_servico (cliente_id);
CREATE INDEX idx_ativo_id ON tb_ordem_servico (ativo_id);


