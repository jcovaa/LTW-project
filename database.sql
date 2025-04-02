DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS Service;
DROP TABLE IF EXISTS ServiceCategory;

-- https://web.fe.up.pt/~arestivo/slides/?s=relationalmodel-uml#31
-- https://web.fe.up.pt/~arestivo/page/

CREATE TABLE User (
    UserId INTEGER PRIMARY KEY,
    Name NVARCHAR(120),
    Username NVARCHAR(50) UNIQUE NOT NULL, -- no duplicates
    Password NVARCHAR(255) NOT NULL, 
    Email NVARCHAR(255) UNIQUE NOT NULL -- no duplicates
);

CREATE TABLE Category (
    CategoryId INTEGER PRIMARY KEY,
    Name NVARCHAR(120)
);

CREATE TABLE Service (
    ServiceId INTEGER PRIMARY KEY,
    Name NVARCHAR(120),
    FreelancerID INTEGER NOT NULL,
    FOREIGN KEY (FreelancerID) REFERENCES User(UserId)
);

CREATE TABLE UserService (
    ClientId INTEGER NOT NULL,
    ServiceId INTEGER NOT NULL,
    PRIMARY KEY (ClientId, ServiceId),
    FOREIGN KEY (ServiceId) REFERENCES Service(ServiceId) ON DELETE CASCADE,
    FOREIGN KEY (ClientId) REFERENCES User(UserId) ON DELETE CASCADE
);

CREATE TABLE ServiceCategory (
    ServiceId INTEGER NOT NULL,
    CategoryId INTEGER NOT NULL,
    PRIMARY KEY (ServiceId, CategoryId),
    FOREIGN KEY (ServiceId) REFERENCES Service(ServiceId) ON DELETE CASCADE,
    FOREIGN KEY (CategoryId) REFERENCES Category(CategoryId) ON DELETE CASCADE
);


INSERT INTO User VALUES (1, 'Pedro Pereira', 'pedropp', 'pedro2000', 'pedropp@gmail.com');
INSERT INTO User VALUES (2, 'Andre Pereira', 'andrep', 'andre2002', 'andrep@gmail.com');

INSERT INTO Category VALUES (1, 'Home Maintenance');
INSERT INTO Category VALUES (2, 'Repairs');

INSERT INTO Service VALUES (1, 'Plumbing', 1);
INSERT INTO Service VALUES (2, 'Eletrical', 1);
INSERT INTO Service VALUES (3, 'Cleaning', 2);

INSERT INTO UserService VALUES (2, 1);
INSERT INTO UserService VALUES (2, 2);
INSERT INTO UserService VALUES (1, 3);


INSERT INTO ServiceCategory VALUES (1, 1);
INSERT INTO ServiceCategory VALUES (1, 2);
INSERT INTO ServiceCategory VALUES (2, 1);
INSERT INTO ServiceCategory VALUES (2, 2);
INSERT INTO ServiceCategory VALUES (3, 2);
