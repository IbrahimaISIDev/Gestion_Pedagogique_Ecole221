-- Active: 1719252693843@@127.0.0.1@3306@gestion_pedagogique

---------------------------------Nouveau ajustement de la base de données --------------------------------
-- Recréer la base de données
DROP DATABASE IF EXISTS gestion_pedagogique;
CREATE DATABASE gestion_pedagogique;
USE gestion_pedagogique;
-- Tables
CREATE TABLE Professeurs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    specialite VARCHAR(100),
    grade VARCHAR(50),
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

-- Table des modules
CREATE TABLE Modules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL,
    professeur_id INT,
    FOREIGN KEY (professeur_id) REFERENCES Professeurs(id)
);

-- Table des semestres
CREATE TABLE Semestres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL
);

-- Table des années scolaires
CREATE TABLE Annees_Scolaires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL
);

-- Table des classes
CREATE TABLE Classes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL,
    filiere VARCHAR(100),
    niveau VARCHAR(50)
);

-- Table des cours
CREATE TABLE Cours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    libelle VARCHAR(100) NOT NULL,
    professeur_id INT,
    module_id INT,
    semestre_id INT,
    annee_scolaire_id INT,
    quota_horaire INT,
    classe_id INT,
    FOREIGN KEY (professeur_id) REFERENCES Professeurs(id),
    FOREIGN KEY (module_id) REFERENCES Modules(id),
    FOREIGN KEY (semestre_id) REFERENCES Semestres(id),
    FOREIGN KEY (annee_scolaire_id) REFERENCES Annees_Scolaires(id),
    FOREIGN KEY (classe_id) REFERENCES Classes(id)
);

-- Table des étudiants
CREATE TABLE Etudiants (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    classe_id INT,
    niveau VARCHAR(50),
    FOREIGN KEY (classe_id) REFERENCES Classes(id)
);

-- Table des sessions
CREATE TABLE Sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cours_id INT,
    date DATE NOT NULL,
    heure_debut TIME NOT NULL,
    heure_fin TIME NOT NULL,
    nombre_heures INT,
    statut ENUM('planifiée', 'annulée') DEFAULT 'planifiée',
    FOREIGN KEY (cours_id) REFERENCES Cours(id)
);
ALTER TABLE Sessions MODIFY COLUMN statut ENUM('planifiée', 'annulée') DEFAULT 'annulée';

ALTER TABLE `Sessions` ADD COLUMN demande_annulation BOOLEAN DEFAULT FALSE;

-- Table des demandes d'annulation
CREATE TABLE Demande_Annulation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id INT,
    professeur_id INT,
    date_demande DATETIME,
    motif VARCHAR(255),
    statut ENUM('en_attente', 'approuvée', 'rejetée') DEFAULT 'en_attente',
    FOREIGN KEY (session_id) REFERENCES Sessions(id),
    FOREIGN KEY (professeur_id) REFERENCES Professeurs(id)
);

-- Table des affectations cours-étudiants
CREATE TABLE Etudiants_Cours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    etudiant_id INT NOT NULL,
    cours_id INT NOT NULL,
    date_affectation DATE,
    FOREIGN KEY (etudiant_id) REFERENCES Etudiants(id),
    FOREIGN KEY (cours_id) REFERENCES Cours(id)
);

-- Table des absences
CREATE TABLE absences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    etudiant_id INT NOT NULL,
    session_id INT NOT NULL,
    date_absence DATE NOT NULL,
    FOREIGN KEY (etudiant_id) REFERENCES Etudiants(id),
    FOREIGN KEY (session_id) REFERENCES Sessions(id)
);

-- Table des justifications
CREATE TABLE justifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    absence_id INT NOT NULL,
    motif TEXT NOT NULL,
    piece_jointe VARCHAR(255),
    date_justification TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (absence_id) REFERENCES absences(id)
);
CREATE TABLE IF NOT EXISTS emploi_du_temps (
    id INT AUTO_INCREMENT PRIMARY KEY,
    date DATE NOT NULL,
    cours_libelle VARCHAR(255) NOT NULL,
    heure_debut TIME NOT NULL,
    heure_fin TIME NOT NULL
);
INSERT INTO Professeurs (nom, prenom, specialite, grade, email, password) VALUES
('Diallo', 'Sory', 'Développement Web', 'Senior Lecturer', 'sory.diallo@example.com', 'password_hash'),
('Diop', 'Awa', 'Data Science', 'Lecturer', 'awa.diop@example.com', 'password_hash'),
('Fall', 'Ibrahima', 'Cyber Sécurité', 'Assistant Lecturer', 'ibrahima.fall@example.com', 'password_hash'),
('Diallo', 'Ibrahima', 'Développement FullStack', 'Junior', 'ibrahima.diallojunior@sonatelacademy.sn', 'Sonatel@2024');

