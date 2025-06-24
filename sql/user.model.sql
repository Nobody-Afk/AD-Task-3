CREATE TABLE public IF NOT EXISTS User_Details (
    "ID" int NOT NULL PRIMARY KEY,
    username varchar(256) NOT NULL,
    password varchar(256) NOT NULL,
    first_name varchar(256) NOT NULL,
    middle_name varchar(256),
    last_name varchar(256) NOT NULL,
    email varchar(256) NOT NULL
);