-- Bangla Travel Spot database | MySQL 5.7+ / MariaDB 10.4+
CREATE DATABASE IF NOT EXISTS explore_bangladesh CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE explore_bangladesh;
SET FOREIGN_KEY_CHECKS=0;
DROP TABLE IF EXISTS contact_messages;
DROP TABLE IF EXISTS reviews;
DROP TABLE IF EXISTS trips;
DROP TABLE IF EXISTS favorites;
DROP TABLE IF EXISTS places;
DROP TABLE IF EXISTS categories;
DROP TABLE IF EXISTS settings;
DROP TABLE IF EXISTS users;
SET FOREIGN_KEY_CHECKS=1;

CREATE TABLE users (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(120) NOT NULL,
 email VARCHAR(190) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 role ENUM('user','admin') NOT NULL DEFAULT 'user',
 status ENUM('active','blocked') NOT NULL DEFAULT 'active',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE categories (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL UNIQUE,
 slug VARCHAR(120) NOT NULL UNIQUE,
 description VARCHAR(255) DEFAULT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE places (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 category_id BIGINT UNSIGNED NOT NULL,
 name VARCHAR(160) NOT NULL,
 slug VARCHAR(180) NOT NULL UNIQUE,
 district VARCHAR(120) NOT NULL,
 description TEXT,
 how_to_go TEXT,
 where_to_stay TEXT,
 things_to_do TEXT,
 best_time VARCHAR(160) DEFAULT NULL,
 estimated_budget DECIMAL(12,2) NOT NULL DEFAULT 0,
 cover_image VARCHAR(500) DEFAULT NULL,
 gallery_1 VARCHAR(500) DEFAULT NULL,
 gallery_2 VARCHAR(500) DEFAULT NULL,
 gallery_3 VARCHAR(500) DEFAULT NULL,
 rating DECIMAL(2,1) NOT NULL DEFAULT 4.5,
 status ENUM('published','draft') NOT NULL DEFAULT 'published',
 featured TINYINT(1) NOT NULL DEFAULT 0,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 CONSTRAINT fk_places_category FOREIGN KEY(category_id) REFERENCES categories(id) ON DELETE RESTRICT,
 INDEX idx_places_status(status), INDEX idx_places_district(district), INDEX idx_places_featured(featured)
) ENGINE=InnoDB;

CREATE TABLE favorites (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id BIGINT UNSIGNED NOT NULL,
 place_id BIGINT UNSIGNED NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 UNIQUE KEY unique_favorite(user_id,place_id),
 CONSTRAINT fk_fav_user FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
 CONSTRAINT fk_fav_place FOREIGN KEY(place_id) REFERENCES places(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE trips (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id BIGINT UNSIGNED NOT NULL,
 place_id BIGINT UNSIGNED NOT NULL,
 trip_date DATE NOT NULL,
 people INT UNSIGNED NOT NULL DEFAULT 1,
 budget DECIMAL(12,2) NOT NULL DEFAULT 0,
 notes TEXT,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT fk_trip_user FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
 CONSTRAINT fk_trip_place FOREIGN KEY(place_id) REFERENCES places(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE reviews (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 user_id BIGINT UNSIGNED NOT NULL,
 place_id BIGINT UNSIGNED NOT NULL,
 rating TINYINT UNSIGNED NOT NULL,
 comment TEXT NOT NULL,
 status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 CONSTRAINT chk_review_rating CHECK(rating BETWEEN 1 AND 5),
 CONSTRAINT fk_review_user FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE,
 CONSTRAINT fk_review_place FOREIGN KEY(place_id) REFERENCES places(id) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE contact_messages (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(120) NOT NULL,
 email VARCHAR(190) NOT NULL,
 subject VARCHAR(190) NOT NULL,
 message TEXT NOT NULL,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE settings (
 id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
 setting_key VARCHAR(100) NOT NULL UNIQUE,
 setting_value TEXT
) ENGINE=InnoDB;

-- Demo admin: email admin@explorebangladesh.test / password: password
-- Replace this password after first login.
INSERT INTO users(name,email,password,role) VALUES
('Explore Admin','admin@explorebangladesh.test','$2y$12$jIlvMMFoIU34a6IndDdqNeXqkpCywtUUAOKcGM1vYpNgc2g6Y485q','admin');

INSERT INTO categories(name,slug,description) VALUES
('Beach','beach','Sea beaches, islands and coastal escapes'),
('Hill','hill','Hills, mountains and green valleys'),
('Forest','forest','Forests, mangroves and wildlife'),
('Waterfall','waterfall','Waterfalls, rivers and natural pools'),
('Historical','historical','Heritage, archaeology and historic places'),
('Lake','lake','Lakes, wetlands and scenic water bodies');

INSERT INTO places(category_id,name,slug,district,description,how_to_go,where_to_stay,things_to_do,best_time,estimated_budget,cover_image,gallery_1,gallery_2,gallery_3,rating,status,featured) VALUES
(1,'Cox’s Bazar','coxs-bazar','Cox’s Bazar','Cox’s Bazar is famous for its long natural sea beach, often described as one of the longest unbroken sandy beaches in the world. Enjoy the waves, golden sand and beautiful sunset views.','Direct buses operate from Dhaka and other major cities. You can also fly to Cox’s Bazar Airport. Local transport and rickshaws are available around the town.','Hotels, resorts and guest houses are available along the beach and in the town centre.','Beach walking, sunset watching, seafood, surfing, photography and nearby Himchari visits.','November – February',8500,'https://images.unsplash.com/photo-1500375592092-40eb2168fd21?w=1200','https://images.unsplash.com/photo-1473116763249-2faaef81ccda?w=900','https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=900','https://images.unsplash.com/photo-1519046904884-53103b34b206?w=900',4.8,'published',1),
(2,'Sajek Valley','sajek-valley','Rangamati','Sajek Valley is a scenic hill destination known for rolling green hills, clouds floating over the valleys and peaceful village landscapes.','Travel to Khagrachari by bus, then hire a jeep (Chander Gari) to reach Sajek. Follow current local security and transport guidance.','Resorts, cottages and homestays are available in the valley. Book ahead during holidays.','Watch sunrise and sunset, enjoy cloud views, explore local culture and take landscape photographs.','October – March',12000,'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1200','https://images.unsplash.com/photo-1470770841072-f978cf4d019e?w=900','https://images.unsplash.com/photo-1500534623283-312aade485b7?w=900','https://images.unsplash.com/photo-1519681393784-d120267933ba?w=900',4.7,'published',1),
(3,'Sundarbans','sundarbans','Khulna','The Sundarbans is the world’s largest mangrove forest and a UNESCO World Heritage site, rich in unique wildlife, waterways and natural beauty.','Reach Khulna or Mongla, then join an authorised boat tour with the required permits and a registered operator.','Stay on approved tour vessels or licensed eco-resorts and lodges near entry points.','Boat safaris, birdwatching, wildlife observation and learning about mangrove ecology.','November – February',15000,'https://images.unsplash.com/photo-1448375240586-882707db888b?w=1200','https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=900','https://images.unsplash.com/photo-1472396961693-142e6e269027?w=900','https://images.unsplash.com/photo-1511497584788-876760111969?w=900',4.6,'published',1),
(4,'Sylhet','sylhet','Sylhet','Sylhet is known for lush tea gardens, green hills, rivers and waterfalls. It is a gateway to some of the country’s most beautiful natural landscapes.','Direct bus, train and flight services connect Dhaka with Sylhet. Hire local transport for nearby attractions.','Hotels and guest houses are available in Sylhet city and selected tourist areas.','Visit tea gardens, explore Jaflong and Ratargul, enjoy local food and photograph the landscapes.','October – March',7000,'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?w=1200','https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=900','https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=900','https://images.unsplash.com/photo-1472396961693-142e6e269027?w=900',4.7,'published',1),
(2,'Bandarban','bandarban','Bandarban','Bandarban offers dramatic green hills, winding roads, waterfalls and indigenous cultural heritage in the Chittagong Hill Tracts.','Travel by bus to Bandarban town. Use authorised local transport and check current access rules before visiting remote areas.','Hotels and resorts are available in town and at selected hill locations.','Explore viewpoints, visit waterfalls when accessible, enjoy local cuisine and photography.','November – March',10000,'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=1200','https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=900','https://images.unsplash.com/photo-1470770841072-f978cf4d019e?w=900','https://images.unsplash.com/photo-1519681393784-d120267933ba?w=900',4.6,'published',1),
(1,'Saint Martin’s Island','saint-martins-island','Cox’s Bazar','Saint Martin’s is a small coral island in the Bay of Bengal, known for clear water, coastal scenery and a relaxed island atmosphere.','Reach Teknaf or the currently designated departure point and use authorised vessels when services are operating. Seasonal access rules may change.','Small hotels and guest houses operate subject to current island regulations and seasonal availability.','Enjoy coastal walks, local seafood, photography and responsible nature observation.','November – February (check current access rules)',11000,'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1200','https://images.unsplash.com/photo-1519046904884-53103b34b206?w=900','https://images.unsplash.com/photo-1473116763249-2faaef81ccda?w=900','https://images.unsplash.com/photo-1500375592092-40eb2168fd21?w=900',4.5,'published',0),
(6,'Kaptai Lake','kaptai-lake','Rangamati','Kaptai Lake is a vast scenic lake surrounded by green hills and small islands, offering a peaceful escape in Rangamati.','Travel to Rangamati by bus and hire a registered boat from an authorised ghat for lake trips.','Hotels, resorts and guest houses are available in Rangamati town and nearby areas.','Boat rides, island visits, lakeside views, local food and photography.','October – March',6000,'https://images.unsplash.com/photo-1470770841072-f978cf4d019e?w=1200','https://images.unsplash.com/photo-1500534623283-312aade485b7?w=900','https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=900','https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?w=900',4.4,'published',0);

INSERT INTO settings(setting_key,setting_value) VALUES ('site_name','Bangla Travel Spot'),('contact_email','hello@explorebangladesh.test');
