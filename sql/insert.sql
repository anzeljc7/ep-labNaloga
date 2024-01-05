INSERT INTO OrderStatus (STATUS_ID, STATUS) VALUES (1000, 'PENDING');
INSERT INTO OrderStatus (STATUS_ID, STATUS) VALUES (2000, 'CONFIRMED');
INSERT INTO OrderStatus (STATUS_ID, STATUS) VALUES (3000, 'CANCELED');
INSERT INTO OrderStatus (STATUS_ID, STATUS) VALUES (4000, 'REMOVED');

INSERT INTO UserType (TYPE_ID, TYPE) VALUES (1000, 'ADMIN');
INSERT INTO UserType (TYPE_ID, TYPE) VALUES (2000, 'SELLER');
INSERT INTO UserType (TYPE_ID, TYPE) VALUES (3000, 'CUSTOMER');
INSERT INTO UserType (TYPE_ID, TYPE) VALUES (4000, 'PENDING');

INSERT INTO PostalCode (POSTAL_CODE, CITY)
VALUES
    (1000, 'Ljubljana'),
    (2000, 'Maribor'),
    (3000, 'Celje');
    
INSERT INTO Address (POSTAL_CODE, STREET, HOUSE_NUMBER)
VALUES
    (1000, 'Main Street', 123),
    (2000, 'Broadway Avenue', 456),
    (3000, 'Oak Street', 789);
    
INSERT INTO StoreUser (TYPE_ID, ADDRESS_ID, NAME, SURNAME, EMAIL, HASH, SALT, ACTIVE)
VALUES(2000, 1, 'John', 'Doe', 'john.doe@example.com', 'hashed_password', 'salt_value', 1),
	(2000, 1, 'Jane', 'Smith', 'jane.smith@example.com', 'hashed_password_2', 'salt_value_2', 1);
    
    
INSERT INTO Item (ITEM_NAME, PRICE, ACTIVE, DESCRIPTION)
VALUES ('Product A', 19.99, 1, 'Description for Product A');

INSERT INTO Item (ITEM_NAME, PRICE, ACTIVE, DESCRIPTION)
VALUES ('Product B', 29.99, 1, 'Description for Product B');

INSERT INTO Item (ITEM_NAME, PRICE, ACTIVE, DESCRIPTION)
VALUES ('Product C', 39.99, 1, 'Description for Product C');
    

    
