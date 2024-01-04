/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     4. 01. 2024 12:20:01                         */
/*==============================================================*/


drop table if exists ItemImage;
drop table if exists OrderItem;
drop table if exists Item;
drop table if exists UserOrder;
drop table if exists StoreUser;
drop table if exists Address;
drop table if exists PostalCode;
drop table if exists OrderStatus;
drop table if exists UserType;



/*==============================================================*/
/* Table: Address                                               */
/*==============================================================*/
create table Address
(
   ADDRESS_ID           int not null,
   POSTAL_CODE          int not null,
   STREET               varchar(255) not null,
   HOUSE_NUMBER         int not null,
   primary key (ADDRESS_ID)
);

/*==============================================================*/
/* Table: Item                                                  */
/*==============================================================*/
create table Item
(
   ITEM_ID              int not null,
   ITEM_NAME            varchar(255) not null,
   PRICE                float not null,
   ACTIVE               bool not null,
   DESCRIPTION          varchar(512),
   primary key (ITEM_ID)
);

/*==============================================================*/
/* Table: ItemImage                                             */
/*==============================================================*/
create table ItemImage
(
   IMAGE_ITEM_ID        int not null,
   ITEM_ID              int not null,
   IMAGE_PATH           varchar(255) not null,
   primary key (IMAGE_ITEM_ID)
);

/*==============================================================*/
/* Table: OrderItem                                             */
/*==============================================================*/
create table OrderItem
(
   ORDER_ID             int not null,
   ITEM_ID              int not null,
   QUANTITY             int not null,
   primary key (ORDER_ID, ITEM_ID)
);

/*==============================================================*/
/* Table: OrderStatus                                           */
/*==============================================================*/
create table OrderStatus
(
   STATUS_ID            int not null,
   STATUS               national varchar(50) not null,
   primary key (STATUS_ID)
);

/*==============================================================*/
/* Table: PostalCode                                            */
/*==============================================================*/
create table PostalCode
(
   POSTAL_CODE          int not null,
   CITY                 varchar(255) not null,
   primary key (POSTAL_CODE)
);

/*==============================================================*/
/* Table: StoreUser                                             */
/*==============================================================*/
create table StoreUser
(
   USER_ID              int not null,
   TYPE_ID              int not null,
   ADDRESS_ID           int,
   NAME                 varchar(100) not null,
   SURNAME              varchar(100) not null,
   EMAIL                national varchar(100) not null,
   HASH                 varchar(255) not null,
   SALT                 varchar(255) not null,
   ACTIVE               bool not null,
   primary key (USER_ID)
);

/*==============================================================*/
/* Table: UserOrder                                             */
/*==============================================================*/
create table UserOrder
(
   ORDER_ID             int not null,
   USER_ID              int not null,
   STATUS_ID            int not null,
   ORDER_DATE           datetime not null,
   primary key (ORDER_ID)
);

/*==============================================================*/
/* Table: UserType                                              */
/*==============================================================*/
create table UserType
(
   TYPE_ID              int not null,
   TYPE                 varchar(50) not null,
   primary key (TYPE_ID)
);

alter table Address add constraint FK_Relationship_1 foreign key (POSTAL_CODE)
      references PostalCode (POSTAL_CODE) on delete restrict on update restrict;

alter table ItemImage add constraint FK_Relationship_9 foreign key (ITEM_ID)
      references Item (ITEM_ID) on delete restrict on update restrict;

alter table OrderItem add constraint FK_Relationship_7 foreign key (ORDER_ID)
      references UserOrder (ORDER_ID) on delete restrict on update restrict;

alter table OrderItem add constraint FK_Relationship_8 foreign key (ITEM_ID)
      references Item (ITEM_ID) on delete restrict on update restrict;

alter table StoreUser add constraint FK_Relationship_2 foreign key (TYPE_ID)
      references UserType (TYPE_ID) on delete restrict on update restrict;

alter table StoreUser add constraint FK_Relationship_6 foreign key (ADDRESS_ID)
      references Address (ADDRESS_ID) on delete restrict on update restrict;

alter table UserOrder add constraint FK_Relationship_3 foreign key (USER_ID)
      references StoreUser (USER_ID) on delete restrict on update restrict;

alter table UserOrder add constraint FK_Relationship_4 foreign key (STATUS_ID)
      references OrderStatus (STATUS_ID) on delete restrict on update restrict;

