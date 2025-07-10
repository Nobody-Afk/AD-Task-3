CREATE TABLE IF NOT EXISTS users (
    id uuid NOT NULL PRIMARY KEY DEFAULT gen_random_uuid(),
    username varchar(225) NOT NULL UNIQUE,
    firstname varchar(225) NOT NULL,
    middlename varchar(225),
    lastname varchar(225) NOT NULL,
    email varchar(225) NOT NULL UNIQUE,
    password varchar(225) NOT NULL,
    role varchar(50) DEFAULT 'user',
    created_at timestamp DEFAULT CURRENT_TIMESTAMP
);
