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
	name varchar(100),
	description varchar(400),
	teacher_id int not null,
	status enum('Draft','Pending','Accepted','Finished','Cancelled','Rejected') not null default 'Draft',
	constraint pk_project_id primary key (project_id),
	constraint fk_project_teacher foreign key (teacher_id) references users(user_id)
);

create table project_student (
	project_id int not null,
	student_id int not null,
	accepted boolean not null default false,
	manager boolean not null default false,
	constraint pk_project_student primary key (project_id,student_id),
	constraint fk_project_student_project_id foreign key (project_id) references projects(project_id),
	constraint fk_project_student_user_id foreign key (student_id) references users(user_id)
);

create table messages (
	message_id int not null auto_increment,
	project_id int not null,
	from_id int not null,
	message varchar(100) not null,
	constraint pk_message primary key (message_id),
	constraint fk_message_project foreign key (project_id) references projects(project_id),
	constraint fk_message_from foreign key (from_id) references users(user_id)
);

create table private_message (
	pm_id int not null auto_increment,
	from_id int not null,
	to_id int not null,
	subject varchar(100) not null,
	content varchar(400) not null,
	constraint pk_pm primary key (pm_id),
	constraint fk_pm_from foreign key (from_id) references users(user_id),
	constraint fk_pm_to foreign key (to_id) references users(user_id)
);

insert into users (account_activated, login, name, hash, account_type, email) values (true, 'admin', 'Administrador','$2y$10$QR.sNaP9wHh/Ofiti9Ml6.ncfzKnnt0fIHukHAoahwpxPxTWyTDnK', 'Admin', 'ricolvs123@gmail.com');