INSERT INTO Modules (libelle, professeur_id) VALUES
('Web101', 1),
('DS201', 2),
('CS101', 3);

INSERT INTO Semestres (libelle) VALUES
('Semestre 1'),
('Semestre 2');

INSERT INTO Annees_Scolaires (libelle) VALUES
('2023-2024'),
('2024-2025');

INSERT INTO Classes (libelle, filiere, niveau) VALUES
('Classe A', 'Informatique', 'L1'),
('Classe B', 'Informatique', 'L2'),
('Classe C', 'Data Science', 'M1');

INSERT INTO Etudiants (nom, prenom, email, password, classe_id, niveau) VALUES
('Sow', 'Aissatou', 'aissatou.sow@example.com', 'hashed_password1', 1, 'L1'),
('Ba', 'Mamadou', 'mamadou.ba@example.com', 'Sonatel@2024', 2, 'L2');

INSERT INTO Cours (libelle, professeur_id, module_id, semestre_id, annee_scolaire_id, quota_horaire, classe_id) VALUES
('Développement Web', 1, 1, 1, 1, 60, 2),
('Introduction à la Data Science', 2, 2, 1, 1, 45, 2),
('Introduction à la Cyber Sécurité', 3, 3, 1, 1, 40, 2),
('Introduction à la Programmation', 1, 1, 2, 2, 45, 1),
('Analyse de Données', 2, 2, 2, 2, 50, 2),
('Algorithmique Avancée', 1, 1, 1, 1, 50, 1),
('Machine Learning', 2, 2, 1, 1, 45, 2),
('Sécurité des Réseaux', 3, 3, 1, 1, 40, 2),
('Développement Mobile', 1, 1, 2, 2, 55, 1),
('Analyse Statistique', 2, 2, 2, 2, 50, 2),
('Intelligence Artificielle', 2, 2, 2, 2, 55, 2);

SELECT * FROM Sessions WHERE date BETWEEN '2024-07-01' AND '2024-07-31';


------------------------------- Ajustement de la base de données ------------------------------


-- Insérer des étudiants
INSERT INTO Etudiants (nom, prenom, email, password, classe_id, niveau) VALUES
('Sow', 'Aissatou', 'aissatou.sow@example.com', '$2y$10$S4.wXk/Wc6Tvo1mpKJN/POkebUwd38sOoI0GiZz2QPTMNX8PR2Qda', 1, 'L1'),
('Ba', 'Mamadou', 'mamadou.ba@example.com', '$2y$10$L8ZjV4sfDl0Z7/mcR/Foe.OhiCvO.JLSbd5EGYQJwSB79imlF.EwK', 2, 'L2');

-- Insérer des absences
INSERT INTO absences (etudiant_id, session_id, date_absence) VALUES
(1, 1, '2024-09-01'),
(2, 2, '2024-09-03');

INSERT INTO justifications (absence_id, motif, piece_jointe) VALUES
(1, 'Problème de transport', 'justification_transport.pdf'),
(2, 'Rendez-vous médical', 'justification_medicale.pdf');

-- Créer une table pour l'emploi du temps


SELECT date, cours_libelle, heure_debut, heure_fin
FROM emploi_du_temps
WHERE WEEK(date) = WEEK(CURDATE()) AND YEAR(date) = YEAR(CURDATE());

SELECT date, cours_libelle, heure_debut, heure_fin
FROM emploi_du_temps;

SELECT date, cours_libelle, heure_debut, heure_fin
FROM emploi_du_temps
WHERE WEEK(date) = WEEK(CURDATE()) AND YEAR(date) = YEAR(CURDATE());


INSERT INTO justifications (absence_id, motif, piece_jointe) VALUES
(1, 'Problème de transport', 'justification_transport.pdf'),
(2, 'Rendez-vous médical', 'justification_medicale.pdf');


-- Vérifier les affectations pour cette semaine
SELECT * FROM Etudiants_Cours
WHERE date_affectation = @date_semaine;

-- Mettre à jour l'affectation d'un étudiant dans un cours
UPDATE Etudiants_Cours
SET cours_id = 4 -- Nouveau cours
WHERE etudiant_id = 4 AND cours_id = 2 AND date_affectation = @date_semaine;


