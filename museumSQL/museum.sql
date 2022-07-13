use museum;
DROP TABLE if exists `AJ001_image_data`;
DROP TABLE if exists `AJ001_exhibition_hall`;
DROP TABLE if exists `AJ001_image_attribute`;
DROP TABLE if exists `AJ001_branch`;
DROP TABLE if exists `museum_hall`;
DROP TABLE if exists `user_account`;
DROP TABLE if exists `city_table`;

CREATE TABLE `city_table`(
    school_id VARCHAR(6),
    city VARCHAR(10) NOT NULL,
    type VARCHAR(4) NOT NULL,
    name VARCHAR(50) NOT NULL,
    start_time DATETIME,
    end_time DATETIME,
    PRIMARY KEY(school_id)
);

CREATE TABLE `user_account`(
  	school_id VARCHAR(6),
   	username VARCHAR(100) NOT NULL,
    name VARCHAR(50) NOT NULL,
    password VARCHAR(50) NOT NULL,
    position VARCHAR(50),
    PRIMARY KEY(username),
    FOREIGN KEY(school_id) REFERENCES `city_table`(school_id)
);

CREATE TABLE `museum_hall`(
	exhibition_hall VARCHAR(30),
    art_place VARCHAR(10),
    PRIMARY KEY(art_place)
);
/*
CREATE TABLE `AJ001_branch`(
	branch VARCHAR(50),
    branch_create_time DATETIME,
    PRIMARY KEY(branch)
);

CREATE TABLE `AJ001_image_attribute`(
	image_id int NOT NULL AUTO_INCREMENT,
    uploader VARCHAR(20),
    image_title VARCHAR(300),
    image_path VARCHAR(500),
    voice_title VARCHAR(300),
    voice_path VARCHAR(500),
    PRIMARY KEY(image_id),
    FOREIGN KEY(uploader) REFERENCES `user_account`(username)
);

CREATE TABLE `AJ001_exhibition_hall`(
    image_id int,
    branch VARCHAR(50),
    art_place VARCHAR(10),
    FOREIGN KEY(image_id) REFERENCES `AJ001_image_attribute`(image_id),
    FOREIGN KEY(branch) REFERENCES `AJ001_branch`(branch),
    FOREIGN KEY(art_place) REFERENCES `museum_hall`(art_place),
    PRIMARY KEY(branch,art_place)
);

CREATE TABLE `AJ001_image_data`(
	image_id int,
    art_name VARCHAR(50),
    art_author VARCHAR(50),
    art_description VARCHAR(500),
    author_class VARCHAR(50),
    art_upload_time DATETIME,
	PRIMARY KEY(image_id),
    FOREIGN KEY(image_id) REFERENCES `AJ001_image_attribute`(image_id),
    FOREIGN KEY(author_class) REFERENCES `AJ001_branch`(branch)
);
*/