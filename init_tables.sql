SET FOREIGN_KEY_CHECKS=0;

CREATE TABLE IF NOT EXISTS Club(
  numero INT,
  nom VARCHAR(50) NOT NULL,
  code_postal INT NOT NULL,
  localite VARCHAR(50) NOT NULL,
  rue VARCHAR(100) NOT NULL,
  num INT(5) NOT NULL,
  id_president INT NOT NULL,
  PRIMARY KEY (numero),
  FOREIGN KEY (id_president) REFERENCES Membre(id)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Membre(
  id INT,
  nom VARCHAR(50) NOT NULL,
  prenom VARCHAR(50) NOT NULL,
  email VARCHAR(100) NOT NULL,
  id_club INT NOT NULL,
  PRIMARY KEY (id),
  FOREIGN KEY (id_club) REFERENCES Club(numero)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Cheval(
  numero INT,
  nom VARCHAR(50) NOT NULL,
  sexe CHAR(1) NOT NULL,
  taille INT(3) NOT NULL,
  date_naissance DATE NOT NULL,
  PRIMARY KEY (numero)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS ProprieteDe(
  numero_membre INT NOT NULL,
  numero_cheval INT NOT NULL,
  PRIMARY KEY (numero_membre, numero_cheval),
  FOREIGN KEY  (numero_membre) REFERENCES Membre(id),
  FOREIGN KEY (numero_cheval) REFERENCES Cheval(numero)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Competition(
  nom VARCHAR(50),
  libelle VARCHAR(100) NOT NULL,
  PRIMARY KEY (nom)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Obstacles(
  nom VARCHAR(50),
  nb_haies INT(3) NOT NULL,
  PRIMARY KEY (nom),
  FOREIGN KEY (nom) REFERENCES Competition(nom)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Dressage(
  nom VARCHAR(50),
  PRIMARY KEY (nom),
  FOREIGN KEY (nom) REFERENCES Competition(nom)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Ordres(
  nom VARCHAR(50) NOT NULL,
  numero INT(2),
  ordre VARCHAR(50) NOT NULL,
  PRIMARY KEY (nom, numero),
  FOREIGN KEY (nom) REFERENCES Competition(nom)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS InstanceComp(
  nom VARCHAR(50) NOT NULL,
  annee INT(4),
  id_organisateur INT NOT NULL,
  PRIMARY KEY (nom, annee),
  FOREIGN KEY (nom) REFERENCES Competition(nom),
  FOREIGN KEY (id_organisateur) REFERENCES Membre(id)
)ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Participe(
  numero_membre INT NOT NULL,
  nom VARCHAR(50) NOT NULL,
  annee INT(4) NOT NULL,
  numero_cheval INT NOT NULL,
  resultat INT(5) NOT NULL,
  PRIMARY KEY (numero_membre, nom, annee),
  FOREIGN KEY (numero_membre) REFERENCES Membre(id),
  FOREIGN KEY (nom, annee) REFERENCES InstanceComp(nom, annee),
  FOREIGN KEY (numero_cheval) REFERENCES Cheval(numero)
)ENGINE = InnoDB;

LOAD DATA LOCAL INFILE 'WWW/Data/Club.csv' INTO TABLE Club
CHARACTER SET 'UTF8'
FIELDS TERMINATED BY ';'
LINES STARTING BY '' TERMINATED BY '\n'
IGNORE 1 LINES
(numero, nom, code_postal, localite, rue, num, id_president);

LOAD DATA LOCAL INFILE 'WWW/Data/Membre.csv' INTO TABLE Membre
CHARACTER SET 'UTF8'
FIELDS TERMINATED BY ';'
LINES STARTING BY '' TERMINATED BY '\n'
IGNORE 1 LINES
(id, nom, prenom, email, id_club);

LOAD DATA LOCAL INFILE 'WWW/Data/Cheval.csv' INTO TABLE Cheval
CHARACTER SET 'UTF8'
FIELDS TERMINATED BY ';'
LINES STARTING BY '' TERMINATED BY '\n'
IGNORE 1 LINES
(numero, nom, sexe, taille, @date_naissance)
SET date_naissance = STR_TO_DATE(@date_naissance, '%Y-%m-%d');

LOAD DATA LOCAL INFILE 'WWW/Data/ProprieteDe.csv' INTO TABLE ProprieteDe
CHARACTER SET 'UTF8'
FIELDS TERMINATED BY ';'
LINES STARTING BY '' TERMINATED BY '\n'
IGNORE 1 LINES
(numero_membre, numero_cheval);

LOAD DATA LOCAL INFILE 'WWW/Data/Competition.csv' INTO TABLE Competition
CHARACTER SET 'UTF8'
FIELDS TERMINATED BY ';'
LINES STARTING BY '' TERMINATED BY '\n'
IGNORE 1 LINES
(nom, libelle);

LOAD DATA LOCAL INFILE 'WWW/Data/Obstacles.csv' INTO TABLE Obstacles
CHARACTER SET 'UTF8'
FIELDS TERMINATED BY ';'
LINES STARTING BY '' TERMINATED BY '\n'
IGNORE 1 LINES
(nom, nb_haies);

LOAD DATA LOCAL INFILE 'WWW/Data/Dressage.csv' INTO TABLE Dressage
CHARACTER SET 'UTF8'
FIELDS TERMINATED BY ';'
LINES STARTING BY '' TERMINATED BY '\n'
IGNORE 1 LINES
(nom);

LOAD DATA LOCAL INFILE 'WWW/Data/Ordres.csv' INTO TABLE Ordres
CHARACTER SET 'UTF8'
FIELDS TERMINATED BY ';'
LINES STARTING BY '' TERMINATED BY '\n'
IGNORE 1 LINES
(nom, numero, ordre);

LOAD DATA LOCAL INFILE 'WWW/Data/InstanceComp.csv' INTO TABLE InstanceComp
CHARACTER SET 'UTF8'
FIELDS TERMINATED BY ';'
LINES STARTING BY '' TERMINATED BY '\n'
IGNORE 1 LINES
(nom, annee, id_organisateur);

LOAD DATA LOCAL INFILE 'WWW/Data/Participe.csv' INTO TABLE Participe
CHARACTER SET 'UTF8'
FIELDS TERMINATED BY ';'
LINES STARTING BY '' TERMINATED BY '\n'
IGNORE 1 LINES
(numero_membre, nom, annee, numero_cheval, resultat);

