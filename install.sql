ALTER TABLE incoming ADD cidlookup INT(2);

CREATE TABLE IF NOT EXISTS cidlookup (
  cidlookup_id int(11) NOT NULL auto_increment,
  description varchar(50) NOT NULL,
  sourcetype varchar(100) NOT NULL,
  cache tinyint(1) NOT NULL default '0',
  deptname varchar(30) default NULL,
  http_host varchar(30) default NULL,
  http_port varchar(30) default NULL,
  http_username varchar(30) default NULL,
  http_password varchar(30) default NULL,
  http_path varchar(100) default NULL,
  http_query varchar(100) default NULL,
  mysql_host varchar(60) default NULL,
  mysql_dbname varchar(60) default NULL,
  mysql_query text,
  mysql_username varchar(30) default NULL,
  mysql_password varchar(30) default NULL,
  PRIMARY KEY  (cidlookup_id)
);


CREATE TABLE IF NOT EXISTS cidlookup_incoming (
  cidlookup_id INT NOT NULL,
	extension VARCHAR(50),
	cidnum VARCHAR(30),
	channel VARCHAR(30)
);
