--  CREER LES 5 CHAINES HOTELIERES

INSERT INTO ChaineHoteliere (nom, adresse_siege, nb_hotels, email_contact, telephone_contact) VALUES
('LuxeHotels', '123 Rue Centrale, Montréal', 8, 'contact@luxehotels.com', '514-123-4567'),
('EconoStay', '456 Boulevard Sud, Toronto', 9, 'info@econostay.com', '416-234-5678'),
('FamilyInn', '789 Avenue Ouest, Vancouver', 10, 'support@familyinn.com', '604-345-6789'),
('GrandPalace', '321 Place Royale, Québec', 8, 'booking@grandpalace.com', '418-456-7890'),
('GreenResorts', '567 Parc Naturel, Ottawa', 8, 'hello@greenresorts.com', '613-567-8901');

-- CREER LES 8 HOTELS POUR CHACUN DES 5 CHAINES

INSERT INTO Hotel (chain_id, adresse, nb_chambres, classement, email_contact, telephone_contact) VALUES
-- Hôtels de LuxeHotels
(1, '200 Rue de la Montagne, Montréal', 50, 5, 'montreal@luxehotels.com', '514-765-4321'),
(1, '201 Rue du Soleil, Québec', 40, 4, 'quebec@luxehotels.com', '418-876-5432'),
(1, '202 Rue du Lac, Ottawa', 35, 3, 'ottawa@luxehotels.com', '613-234-5678'),
(1, '203 Avenue Royale, Toronto', 60, 5, 'toronto@luxehotels.com', '416-345-6789'),
(1, '204 Boulevard Nord, Vancouver', 45, 4, 'vancouver@luxehotels.com', '604-456-7890'),
(1, '205 Parc Montagneux, Montréal', 38, 3, 'montagne@luxehotels.com', '514-567-8901'),
(1, '206 Rue des Étoiles, Québec', 55, 5, 'etoiles@luxehotels.com', '418-678-9012'),
(1, '207 Boulevard Lumière, Ottawa', 48, 4, 'lumiere@luxehotels.com', '613-789-0123'),

-- Hôtels de EconoStay
(2, '100 Rue Économique, Toronto', 50, 3, 'toronto1@econostay.com', '416-600-1001'),
(2, '101 Boulevard Affaires, Toronto', 40, 3, 'toronto2@econostay.com', '416-600-1002'),
(2, '102 Rue du Budget, Montréal', 35, 2, 'montreal1@econostay.com', '514-600-2001'),
(2, '103 Avenue Épargne, Vancouver', 50, 3, 'vancouver1@econostay.com', '604-600-3001'),
(2, '104 Place Rabais, Québec', 38, 2, 'quebec1@econostay.com', '418-600-4001'),
(2, '105 Rue Frugale, Ottawa', 42, 3, 'ottawa1@econostay.com', '613-600-5001'),
(2, '106 Avenue LowCost, Vancouver', 55, 4, 'vancouver2@econostay.com', '604-600-3002'),
(2, '107 Boulevard SmartSpend, Ottawa', 40, 3, 'ottawa2@econostay.com', '613-600-5002'),

-- Hôtels de FamilyInn
(3, '200 Rue Familiale, Toronto', 45, 4, 'toronto1@familyinn.com', '416-700-1001'),
(3, '201 Avenue Parentale, Vancouver', 50, 3, 'vancouver1@familyinn.com', '604-700-2001'),
(3, '202 Rue Calme, Québec', 35, 3, 'quebec1@familyinn.com', '418-700-3001'),
(3, '203 Boulevard Chaleureux, Ottawa', 40, 4, 'ottawa1@familyinn.com', '613-700-4001'),
(3, '204 Place Sécurité, Montréal', 55, 4, 'montreal1@familyinn.com', '514-700-5001'),
(3, '205 Rue Douceur, Québec', 38, 3, 'quebec2@familyinn.com', '418-700-3002'),
(3, '206 Avenue Harmonie, Vancouver', 42, 3, 'vancouver2@familyinn.com', '604-700-2002'),
(3, '207 Boulevard Tranquillité, Ottawa', 50, 4, 'ottawa2@familyinn.com', '613-700-4002'),

