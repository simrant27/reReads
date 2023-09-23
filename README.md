## Database for users
->create table users(user_id int AUTO_INCREMENT PRIMARY KEY,fullName VARCHAR(100) NOT NULL,email VARCHAR(100) NOT NULL UNIQUE, address varchar(100) NOT NULL,password varchar(255) NOT NULL, phoneNo varchar(15) NOT NULL ,user_img blob,verify_email INT UNIQUE,code INT UNIQUE);
