CREATE DATABASE IF NOT EXISTS TumblrBook;
USE TumblrBook;

DROP TABLE IF EXISTS users;
CREATE TABLE users(
	username VARCHAR(255) UNIQUE NOT NULL,
	password VARCHAR(255) NOT NULL,
	libraryheader TEXT,
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
	theme VARCHAR(255) NOT NULL,
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
INSERT INTO users (username, password) VALUES ('mattling', 'mysupersecrettumblrbookpassword');
INSERT INTO blogs VALUES ('solacingsavant', 'some content', 'November 14, 2016'), ('gocookyourself', 'recipes', 'November 14, 2016'), ('thirdblog', 'more content', 'November 14, 2016');
INSERT INTO userblogs (username, blogname, theme) VALUES ('mattling', 'solacingsavant', 'style'), ('mattling', 'gocookyourself', 'sky');
INSERT INTO librarycomments (library, username, created, content) VALUES ('mattling', 'test', 'November 15, 2016', 'Sweet library, dude.'), ('mattling', 'test', 'November 16, 2016', 'Oh wait, wrong library... lol');