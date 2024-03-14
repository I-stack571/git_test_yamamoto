CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT '商品ID',
    name VARCHAR(255) NOT NULL COMMENT '商品名',
    image_url VARCHAR(255) NULL COMMENT '商品画像URL'
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY COMMENT '注文ID',
    customer_name VARCHAR(255) NOT NULL COMMENT '注文者氏名',
    customer_address TEXT NOT NULL COMMENT '注文者住所',
    order_date TIMESTAMP NOT NULL COMMENT '注文者日時',
    is_cancelled BOOLEAN NOT NULL DEFAULT 0 COMMENT 'キャンセルフラグ'
);

CREATE TABLE order_items (
    order_id INT COMMENT '注文ID',
    product_id INT COMMENT '商品ID',
    quantity INT COMMENT '個数',
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO products (name, image_url) 
VALUES 
('クリームチーズベーグル', './images/product2.png'),
('ミートソースベーグル', './images/product1.png')