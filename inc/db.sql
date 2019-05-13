drop database if exists lds_project;

create database lds_project;

use lds_project;

create table users (
	user_id int not null auto_increment,
	account_activated boolean not null default false,
	login varchar(60) not null,
	name varchar(120) not null,
	hash char(60) not null,
	account_type enum('Admin','Student','Teacher') not null,
	email varchar(120) not null,
	constraint pk_user_id primary key (user_id),
	constraint uk_login unique (login)
);

create table projects (
	project_id int not null auto_increment,
	constraint pk_project_id primary key (project_id)
);

create table projects_users (
	project_id int not null,
	user_id int not null,
	accepted boolean not null default false,
	constraint pk_projects_users primary key (project_id,user_id),
	constraint fk_project_id foreign key (project_id) references projects(project_id),
	constraint fk_user_id foreign key (user_id) references users(user_id)
);

insert into users (account_activated, login, name, hash, account_type, email) values (true, 'admin', 'Administrador','$2y$10$QR.sNaP9wHh/Ofiti9Ml6.ncfzKnnt0fIHukHAoahwpxPxTWyTDnK', 'Admin', 'ricolvs123@gmail.com');
