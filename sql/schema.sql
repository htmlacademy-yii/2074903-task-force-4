DROP DATABASE IF EXISTS taskForce;

CREATE DATABASE taskForce
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;

USE taskForce;

CREATE TABLE users (
  uuid INT NOT NULL PRIMARY KEY,
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
  avatar VARCHAR(255),
  birth_dt TIMESTAMP,
  phone CHAR(255),
  telegram VARCHAR(255),
  bio TEXT,
  executor_status VARCHAR(255)
);

CREATE TABLE categories (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255)
);

CREATE TABLE executorCategories (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  category_id INT NOT NULL,
  FOREIGN KEY (category_id) REFERENCES categories(id),
  executor_id INT NOT NULL,
  FOREIGN KEY (executor_id) REFERENCES users(id)
);

CREATE TABLE tasks (
  uuid INT NOT NULL PRIMARY KEY,
  dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  name VARCHAR(255) NOT NULL,
  description TEXT,
  expiry_date TIMESTAMP NOT NULL,
  budget INT NOT NULL,
  client_id INT NOT NULL,
  FOREIGN KEY (client_id) REFERENCES users(id),
  executor_id INT,
  FOREIGN KEY (executor_id) REFERENCES users(id),
  category_id INT NOT NULL,
  FOREIGN KEY (category_id) REFERENCES categories(id),
  coordinate POINT NOT NULL,
  task_status VARCHAR(255) NOT NULL
);

--I'm not sure we need there diff column or not (for example, internal_name).
CREATE TABLE files (
  uuid INT NOT NULL PRIMARY KEY,
  name VARCHAR(255) NOT NULL
);

CREATE TABLE taskFiles (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  file_id INT NOT NULL,
  FOREIGN KEY (file_id) REFERENCES files(id),
  task_id INT NOT NULL,
  FOREIGN KEY (task_id) REFERENCES tasks(id)
);

CREATE TABLE responds (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  task_id INT NOT NULL,
  FOREIGN KEY (task_id) REFERENCES tasks(id),
  executor_id INT NOT NULL,
  FOREIGN KEY (executor_id) REFERENCES users(id),
  dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  price INT NOT NULL,
  comment TEXT
);

CREATE TABLE reviews (
  id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  task_id INT NOT NULL,
  FOREIGN KEY (task_id) REFERENCES tasks(id),
  -- We can received all this information by task_id, shouldn't we use it here?
  -- executor_id INT NOT NULL,
  -- FOREIGN KEY (executor_id) REFERENCES users(id),
  -- client_id INT,
  -- FOREIGN KEY (client_id) REFERENCES users(id),
  score INT NOT NULL,
  comment TEXT,
  dt_add TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  success BOOLEAN
);

CREATE INDEX t_name ON tasks(name);
CREATE INDEX c_name ON categories(name);
