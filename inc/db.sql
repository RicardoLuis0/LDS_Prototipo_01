drop database lds_project if exists;

create database lds_project;

use lds_project;

create table users (
	id int not null,
	login varchar(60) not null,
	name varchar(120) not null,
	email varchar(120) not null,
	hash char(60) not null,
	account_activated boolean not null,
	account_type enum('Admin','Student','Teacher') not null,
	constraint pk_id primary key (id),
	constraint uk_login unique (login),
);