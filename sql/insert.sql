INSERT INTO OrderStatus (STATUS_ID, STATUS) VALUES (1000, 'PENDING');
INSERT INTO OrderStatus (STATUS_ID, STATUS) VALUES (2000, 'CONFIRMED');
INSERT INTO OrderStatus (STATUS_ID, STATUS) VALUES (3000, 'CANCELED');
INSERT INTO OrderStatus (STATUS_ID, STATUS) VALUES (4000, 'REMOVED');

INSERT INTO UserType (TYPE_ID, TYPE) VALUES (1000, 'ADMIN');
INSERT INTO UserType (TYPE_ID, TYPE) VALUES (2000, 'SELLER');
INSERT INTO UserType (TYPE_ID, TYPE) VALUES (3000, 'CUSTOMER');
INSERT INTO UserType (TYPE_ID, TYPE) VALUES (4000, 'UNACTIVE');

INSERT INTO PostalCode (POSTAL_CODE, CITY)
VALUES
    (1000, 'Ljubljana'),
    (2000, 'Maribor'),
    (3000, 'Celje');
    
INSERT INTO StoreUser (POSTAL_CODE, TYPE_ID, NAME, SURNAME, EMAIL, HASH, STREET, HOUSE_NUMBER, ACTIVE)
VALUES (null, 1000, 'Admin', 'Admin', 'admin@epLabNaloga.com', '$2y$10$6A.nfHu3zYj6zR00ce8QV.eKqUAL5oErJrQguoU.imcf/eFH2SzVq', null, null, 1),
 (null, 2000, 'Prodajalec', 'Tilen', 'prodajalec@epLabNaloga.com', '$2y$10$6A.nfHu3zYj6zR00ce8QV.eKqUAL5oErJrQguoU.imcf/eFH2SzVq', null, null, 1),
 (1000, 3000, 'Tilen', 'Anzeljc', 'tilen.anzeljc@gmail.com', '$2y$10$6A.nfHu3zYj6zR00ce8QV.eKqUAL5oErJrQguoU.imcf/eFH2SzVq', 'Mali Log', '21a', 1);
    
    
INSERT INTO Item (ITEM_NAME, PRICE, ACTIVE, DESCRIPTION)
VALUES ('Product A', 19.99, 1, 'Description for Product A');

INSERT INTO Item (ITEM_NAME, PRICE, ACTIVE, DESCRIPTION)
VALUES ('Product B', 29.99, 1, 'Description for Product B');

INSERT INTO Item (ITEM_NAME, PRICE, ACTIVE, DESCRIPTION)
VALUES ('Product C', 39.99, 1, 'Description for Product C');
    

    
