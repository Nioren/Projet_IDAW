/*==============================================================*/
/* Nom de SGBD :  MySQL 8.x                                     */
/* Date de cr�ation :  10/11/2023 16:11:51                      */
/*==============================================================*/


-- Utilisation de la base de donn�es nouvellement cr��e
USE bddidaw;

/*==============================================================*/
/* Table : MANGER_PLAT                                          */
/*==============================================================*/
create table MANGER_PLAT
(
   ID_PLAT              int not null  comment '',
   ID_USER              int not null  comment '',
   QUANTITE             int  comment '',
   DATE                 date  comment '',
   ID_REPAS             int not null AUTO_INCREMENT comment '',
   primary key (ID_REPAS)
);

/*==============================================================*/
/* Table : PLAT                                                 */
/*==============================================================*/
create table PLAT
(
   ID_PLAT              int not null AUTO_INCREMENT comment '',
   NOM_PLAT             char(20) not null  comment '',
   NUTRIMENTS           text not null  comment '',
   IMAGE                text  comment '',
   primary key (ID_PLAT)
);

/*==============================================================*/
/* Index : PLAT_NOM_PLAT                                        */
/*==============================================================*/
create index PLAT_NOM_PLAT on PLAT
(
   NOM_PLAT
);

/*==============================================================*/
/* Table : UTILISATEUR                                          */
/*==============================================================*/
create table UTILISATEUR
(
   ID_USER              int not null AUTO_INCREMENT comment '',
   AGE                  int  comment '',
   SPORT                char(20)  comment '',
   NOM_UTILISATEUR      char(20)  comment '',
   MOT_DE_PASSE         char(20)  comment '',
   primary key (ID_USER)
);

/*==============================================================*/
/* Index : UTILISATEUR_NOM_UTILISATEUR                          */
/*==============================================================*/
create index UTILISATEUR_NOM_UTILISATEUR on UTILISATEUR
(
   NOM_UTILISATEUR
);

alter table MANGER_PLAT add constraint FK_MANGER_P_MANGER_PL_PLAT foreign key (ID_PLAT)
      references PLAT (ID_PLAT) on delete restrict on update restrict;

alter table MANGER_PLAT add constraint FK_MANGER_P_MANGER_PL_UTILISAT foreign key (ID_USER)
      references UTILISATEUR (ID_USER) on delete restrict on update restrict;

