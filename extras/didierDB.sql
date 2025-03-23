-- Création de la base de données
CREATE DATABASE GestionHoteliere;
USE GestionHoteliere;

-- Table ChaineHoteliere
CREATE TABLE ChaineHoteliere (
    chain_id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    adresse_siege VARCHAR(255) NOT NULL,
    nb_hotels INT NOT NULL CHECK (nb_hotels >= 0),
    email_contact VARCHAR(100) NOT NULL UNIQUE,
    telephone_contact VARCHAR(20) NOT NULL UNIQUE
);

-- Table Hotel
CREATE TABLE Hotel (
    hotel_id INT AUTO_INCREMENT PRIMARY KEY,
    chain_id INT NOT NULL,
    adresse VARCHAR(255) NOT NULL,
    nb_chambres INT NOT NULL CHECK (nb_chambres > 0),
    classement INT CHECK (classement BETWEEN 1 AND 5),
    email_contact VARCHAR(100) NOT NULL UNIQUE,
    telephone_contact VARCHAR(20) NOT NULL UNIQUE,
    FOREIGN KEY (chain_id) REFERENCES ChaineHoteliere(chain_id) ON DELETE CASCADE
);

-- Table Chambre
CREATE TABLE Chambre (
    room_id INT AUTO_INCREMENT PRIMARY KEY,
    hotel_id INT NOT NULL,
    prix DECIMAL(10,2) NOT NULL CHECK (prix > 0),
    capacite ENUM('simple', 'double', 'suite') NOT NULL,
    vue_mer BOOLEAN DEFAULT FALSE,
    vue_montagne BOOLEAN DEFAULT FALSE,
    extensible BOOLEAN DEFAULT FALSE,
    dommages TEXT DEFAULT NULL,
    FOREIGN KEY (hotel_id) REFERENCES Hotel(hotel_id) ON DELETE CASCADE
);

-- Table CommoditeChambre (Relation n-n entre Chambre et Commodités)
CREATE TABLE CommoditeChambre (
    room_id INT NOT NULL,
    commodite VARCHAR(50) NOT NULL,
    PRIMARY KEY (room_id, commodite),
    FOREIGN KEY (room_id) REFERENCES Chambre(room_id) ON DELETE CASCADE
);

-- Table Client
CREATE TABLE Client (
    client_id INT AUTO_INCREMENT PRIMARY KEY,
    nom_complet VARCHAR(100) NOT NULL,
    adresse VARCHAR(255) NOT NULL,
    NAS VARCHAR(20) NOT NULL UNIQUE,
    date_enregistrement timestamp NULL DEFAULT CURRENT_TIMESTAMP
);

-- Table Employe
CREATE TABLE Employe (
    employee_id INT AUTO_INCREMENT PRIMARY KEY,
    hotel_id INT NOT NULL,
    nom_complet VARCHAR(100) NOT NULL,
    adresse VARCHAR(255) NOT NULL,
    NAS VARCHAR(20) NOT NULL UNIQUE,
    poste ENUM('gestionnaire', 'receptionniste', 'femme de ménage', 'autre') NOT NULL,
    FOREIGN KEY (hotel_id) REFERENCES Hotel(hotel_id) ON DELETE CASCADE
);

-- Table GestionnaireHotel (Relation entre Hotel et Employe)
CREATE TABLE GestionnaireHotel (
    hotel_id INT NOT NULL,
    employee_id INT NOT NULL,
    PRIMARY KEY (hotel_id, employee_id),
    FOREIGN KEY (hotel_id) REFERENCES Hotel(hotel_id) ON DELETE CASCADE,
    FOREIGN KEY (employee_id) REFERENCES Employe(employee_id) ON DELETE CASCADE
);

-- Table Reservation
CREATE TABLE Reservation (
    reservation_id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    room_id INT NOT NULL,
  starting_date datetime DEFAULT NULL,
  finishing_date datetime DEFAULT NULL,
  date_created timestamp NULL DEFAULT CURRENT_TIMESTAMP,
    prix DECIMAL(10,2) NOT NULL CHECK (prix > 0),
    FOREIGN KEY (client_id) REFERENCES Client(client_id) ON DELETE CASCADE,
    FOREIGN KEY (room_id) REFERENCES Chambre(room_id) ON DELETE CASCADE
);

-- Table Location (Enregistrement de l'occupation des chambres)
CREATE TABLE Location (
    rental_id INT AUTO_INCREMENT PRIMARY KEY,
    reservation_id INT NULL,
    client_id INT NOT NULL,
    room_id INT NULL,
    employee_id INT NOT NULL,
  starting_date datetime DEFAULT NULL,
  finishing_date datetime DEFAULT NULL,
    FOREIGN KEY (reservation_id) REFERENCES Reservation(reservation_id) ON DELETE SET NULL,
    FOREIGN KEY (client_id) REFERENCES Client(client_id) ON DELETE CASCADE,
    FOREIGN KEY (room_id) REFERENCES Chambre(room_id) ON DELETE SET NULL,
    FOREIGN KEY (employee_id) REFERENCES Employe(employee_id) ON DELETE CASCADE
);
