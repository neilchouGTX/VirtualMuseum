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
    permission tinyint,
    PRIMARY KEY(username),
    FOREIGN KEY(school_id) REFERENCES `city_table`(school_id)
);

INSERT INTO user_account(username,name,password,position,permission)
VALUES ("admin","admin","1990","admin",0);

CREATE TABLE `museum_hall`(
	exhibition_hall VARCHAR(30),
    art_place VARCHAR(10),
    PRIMARY KEY(art_place)
);

INSERT INTO museum_hall(exhibition_hall,art_place)
VALUES ("北美館","AA001"),
("北美館","AA002"),
("北美館","AA003"),
("北美館","AA004"),
("北美館","AA005"),
("北美館","AA006"),
("北美館","AA007"),
("北美館","AA008"),
("北美館","AA009"),
("北美館","AA010"),
("新北館","FA001"),
("新北館","FA002"),
("新北館","FA003"),
("新北館","FA004"),
("新北館","FA005"),
("新北館","FA006"),
("新北館","FA007"),
("新北館","FA008"),
("新北館","FA009"),
("新北館","FA010");

/*
CREATE TABLE `AJ001_branch`(
	branch VARCHAR(50),
    branch_create_time DATETIME,
    PRIMARY KEY(branch)
);

CREATE TABLE `AJ001_image_attribute`(
	image_id VARCHAR(15) NOT NULL,
    uploader VARCHAR(20),
    image_title VARCHAR(300),
    image_path VARCHAR(500),
    voice_title VARCHAR(300),
    voice_path VARCHAR(500),
    PRIMARY KEY(image_id),
    FOREIGN KEY(uploader) REFERENCES `user_account`(username)
);

CREATE TABLE `AJ001_exhibition_hall`(
    image_id VARCHAR(15),
    branch VARCHAR(50),
    art_place VARCHAR(10),
    FOREIGN KEY(image_id) REFERENCES `AJ001_image_attribute`(image_id),
    FOREIGN KEY(branch) REFERENCES `AJ001_branch`(branch),
    FOREIGN KEY(art_place) REFERENCES `museum_hall`(art_place),
    PRIMARY KEY(branch,art_place)
);

CREATE TABLE `AJ001_image_data`(
	image_id VARCHAR(15),
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