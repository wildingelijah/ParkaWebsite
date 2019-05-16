{\rtf1\ansi\ansicpg1252\cocoartf1671\cocoasubrtf100
{\fonttbl\f0\fmodern\fcharset0 Courier;}
{\colortbl;\red255\green255\blue255;\red255\green255\blue255;}
{\*\expandedcolortbl;;\cssrgb\c100000\c100000\c100000;}
\margl1440\margr1440\vieww10800\viewh8400\viewkind0
\deftab720
\pard\pardeftab720\sl440\partightenfactor0

\f0\fs28 \cf0 \cb2 \expnd0\expndtw0\kerning0
\outl0\strokewidth0 \strokec0 CREATE TABLE parkings (\
	id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,\
	name VARCHAR(40) NOT NULL,\
	latitude DECIMAL(12,8) NOT NULL,\
	\cb2 \outl0\strokewidth0 longitude DECIMAL(12,8) NOT NULL,\
\pard\pardeftab720\sl440\partightenfactor0
\cf0 \cb2 	price DOUBLE NOT NULL,\
	opentime TIME NOT NULL,\
	closetime TIME NOT NULL,\
	description VARCHAR(500) NOT NULL,\
	rating INT,\
	imagename VARCHAR(50),\
	CONSTRAINT pk_parkings PRIMARY KEY (id)\
);\
\
CREATE TABLE reviews (\
	id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,\
	p_id\cb2  SMALLINT UNSIGNED NOT NULL\cb2 ,\
	rating \cb2 SMALLINT UNSIGNED NOT NULL\cb2 ,\
	customer VARCHAR(60) NOT NULL,\
	text VARCHAR(500),\
	CONSTRAINT pk_reviews PRIMARY KEY (id),\
	CONSTRAINT fk_reviews FOREIGN KEY (p_id) \
	REFERENCES parkings(id),\
	CONSTRAINT fk_reviews2 FOREIGN KEY (customer)\
	REFERENCES users(name)\
);\
\
\pard\pardeftab720\sl440\partightenfactor0
\cf0 \cb2 CREATE TABLE users (\
	name VARCHAR(60) NOT NULL,\
	username VARCHAR(20) NOT NULL,\
	email VARCHAR(40) NOT NULL,\
	CONSTRAINT pk_users PRIMARY KEY (name)\
);}