-- Hôtels de GrandPalace
(4, '300 Rue Royale, Québec', 60, 5, 'quebec1@grandpalace.com', '418-800-1001'),
(4, '301 Avenue Prestige, Toronto', 55, 5, 'toronto1@grandpalace.com', '416-800-2001'),
(4, '302 Boulevard Magnifique, Vancouver', 50, 5, 'vancouver1@grandpalace.com', '604-800-3001'),
(4, '303 Place Élégance, Montréal', 45, 4, 'montreal1@grandpalace.com', '514-800-4001'),
(4, '304 Rue Somptueuse, Ottawa', 50, 5, 'ottawa3@grandpalace.com', '613-800-5001'),
(4, '305 Avenue Impériale, Québec', 40, 4, 'quebec2@grandpalace.com', '418-800-1002'),
(4, '306 Boulevard Luxe, Vancouver', 42, 4, 'vancouver2@grandpalace.com', '604-800-3002'),
(4, '307 Rue Classique, Ottawa', 38, 3, 'ottawa4@grandpalace.com', '613-800-5002'),

-- Hôtels de GreenResorts
(5, '400 Parc Naturel, Ottawa', 50, 4, 'ottawa1@greenresorts.com', '613-900-1001'),
(5, '401 Rue Verte, Vancouver', 55, 5, 'vancouver1@greenresorts.com', '604-900-2001'),
(5, '402 Avenue Écologique, Toronto', 45, 4, 'toronto1@greenresorts.com', '416-900-3001'),
(5, '403 Boulevard Développement Durable, Montréal', 50, 4, 'montreal1@greenresorts.com', '514-900-4001'),
(5, '404 Place Pure, Québec', 38, 3, 'quebec1@greenresorts.com', '418-900-5001'),
(5, '405 Rue Recyclée, Vancouver', 42, 4, 'vancouver2@greenresorts.com', '604-900-2002'),
(5, '406 Avenue Bio, Ottawa', 50, 4, 'ottawa2@greenresorts.com', '613-900-1002'),
(5, '407 Boulevard Nature, Montréal', 40, 3, 'montreal2@greenresorts.com', '514-900-4002');

-- CREER LES 5 CHAMBRES POUR CHACUN DES CHAMBRES

INSERT INTO Chambre (hotel_id, prix, capacite, vue_mer, vue_montagne, extensible, dommages) VALUES
-- Insertion des chambres pour chaque hôtel
-- (Répété pour chaque hôtel ID de 1 à 40)
(1, 120.00, 'simple', FALSE, FALSE, TRUE, NULL),
(1, 150.00, 'double', FALSE, TRUE, TRUE, NULL),
(1, 180.00, 'suite', TRUE, FALSE, FALSE, NULL),
(1, 200.00, 'suite', TRUE, TRUE, TRUE, NULL),
(1, 100.00, 'simple', FALSE, FALSE, FALSE, NULL),

(2, 130.00, 'double', FALSE, TRUE, FALSE, NULL),
(2, 160.00, 'suite', TRUE, FALSE, TRUE, NULL),
(2, 110.00, 'simple', FALSE, FALSE, FALSE, NULL),
(2, 175.00, 'suite', TRUE, TRUE, FALSE, NULL),
(2, 140.00, 'double', FALSE, TRUE, TRUE, NULL),

(3, 125.00, 'simple', FALSE, FALSE, TRUE, NULL),
(3, 155.00, 'double', FALSE, TRUE, TRUE, NULL),
(3, 185.00, 'suite', TRUE, FALSE, FALSE, NULL),
(3, 210.00, 'suite', TRUE, TRUE, TRUE, NULL),
(3, 105.00, 'simple', FALSE, FALSE, FALSE, NULL),

(4, 135.00, 'double', FALSE, TRUE, FALSE, NULL),
(4, 165.00, 'suite', TRUE, FALSE, TRUE, NULL),
(4, 115.00, 'simple', FALSE, FALSE, FALSE, NULL),
(4, 180.00, 'suite', TRUE, TRUE, FALSE, NULL),
(4, 145.00, 'double', FALSE, TRUE, TRUE, NULL),

(5, 140.00, 'simple', FALSE, FALSE, TRUE, NULL),
(5, 170.00, 'double', FALSE, TRUE, TRUE, NULL),
(5, 190.00, 'suite', TRUE, FALSE, FALSE, NULL),
(5, 220.00, 'suite', TRUE, TRUE, TRUE, NULL),
(5, 110.00, 'simple', FALSE, FALSE, FALSE, NULL);