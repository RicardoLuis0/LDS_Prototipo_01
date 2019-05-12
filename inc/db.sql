drop database if exists lds_project;

create database lds_project;

use lds_project;

create table users (
	id int not null auto_increment,
	account_activated boolean not null,
	login varchar(60) not null,
	name varchar(120) not null,
	hash char(60) not null,
	account_type enum('Admin','Student','Teacher') not null,
	email varchar(120) not null,
	constraint pk_id primary key (id),
	constraint uk_login unique (login)
);

insert into users (account_activated, login, name, hash, account_type, email) values (true, 'admin', 'Administrador','$2y$10$QR.sNaP9wHh/Ofiti9Ml6.ncfzKnnt0fIHukHAoahwpxPxTWyTDnK', 'Admin', 'ricolvs123@gmail.com');
