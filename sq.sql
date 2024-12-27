create database agency ;

use agency;
    create table role (
     id int primary key auto_increment ,
     role_name varchar (100)
        );
        insert into role (id ,role_name) values ('1','admin'),('2','client');

 create table utilisateur (
     id int primary key auto_increment ,
     name varchar (100),
     email varchar (100),
        password varchar (100),
        id_role int (100),
        foreign key (id_role) references role(id)
        );


    
        


         CREATE TABLE Activities (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    type ENUM('flight', 'hotel', 'tour') NOT NULL,
    location VARCHAR(255),
    price DECIMAL(10, 2) NOT NULL,
    availability_status ENUM('available', 'unavailable') NOT NULL,
    image_url VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



             CREATE TABLE Reservations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        utilisateur INT NOT NULL,
        activities INT NOT NULL,
        reservation_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        status ENUM('confirmed', 'pending', 'cancelled') NOT NULL,
        total_price DECIMAL(10, 2) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (utilisateur) REFERENCES utilisateur(id),
        FOREIGN KEY (activities) REFERENCES activities(id)
    );


    insert into utilisateur(name,email,password,id_role)
    values("ichrak","ichrak@gmail.com","4321",2);

    insert into utilisateur(name,email,password,id_role)
    values("mohamed","mohamed@gmail.com","1234",1);

    INSERT INTO role (id ,role_name) values ('3','superadmin');


    