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
 (null, 1000, 'Admin', 'Admin', 'admin@ep.si', '$2y$10$6A.nfHu3zYj6zR00ce8QV.eKqUAL5oErJrQguoU.imcf/eFH2SzVq', null, null, 1),
 (null, 2000, 'Nejc', 'Arh', 'nejc@ep.si', '$2y$10$6A.nfHu3zYj6zR00ce8QV.eKqUAL5oErJrQguoU.imcf/eFH2SzVq', null, null, 1),
 (null, 2000, 'Tilen', 'Stefancic', 'tilen@ep.si', '$2y$10$6A.nfHu3zYj6zR00ce8QV.eKqUAL5oErJrQguoU.imcf/eFH2SzVq', null, null, 1),
 (1000, 3000, 'Tilen', 'Anzeljc', 'tilen.anzeljc7@gmail.com', '$2y$10$6A.nfHu3zYj6zR00ce8QV.eKqUAL5oErJrQguoU.imcf/eFH2SzVq', 'Tavčarjeva', '31c', 1),
 (6230, 3000, 'Tjas', 'Ajdovec', 'tjas.ajdovec@gmail.com', '$2y$10$6A.nfHu3zYj6zR00ce8QV.eKqUAL5oErJrQguoU.imcf/eFH2SzVq', 'Kosovelova ulica', '1', 1);
    
    
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
    (2, "im4.jpeg"),
    (3, "im5.jpg"),
    (4, "im6.jpg"),
    (5, "im7.jpg");

    
    
