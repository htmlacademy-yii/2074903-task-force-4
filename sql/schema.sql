DROP DATABASE IF EXISTS taskForce;

CREATE DATABASE taskForce
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE taskForce;

CREATE TABLE users (
  /* How I catched we shouldn't use auto increment and we should create ID
  before inserting any data to the table. Right? */
  id INT NOT NULL /*AUTO_INCREMENT*/ PRIMARY KEY,
  dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  email VARCHAR(128) NOT NULL UNIQUE,
  name VARCHAR(255) NOT NULL,
  password CHAR(255) NOT NULL,
  role VARCHAR(255) NOT NULL,
  city VARCHAR(128) NOT NULL,
  coordinate POINT NOT NULL
);

CREATE TABLE executorProfiles (
  executor_id INT NOT NULL PRIMARY KEY,
  FOREIGN KEY (executor_id) REFERENCES users(id),
  avatar VARCHAR(255) DEFAULT NULL,
  birth_dt TIMESTAMP DEFAULT NULL,
  phone CHAR(255) DEFAULT NULL,
  telegram VARCHAR(255) DEFAULT NULL,
  bio TEXT DEFAULT NULL,
  executor_status VARCHAR(255)
);

CREATE TABLE categories (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255)/*,
  eng_name VARCHAR(255)*/
);

CREATE TABLE executorCategories (
  PRIMARY KEY (category_id, executor_id),
  category_id INT,
  FOREIGN KEY (category_id) REFERENCES categories(id)
  executor_id INT,
  FOREIGN KEY (executor_id) REFERENCES users(id)
);

CREATE TABLE tasks (
  id INT NOT NULL /*AUTO_INCREMENT*/ PRIMARY KEY,
  dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  expiry_date TIMESTAMP NOT NULL,
  budget INT NOT NULL,
  client_id INT,
  FOREIGN KEY (client_id) REFERENCES users(id),
  executor_id INT,
  FOREIGN KEY (executor_id) REFERENCES users(id),
  category_id INT,
  FOREIGN KEY (category_id) REFERENCES categories(id)
  coordinate POINT NOT NULL,
  task_status VARCHAR(255)
);

CREATE TABLE files (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255)
);

CREATE TABLE taskFiles (
  PRIMARY KEY (file_id, task_id),
  file_id INT,
  FOREIGN KEY (file_id) REFERENCES files(id)
  task_id INT,
  FOREIGN KEY (task_id) REFERENCES tasks(id)
);

CREATE TABLE responds (
  PRIMARY KEY (task_id, executor_id),
  task_id INT,
  FOREIGN KEY (task_id) REFERENCES tasks(id),
  executor_id INT,
  FOREIGN KEY (executor_id) REFERENCES users(id),
  dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  price INT NOT NULL,
  comment TEXT
);

CREATE TABLE reviews (
  PRIMARY KEY (task_id, executor_id),
  task_id INT,
  FOREIGN KEY (task_id) REFERENCES tasks(id),
  executor_id INT,
  FOREIGN KEY (executor_id) REFERENCES users(id),
  client_id INT,
  FOREIGN KEY (client_id) REFERENCES users(id),
  score INT,
  comment TEXT,
  dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  success BOOLEAN
);

CREATE INDEX t_name ON tasks(name);
CREATE INDEX c_name ON categories(name);
