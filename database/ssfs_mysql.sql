CREATE DATABASE ssfs CHARACTER SET utf8 COLLATE utf8_general_ci;
CREATE TABLE ssfs.archive (fileid varchar(64) NOT NULL,filedate DATE NOT NULL,filedata MEDIUMTEXT NOT NULL ,UNIQUE fileid (fileid));
CREATE TABLE ssfs.stats (id INT NOT NULL AUTO_INCREMENT,numsearch varchar(9) NOT NULL DEFAULT '0',INDEX id (id));
INSERT INTO ssfs.stats (id,numsearch) VALUES ('1','0');