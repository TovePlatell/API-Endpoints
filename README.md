# How to use

v1/Users/createUsers -> Have to create an account \
v1/sessions/session -> To login \
A token is created after logged in -> use token in a logged-in stage to get access to \

users -> updateUser, deleteUser \
products -> need to ne logged in as an admin to acess createProducts, updateProduct, deleteProducs \
carts -> addItemCart, deleteItemCart, showAllCartItem \

INCLUDING sessionhelper to see if token expired or not, if 30 min remains while logged in - expire time updates \
Endpoints holds all the errors and messages \
Json encode is included in all endpoints through the function Send in Statues. \

## ErrorCodes from https://httpstatuses.com/

200 -  OK   \
201 - Created \
401 - Unauthorized //  Log in   \
409 - Conflicts // not a valid token  \
405 - Method Not Found \
500 - Internal Server Error \

### Database

DROP DATABASE IF EXISTS Ecommerce; CREATE DATABASE Ecommerce; DROP TABLE IF EXISTS cart; DROP DATABASE IF EXISTS products; DROP DATABASE IF EXISTS users; CREATE TABLE users(user_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, user_name VARCHAR(50) NOT NULL, user_password VARCHAR(50) NOT NULL, user_email VARCHAR(100)) ENGINE = INNODB; CREATE TABLE products(product_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, product_name VARCHAR(50) NOT NULL, product_desc VARCHAR(500) NOT NULL, price INT) ENGINE = INNODB; CREATE TABLE cart(cart_id INT NOT NULL PRIMARY KEY AUTO_INCREMENT, product_id INT NOT NULL, CONSTRAINT FKproductsId FOREIGN KEY(product_id) REFERENCES products(product_id)) ENGINE = INNODB;
