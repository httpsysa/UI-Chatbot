CREATE DATABASE QueriesDB;

USE QueriesDB;

CREATE TABLE FAQ (
    ID INT AUTO_INCREMENT PRIMARY KEY,
    Query VARCHAR(255) NOT NULL,
    Reply TEXT NOT NULL
);

INSERT INTO FAQ (Query, Reply)
VALUES 
('How can I book an Airbnb?', 'You can book an Airbnb by searching for a property, selecting your dates, and following the booking process on the website.'),
('Can I cancel my booking?', 'Yes, you can cancel your booking, but it depends on the cancellation policy of the property you booked.'),
('How do I contact the host?', 'You can contact the host through the Airbnb messaging system once your booking is confirmed.'),
('How do I save a search on Airbnb?', 'Use the "Save search" feature to keep your search preferences for future use.');
