/*==============================================================*/
/* DBMS name:      MySQL 5.0                                    */
/* Created on:     6. 01. 2024 09:41:57                         */
/*==============================================================*/

drop table if exists ItemImage;
drop table if exists OrderItem;
drop table if exists Item;
drop table if exists UserOrder;
drop table if exists StoreUser;
drop table if exists PostalCode;
drop table if exists OrderStatus;
drop table if exists UserType;

/*==============================================================*/
/* Table: Item                                                  */
/*==============================================================*/
create table Item
(
   ITEM_ID              int auto_increment not null,
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
   IMAGE_ITEM_ID        int auto_increment not null,
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
   USER_ID              int auto_increment not null,
   POSTAL_CODE          int,
   TYPE_ID              int not null,
   NAME                 varchar(100) not null,
   SURNAME              varchar(100) not null,
   EMAIL                national varchar(100) not null,
   HASH                 varchar(255) not null,
   STREET               varchar(255),
   HOUSE_NUMBER         varchar(5),
   ACTIVE               bool not null,
   primary key (USER_ID)
);

/*==============================================================*/
/* Table: UserOrder                                             */
/*==============================================================*/
create table UserOrder
(
   ORDER_ID             int auto_increment not null,
   USER_ID              int not null,
   STATUS_ID            int not null,
   ORDER_DATE           datetime not null,
   TOTAL                float not null,
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

alter table ItemImage add constraint FK_Relationship_9 foreign key (ITEM_ID)
      references Item (ITEM_ID) on delete restrict on update restrict;

alter table OrderItem add constraint FK_Relationship_7 foreign key (ORDER_ID)
      references UserOrder (ORDER_ID) on delete restrict on update restrict;

alter table OrderItem add constraint FK_Relationship_8 foreign key (ITEM_ID)
      references Item (ITEM_ID) on delete restrict on update restrict;

alter table StoreUser add constraint FK_Relationship_10 foreign key (POSTAL_CODE)
      references PostalCode (POSTAL_CODE) on delete restrict on update restrict;

alter table StoreUser add constraint FK_Relationship_2 foreign key (TYPE_ID)
      references UserType (TYPE_ID) on delete restrict on update restrict;

alter table UserOrder add constraint FK_Relationship_3 foreign key (USER_ID)
      references StoreUser (USER_ID) on delete restrict on update restrict;

alter table UserOrder add constraint FK_Relationship_4 foreign key (STATUS_ID)
      references OrderStatus (STATUS_ID) on delete restrict on update restrict;
      
      
INSERT INTO OrderStatus (STATUS_ID, STATUS) VALUES (1000, 'PENDING');
INSERT INTO OrderStatus (STATUS_ID, STATUS) VALUES (2000, 'CONFIRMED');
INSERT INTO OrderStatus (STATUS_ID, STATUS) VALUES (3000, 'CANCELED');
INSERT INTO OrderStatus (STATUS_ID, STATUS) VALUES (4000, 'REMOVED');

INSERT INTO UserType (TYPE_ID, TYPE) VALUES (1000, 'ADMIN');
INSERT INTO UserType (TYPE_ID, TYPE) VALUES (2000, 'SELLER');
INSERT INTO UserType (TYPE_ID, TYPE) VALUES (3000, 'CUSTOMER');

INSERT INTO PostalCode (POSTAL_CODE, CITY)
VALUES
    (1000, 'Ljubljana'),
    (2000, 'Maribor'),
    (1310, 'Ribnica'),
    (6230, 'Postojna'),
    (3000, 'Celje');
    
INSERT INTO StoreUser (POSTAL_CODE, TYPE_ID, NAME, SURNAME, EMAIL, HASH, STREET, HOUSE_NUMBER, ACTIVE)
VALUES 
 (null, 1000, 'Admin', 'Admin', 'admin@ep.si', '$2y$10$9Xauayl7hInYvQkgQgD3Eu7JFeMBNKGHSh57QUJawx/Sc8t/eyo6y', null, null, 1),
 (null, 2000, 'Nejc', 'Arhar', 'nejc@ep.si', '$2y$10$9Xauayl7hInYvQkgQgD3Eu7JFeMBNKGHSh57QUJawx/Sc8t/eyo6y', null, null, 1),
 (null, 2000, 'Tilen', 'Stefancic', 'tilen@ep.si', '$2y$10$9Xauayl7hInYvQkgQgD3Eu7JFeMBNKGHSh57QUJawx/Sc8t/eyo6y', null, null, 1),
 (1000, 3000, 'Tilen', 'Anzeljc', 'tilen.anzeljc7@gmail.com', '$2y$10$9Xauayl7hInYvQkgQgD3Eu7JFeMBNKGHSh57QUJawx/Sc8t/eyo6y', 'Tavčarjeva', '31c', 1),
 (6230, 3000, 'Tjas', 'Ajdovski', 'tjas.ajdovec@gmail.com', '$2y$10$9Xauayl7hInYvQkgQgD3Eu7JFeMBNKGHSh57QUJawx/Sc8t/eyo6y', 'Kosovelova ulica', '1', 1);
    
    
INSERT INTO Item (ITEM_NAME, PRICE, ACTIVE, DESCRIPTION)
VALUES
    ('Smartphone X', 599.99, 1, 'High-end smartphone with advanced features.'),
    ('Laptop Pro', 1299.99, 1, 'Powerful laptop for professional use.'),
    ('Wireless Earbuds', 79.99, 1, 'Bluetooth earbuds with noise cancellation.'),
    ('Fitness Tracker', 49.99, 1, 'Track your daily activities and fitness goals.'),
    ('Coffee Maker Deluxe', 129.99, 1, 'Premium coffee maker with multiple brewing options.'),
    ('HD Smart TV', 799.99, 1, 'High-definition smart TV with streaming capabilities.');
    
INSERT INTO UserOrder (USER_ID, STATUS_ID, ORDER_DATE, TOTAL)
VALUES
    (4, 1000, '2024-01-15', 699.97),
    (4, 2000, '2023-01-01', 1299.99),
    (4, 2000, '2022-01-03', 799.99),
    (4, 3000, '2022-01-04', 3199.96);
    
INSERT INTO OrderItem(ORDER_ID, ITEM_ID, QUANTITY)
VALUES
	(1, 1, 1),
    (1, 3, 2),
    (2, 2, 1),
    (3, 6, 1),
    (4, 6, 3);
    
INSERT INTO ItemImage(ITEM_ID, IMAGE_PATH)
VALUES
	(1, "im1.jpeg"),
    (1, "im2.jpg"),
    (1, "im3.jpg"),
    (2, "im4.jpg"),
    (3, "im5.jpg"),
    (4, "im6.jpg"),
    (5, "im7.jpg");

    
    
