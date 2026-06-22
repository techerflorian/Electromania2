--
-- base de données: 'electromania'
--
create database if not exists electromania default character set utf8 collate utf8_general_ci;
use electromania;
-- --------------------------------------------------------
-- creation des tables

set foreign_key_checks =0;

-- table utilisateur
drop table if exists utilisateur;
create table utilisateur (
	uti_id int not null auto_increment primary key,
    uti_nom varchar(100) not null,
	uti_prenom varchar(100) not null,
	uti_adresse varchar(100) not null,
    uti_email varchar(100) not null,
    uti_numero_telephone varchar(100) not null,
    uti_mdp varchar(200) not null,
    uti_profil int not null
)engine=innodb;

-- table profil
drop table if exists profil;
create table profil (
	pro_id int not null auto_increment primary key,
	pro_nom varchar(100) not null
)engine=innodb;

-- table article
drop table if exists article;
create table article (
	art_id int not null auto_increment primary key,
	art_nom varchar(100) not null,
    art_prix float not null,
    art_description varchar(1000) not null,
    art_categorie int not null
)engine=innodb;

-- table categorie
drop table if exists categorie;
create table categorie (
	cat_id int not null auto_increment primary key,
	cat_libelle varchar(100) not null
)engine=innodb;

-- table statut
drop table if exists statut;
create table statut (
	sta_id int not null auto_increment primary key,
	sta_nom varchar(50) not null
)engine=innodb; 


-- table commande
drop table if exists commande;
create table commande (
	com_id int not null auto_increment primary key,
	com_date datetime not null,
	com_statut varchar(50) not null,
	com_utilisateur int not null
)engine=innodb; 


-- table contenir
drop table if exists contenir;
create table contenir (
	con_id int not null auto_increment primary key,
	con_quantite int not null,
    con_commande int not null,
	con_article int not null
)engine=innodb;


set foreign_key_checks =1;

-- contraintes
alter table utilisateur add constraint cs1 foreign key (uti_profil) references profil(pro_id);
alter table article add constraint cs2 foreign key (art_categorie) references categorie(cat_id);
alter table contenir add constraint cs5 foreign key (con_commande) references commande(com_id);
alter table contenir add constraint cs6 foreign key (con_article) references article(art_id);


