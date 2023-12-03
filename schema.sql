/*Created User's Table*/
CREATE TABLE Users (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    role VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- insert admin user
INSERT INTO Users (firstname, lastname, password, email, role)
VALUES (
        'admin',
        'user',
        '$2y$10$DvPAzeqKpuBCY0GdDOjZoutU0j9OU7nZO5RIePL1DCvEZIp2qwyOC',
        'admin@project2.com',
        'admin'
    );


/*Created Contacts Table*/
CREATE TABLE Contacts (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    firstname VARCHAR(255) NOT NULL,
    lastname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    telephone VARCHAR(255) NOT NULL,
    company VARCHAR(255) NOT NULL,
    type VARCHAR(255) NOT NULL,
    assigned_to INTEGER,
    created_by INTEGER,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME,
    FOREIGN KEY (assigned_to) REFERENCES Users(id),
    FOREIGN KEY (created_by) REFERENCES Users(id)
);

/*Created Notes Table*/
CREATE TABLE Notes (
    id INTEGER AUTO_INCREMENT PRIMARY KEY,
    contact_id INTEGER,
    comment TEXT,
    created_by INTEGER,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES Users(id)
);