SELECT date, cours_libelle, heure_debut, heure_fin
FROM emploi_du_temps
WHERE week(date) = WEEK(CURDATE()) AND year(date) = YEAR(CURDATE());


SELECT date, cours_libelle, heure_debut, heure_fin
FROM emploi_du_temps
WHERE WEEK(date) = WEEK(CURDATE()) AND YEAR(date) = YEAR(CURDATE());

SELECT date, cours_libelle, heure_debut, heure_fin
FROM emploi_du_temps;

SELECT date, cours_libelle, heure_debut, heure_fin
FROM emploi_du_temps
WHERE WEEK(date) = WEEK(CURDATE()) AND YEAR(date) = YEAR(CURDATE());


INSERT INTO emploi_du_temps (date, cours_libelle, heure_debut, heure_fin) VALUES
('2024-08-08', 'Développement Web', '08:00:00', '10:00:00'),
('2024-07-07', 'Développement Mobile', '14:00:00', '16:00:00');


INSERT INTO emploi_du_temps (date, cours_libelle, heure_debut, heure_fin) VALUES
('2024-08-06', 'Développement Web', '09:00:00', '11:00:00'),
('2024-08-05', 'Développement Mobile', '13:00:00', '15:00:00');

SELECT s.date, c.libelle AS cours_libelle, s.heure_debut, s.heure_fin
FROM Sessions s
JOIN Cours c ON s.cours_id = c.id
JOIN Etudiants_Cours ec ON c.id = ec.cours_id
JOIN Etudiants e ON ec.etudiant_id = e.id
WHERE e.id = 4 AND WEEK(s.date) = WEEK(CURDATE()) AND YEAR(s.date) = YEAR(CURDATE());


CREATE TABLE IF NOT EXISTS Presences (
    id INT AUTO_INCREMENT PRIMARY KEY,
    etudiant_id INT NOT NULL,
    session_id INT NOT NULL,
    date_presence TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (etudiant_id) REFERENCES Etudiants(id),
    FOREIGN KEY (session_id) REFERENCES Sessions(id)
);


CREATE TABLE Professeurs_Cours (
    id INT AUTO_INCREMENT PRIMARY KEY,
    professeur_id INT NOT NULL,
    cours_id INT NOT NULL,
    FOREIGN KEY (professeur_id) REFERENCES Professeurs(id),
    FOREIGN KEY (cours_id) REFERENCES Cours(id)
);

-- Example data
INSERT INTO Professeurs_Cours (professeur_id, cours_id) VALUES
(5, 2),
(5, 5),
(5, 7),
(5, 10),
(5, 3),
(5, 8),
(5, 11);


-- Affectations cours-étudiants
INSERT INTO Etudiants_Cours (etudiant_id, cours_id, date_affectation) VALUES
(4, 7, '2024-08-01'),
(4, 5, '2024-08-10');

SELECT * FROM `Etudiants`;

SELECT * FROM `Etudiants_Cours`;
-- Requêtes SQL
-- 1. Liste des cours d'un étudiant
SELECT e.nom, e.prenom, c.libelle AS cours
FROM Etudiants e
JOIN Etudiants_Cours ec ON e.id = ec.etudiant_id
JOIN Cours c ON ec.cours_id = c.id
WHERE e.id = 1;

-- 2. Liste des absences d'un étudiant
SELECT a.date_absence, s.date AS session_date, s.heure_debut, s.heure_fin
FROM absences a
JOIN Sessions s ON a.session_id = s.id
WHERE a.etudiant_id = 1;

-- 3. Liste des sessions annulées
SELECT s.date, s.heure_debut, s.heure_fin, da.motif, da.statut
FROM Sessions s
JOIN Demande_Annulation da ON s.id = da.session_id;


SELECT * FROM `Sessions`;

SELECT * FROM `Etudiants_Cours`;

INSERT INTO Sessions (cours_id, date, heure_debut, heure_fin) VALUES
(2, '2024-08-09', '10:00:00', '12:00:00');

(1, '2024-08-02', '08:00:00', '10:00:00'),
(1, '2024-08-02', '10:00:00', '12:00:00'),
(1, '2024-08-02', '12:00:00', '14:00:00'),
(1, '2024-08-02', '14:00:00', '16:00:00'),
(1, '2024-08-02', '16:00:00', '18:00:00'),

