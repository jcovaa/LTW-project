DROP TABLE IF EXISTS Review;
DROP TABLE IF EXISTS Message;
DROP TABLE IF EXISTS Order_;
DROP TABLE IF EXISTS ServiceCategory;
DROP TABLE IF EXISTS Service;
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS Admin;
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Image;

-- https://web.fe.up.pt/~arestivo/slides/?s=relationalmodel-uml#31
-- https://web.fe.up.pt/~arestivo/page/


CREATE TABLE Image (
    ImageUrl NVARCHAR(80) PRIMARY KEY NOT NULL
);

CREATE TABLE Admin (
    UserId INTEGER PRIMARY KEY,
    FOREIGN KEY (UserId) REFERENCES User(UserId) ON DELETE CASCADE
);

CREATE TABLE User (
    UserId INTEGER PRIMARY KEY AUTOINCREMENT,
    Name NVARCHAR(120),
    Username NVARCHAR(50) UNIQUE NOT NULL, -- no duplicates
    Email NVARCHAR(255) UNIQUE NOT NULL, -- no duplicates
    Password VARCHAR(255) NOT NULL,
    ImageUrl NVARCHAR(80) DEFAULT 'images/profiles/default_profile.png',
    FOREIGN KEY (ImageUrl) REFERENCES Image(ImageUrl)
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
    PromotionExpiry DATETIME,
    ImageURL NVARCHAR(80),
    FOREIGN KEY (ImageUrl) REFERENCES Image(ImageUrl),
    FOREIGN KEY (FreelancerID) REFERENCES User(UserId) ON DELETE CASCADE
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
    Status NVARCHAR(50) DEFAULT 'Pending' CHECK (Status IN ('Pending', 'In Progress', 'Complete')),
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
    Content NVARCHAR(1000) NOT NULL,
    SentAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (SenderId) REFERENCES User(UserId) ON DELETE CASCADE,
    FOREIGN KEY (ReceiverId) REFERENCES User(UserId) ON DELETE CASCADE
);


INSERT INTO Image (ImageUrl) VALUES 
('images/profiles/default_profile.png'),
('images/services/service1.png'),
('images/services/service2.png'),
('images/services/service3.png'),
('images/services/service4.png'),
('images/services/service5.png'),
('images/services/service6.png'),
('images/services/service7.png');



INSERT INTO User (Name, Username, Email, Password, ImageUrl) VALUES
('Alice Martins', 'alice', 'alice@example.com', '$2y$12$abcdabcdabcdabcdabcdab.pJoiZsU1QUK4Muiv00abc', 'images/profiles/default_profile.png'),
('Bruno Costa', 'bruno', 'bruno@example.com', '$2y$12$efghefghefghefghefghef.pJoiZsU1QUK4Muiv00def', 'images/profiles/default_profile.png'),
('Carla Nunes', 'carla', 'carla@example.com', '$2y$12$hijkhijkhijkhijkhijkhi.pJoiZsU1QUK4Muiv00ghi', 'images/profiles/default_profile.png'),
('David Rocha', 'david', 'david@example.com', '$2y$12$lmnolmnolmnolmnolmnolm.pJoiZsU1QUK4Muiv00jkl', 'images/profiles/default_profile.png'),
('Eva Silva', 'eva', 'eva@example.com', '$2y$12$pqrspqrspqrspqrspqrspq.pJoiZsU1QUK4Muiv00mno', 'images/profiles/default_profile.png'),
('Fábio Lima', 'fabio', 'fabio@example.com', '$2y$12$tuvwtuvwtuvwtuvwtuvwtu.pJoiZsU1QUK4Muiv00pqr', 'images/profiles/default_profile.png');


INSERT INTO Admin (UserId) VALUES (1);


INSERT INTO Category (Name) VALUES
('Web Development'),
('Graphic Design'),
('Writing'),
('Marketing'),
('SEO Optimization'),
('Mobile App Development'),
('Voice Over'),
('Translation'),
('Social Media Management'),
('Video Editing');

INSERT INTO Service (Name, FreelancerID, Price, DeliveryTime, Description, IsPromoted, PromotionExpiry, ImageURL) VALUES
('Build Your Website', 1, 300.00, 7, 'I will create a responsive website.', 1, datetime('now', '+7 days'), 'images/services/service1.png'),
('Logo Design', 2, 120.00, 3, 'Professional logo design service.', 0, NULL, 'images/services/service2.png'),
('SEO Audit and Strategy', 3, 150.00, 5, 'Detailed SEO analysis and action plan.', 1, datetime('now', '+5 days'), 'images/services/service3.png'),
('Android App Development', 4, 500.00, 10, 'Custom Android apps built from scratch.', 0, NULL, 'images/services/service4.png'),
('Voice Over for Ads', 5, 80.00, 2, 'Professional female voice over in English or Portuguese.', 1, datetime('now', '+3 days'), 'images/services/service5.png'),
('Translate PT <-> EN', 5, 60.00, 2, 'Fast and accurate translation.', 0, NULL, 'images/services/service6.png'),
('Edit Your YouTube Videos', 6, 100.00, 3, 'High-quality video editing and transitions.', 1, datetime('now', '+4 days'), 'images/services/service7.png');

INSERT INTO ServiceCategory (ServiceId, CategoryId) VALUES
(1, 1),  -- Web Development
(2, 2),  -- Graphic Design
(3, 5),  -- SEO
(4, 6),  -- Mobile App
(5, 7),  -- Voice Over
(6, 8),  -- Translation
(7, 10); -- Video Editing


INSERT INTO Order_ (ClientId, ServiceId, Status) VALUES
(2, 1, 'Pending'),
(1, 2, 'In Progress');

INSERT INTO Review (ServiceId, ClientId, Rating, Comment) VALUES
(1, 2, 5, 'Great work! Highly recommend.'),
(2, 1, 4, 'Delivered on time and good quality.'), 
(3, 2, 5, 'Very detailed SEO report. Helped a lot!'),
(4, 1, 4, 'The app runs well and was delivered before deadline.'),
(5, 2, 5, 'Amazing voice and fast turnaround.'),
(6, 1, 4, 'Well translated and natural sounding.'),
(7, 3, 5, 'Video editing was spot on. Very happy!');

INSERT INTO Message (SenderId, ReceiverId, Content) VALUES
(1, 2, 'Hi, I’m interested in your service.'),
(2, 1, 'Thanks! Let me know what you need.');







