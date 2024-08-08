# phptest
Php test yayasan peneraju


1) Database Setup

Create a database and table to store survey response

Database :

CREATE DATABASE feedback_survey;

Table:

CREATE TABLE feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    age INT,
    document VARCHAR(255),
    feedback_type ENUM('positive', 'negative'),
    services SET('service1', 'service2', 'service3'),
    comments TEXT
);

2) PHP Form Creation
-index.php

3) Edit Page

Create an edit page ('edit.php) to handle updating records.
-edit.php