-- Continuez avec les mêmes modèles pour chaque jour de la semaine du 1er au 31 août.
-- Lundi au vendredi et les samedis spécifiés :
-- Pour ajouter des sessions le samedi 3 août par exemple :
(1, '2024-08-03', '08:00:00', '10:00:00'),
(1, '2024-08-03', '10:00:00', '12:00:00'),
(1, '2024-08-03', '12:00:00', '14:00:00'),
(1, '2024-08-03', '14:00:00', '16:00:00'),
(1, '2024-08-03', '16:00:00', '18:00:00'),

-- Répétez pour chaque jour, en tenant compte des samedis spécifiques
-- Exemple pour le lundi 5 août
INSERT INTO Sessions (cours_id, date, heure_debut, heure_fin) VALUES
(4, '2024-08-05', '10:00:00', '12:00:00'),
(4, '2024-08-05', '12:00:00', '14:00:00'),
(4, '2024-08-05', '14:00:00', '16:00:00');


-- Ajoutez les jours restants du mois jusqu'au 31 août.
(1, '2024-08-31', '08:00:00', '10:00:00'),
(1, '2024-08-31', '10:00:00', '12:00:00'),
(1, '2024-08-31', '12:00:00', '14:00:00'),
(1, '2024-08-31', '14:00:00', '16:00:00'),
(1, '2024-08-31', '16:00:00', '18:00:00');


-- Insertion des sessions pour le mois d'août 2024
INSERT INTO Sessions (cours_id, date, heure_debut, heure_fin) VALUES
(2, '2024-08-09', '08:00:00', '10:00:00'),
(2, '2024-08-09', '10:00:00', '12:00:00'),
(1, '2024-08-07', '12:00:00', '14:00:00'),
(2, '2024-08-08', '13:00:00', '15:00:00'),
(1, '2024-08-09', '16:00:00', '18:00:00');

-- Continuer avec les autres lignes ...

SELECT * FROM Sessions WHERE cours_id = 4;
SELECT * FROM Cours WHERE id = 4;
SELECT * FROM Etudiants_Cours WHERE cours_id = 4 AND etudiant_id = 4;
SELECT * FROM Etudiants WHERE id = 4;


SELECT s.date, c.libelle, s.heure_debut, s.heure_fin
FROM Sessions s
JOIN Cours c ON s.cours_id = c.id
WHERE s.cours_id = 2 AND WEEK(s.date) = WEEK(CURDATE());

SELECT c.libelle, COUNT(*) as occurrences, s.date, s.heure_debut, s.heure_fin
FROM Sessions s
JOIN Cours c ON s.cours_id = c.id
JOIN Etudiants_Cours ec ON c.id = ec.cours_id
JOIN Etudiants e ON ec.etudiant_id = e.id
WHERE e.id = 4 AND WEEK(s.date) = WEEK(CURDATE()) AND YEAR(s.date) = YEAR(CURDATE())
GROUP BY c.libelle, s.date, s.heure_debut, s.heure_fin;

SELECT cours_id, date, heure_debut, heure_fin, COUNT(*) as occurrences
FROM Sessions
GROUP BY cours_id, date, heure_debut, heure_fin
HAVING occurrences > 1;

SELECT c.libelle, e.id as etudiant_id, COUNT(*) as occurrences
FROM Sessions s
JOIN Cours c ON s.cours_id = c.id
JOIN Etudiants_Cours ec ON c.id = ec.cours_id
JOIN Etudiants e ON ec.etudiant_id = e.id
WHERE WEEK(s.date) = WEEK(CURDATE()) AND YEAR(s.date) = YEAR(CURDATE())
GROUP BY c.libelle, e.id
HAVING occurrences > 1;


DELETE s1 FROM Sessions s1
INNER JOIN Sessions s2
ON s1.cours_id = s2.cours_id AND s1.date = s2.date
AND s1.heure_debut = s2.heure_debut AND s1.heure_fin = s2.heure_fin
WHERE s1.id < s2.id;

DELETE ec1 FROM Etudiants_Cours ec1
INNER JOIN Etudiants_Cours ec2
ON ec1.etudiant_id = ec2.etudiant_id AND ec1.cours_id = ec2.cours_id
WHERE ec1.id < ec2.id;


DELETE ec1 FROM Etudiants_Cours ec1
INNER JOIN Etudiants_Cours ec2
ON ec1.etudiant_id = ec2.etudiant_id AND ec1.cours_id = ec2.cours_id
WHERE ec1.id < ec2.id;

ALTER TABLE Sessions ADD UNIQUE (cours_id, date, heure_debut, heure_fin);
ALTER TABLE Etudiants_Cours ADD UNIQUE (etudiant_id, cours_id);


select * FROM `Sessions`;