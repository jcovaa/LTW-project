DROP TABLE IF EXISTS Review;
DROP TABLE IF EXISTS Message;
DROP TABLE IF EXISTS Order_;
DROP TABLE IF EXISTS ServiceCategory;
DROP TABLE IF EXISTS Service;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS Admin;
DROP TABLE IF EXISTS User;

-- https://web.fe.up.pt/~arestivo/slides/?s=relationalmodel-uml#31
-- https://web.fe.up.pt/~arestivo/page/

CREATE TABLE Admin (
    UserId INTEGER PRIMARY KEY,
    FOREIGN KEY (UserId) REFERENCES User(UserId) ON DELETE CASCADE
);

CREATE TABLE User (
    UserId INTEGER PRIMARY KEY AUTOINCREMENT,
    Name NVARCHAR(120),
    Username NVARCHAR(50) UNIQUE NOT NULL, -- no duplicates
    Email NVARCHAR(255) UNIQUE NOT NULL, -- no duplicates
    Password NVARCHAR(255) NOT NULL
);

CREATE TABLE Category (
    CategoryId INTEGER PRIMARY KEY AUTOINCREMENT,
    Name NVARCHAR(120)
);

CREATE TABLE Service (
    ServiceId INTEGER PRIMARY KEY AUTOINCREMENT,
    Name NVARCHAR(120) NOT NULL,
    FreelancerID INTEGER NOT NULL,
    Price FLOAT,
    DeliveryTime INTEGER,   -- in days
    Description NVARCHAR(2000),
    IsPromoted BOOLEAN DEFAULT 0,
    FOREIGN KEY (FreelancerID) REFERENCES User(UserId)
);

CREATE TABLE ServiceCategory (
    ServiceId INTEGER NOT NULL,
    CategoryId INTEGER NOT NULL,
    PRIMARY KEY (ServiceId, CategoryId),
    FOREIGN KEY (ServiceId) REFERENCES Service(ServiceId) ON DELETE CASCADE,
    FOREIGN KEY (CategoryId) REFERENCES Category(CategoryId) ON DELETE CASCADE
);

CREATE TABLE Order_ (      -- a.k.a UserService
    OrderId INTEGER PRIMARY KEY AUTOINCREMENT,
    ClientId INTEGER NOT NULL,
    ServiceId INTEGER NOT NULL,
    Status NVARCHAR(50) DEFAULT 'pending',
    OrderDate DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (ServiceId) REFERENCES Service(ServiceId) ON DELETE CASCADE,
    FOREIGN KEY (ClientId) REFERENCES User(UserId) ON DELETE CASCADE
);


CREATE TABLE Review (
    ReviewID INTEGER PRIMARY KEY AUTOINCREMENT,
    ServiceId INTEGER NOT NULL,
    ClientId INTEGER NOT NULL,
    Rating INTEGER CHECK (Rating BETWEEN 1 AND 5),
    Comment NVARCHAR(1000),
    FOREIGN KEY (ClientId) REFERENCES User(UserId) ON DELETE CASCADE,
    FOREIGN KEY (ServiceId) REFERENCES Service(ServiceId) ON DELETE CASCADE
);

CREATE TABLE Message (
    MessageId INTEGER PRIMARY KEY AUTOINCREMENT,
    SenderId INTEGER NOT NULL,
    ReceiverId INTEGER NOT NULL,
    Content NVARCHAR(1000),
    SentAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (SenderId) REFERENCES User(UserId),
    FOREIGN KEY (ReceiverId) REFERENCES User(UserId)
);


-- Insert Users
INSERT INTO User (UserId, Name, Username, Email, Password) VALUES (1, 'Alice Johnson', 'alicej', 'alice@example.com', 'password1');
INSERT INTO User (UserId, Name, Username, Email, Password) VALUES (2, 'Bob Smith', 'bobsmith', 'bob@example.com', 'password2');
INSERT INTO User (UserId, Name, Username, Email, Password) VALUES (3, 'Charlie Davis', 'charlied', 'charlie@example.com', 'password3');
INSERT INTO User (UserId, Name, Username, Email, Password) VALUES (4, 'Diana Lee', 'dianal', 'diana@example.com', 'password4');

-- Insert Admin
INSERT INTO Admin (UserId) VALUES (1);

-- Insert Categories
INSERT INTO Category (CategoryId, Name) VALUES (1, 'Design');
INSERT INTO Category (CategoryId, Name) VALUES (2, 'Programming');
INSERT INTO Category (CategoryId, Name) VALUES (3, 'Marketing');

-- Insert Services
INSERT INTO Service (ServiceId, Name, FreelancerID, Price, DeliveryTime, Description, IsPromoted) 
VALUES (1, 'Logo Design', 1, 50.0, 3, 'I will design a professional logo.', 1);

INSERT INTO Service (ServiceId, Name, FreelancerID, Price, DeliveryTime, Description, IsPromoted) 
VALUES (2, 'Web Development', 2, 200.0, 7, 'Full-stack website using modern tech.', 0);

INSERT INTO Service (ServiceId, Name, FreelancerID, Price, DeliveryTime, Description, IsPromoted) 
VALUES (3, 'Social Media Ads', 3, 75.0, 2, 'Instagram and Facebook ad design.', 0);

-- ServiceCategory links
INSERT INTO ServiceCategory (ServiceId, CategoryId) VALUES (1, 1);
INSERT INTO ServiceCategory (ServiceId, CategoryId) VALUES (2, 2);
INSERT INTO ServiceCategory (ServiceId, CategoryId) VALUES (3, 3);

-- Insert Orders
INSERT INTO Order_ (OrderId, ClientId, ServiceId, Status, OrderDate)
VALUES (1, 4, 1, 'completed', CURRENT_TIMESTAMP);

INSERT INTO Order_ (OrderId, ClientId, ServiceId, Status, OrderDate)
VALUES (2, 4, 2, 'pending', CURRENT_TIMESTAMP);

-- Insert Reviews
INSERT INTO Review (ReviewID, ServiceId, ClientId, Rating, Comment)
VALUES (1, 1, 4, 5, 'Amazing work! Highly recommended.');

INSERT INTO Review (ReviewID, ServiceId, ClientId, Rating, Comment)
VALUES (2, 2, 4, 4, 'Good quality but took an extra day.');

-- Insert Messages
INSERT INTO Message (MessageId, SenderId, ReceiverId, Content, SentAt)
VALUES (1, 4, 1, 'Hi! Can you design a logo for my new brand?', CURRENT_TIMESTAMP);

INSERT INTO Message (MessageId, SenderId, ReceiverId, Content, SentAt)
VALUES (2, 1, 4, 'Sure! Do you have any ideas in mind?', CURRENT_TIMESTAMP);

