CREATE DATABASE IF NOT EXISTS TumblrBook;
USE TumblrBook;

DROP TABLE IF EXISTS users;
CREATE TABLE users(
	username VARCHAR(255) UNIQUE NOT NULL,
	password VARCHAR(255) NOT NULL,
	PRIMARY KEY(username)
);

DROP TABLE IF EXISTS blogs;
CREATE TABLE blogs(
	blogname VARCHAR(255) UNIQUE NOT NULL,
	content MEDIUMTEXT NOT NULL,
	updated VARCHAR(255) NOT NULL,
	PRIMARY KEY(blogname)
);

DROP TABLE IF EXISTS userblogs;
CREATE TABLE userblogs(
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	username VARCHAR(255) NOT NULL,
	blogname VARCHAR(255) NOT NULL,
	UNIQUE KEY(username, blogname)
);

DROP TABLE IF EXISTS librarycomments;
CREATE TABLE librarycomments(
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
	library VARCHAR(255) NOT NULL,
	username VARCHAR(255) NOT NULL,
	created VARCHAR(255) NOT NULL,
	content TEXT NOT NULL
);

/* some test entries */
INSERT INTO users VALUES ('mattling', 'password');
INSERT INTO blogs VALUES ('solacingsavant', 'some content', 'November 14, 2016'), ('gocookyourself', 'recipes', 'November 14, 2016'), ('thirdblog', 'more content', 'November 14, 2016');
INSERT INTO userblogs (username, blogname) VALUES ('mattling', 'solacingsavant'), ('mattling', 'gocookyourself');