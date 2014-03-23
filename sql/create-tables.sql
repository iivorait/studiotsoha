CREATE TABLE tyontekija
(
    tunnus int(11) NOT NULL AUTO_INCREMENT,
    sahkoposti varchar(100) NOT NULL,
    nimi varchar(100) NOT NULL,
    johtaja tinyint(1) NOT NULL DEFAULT 0,
    kuvaus varchar(200),
    salasana char(32) NOT NULL,
    PRIMARY KEY (tunnus),
    UNIQUE KEY sahkoposti (sahkoposti)
);

CREATE TABLE tuntikirjaus
(
    tyontekija int(11) NOT NULL,
    paivamaara date NOT NULL,
    tuntimaara int(11) NOT NULL,
    kommentti varchar(200),
    PRIMARY KEY (tyontekija, paivamaara),
    FOREIGN KEY (tyontekija) REFERENCES tyontekija (tunnus)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE palvelu
(
    tunnus int(11) NOT NULL AUTO_INCREMENT,
    nimi varchar(100) NOT NULL,
    hinta decimal(5,2) NOT NULL,
    kesto int(11) NOT NULL,
    kuvaus text,
    PRIMARY KEY (tunnus)
);

CREATE TABLE palveluntarjoaja
(
    palvelu int(11) NOT NULL,
    tyontekija int(11) NOT NULL,
    PRIMARY KEY (palvelu, tyontekija),
    FOREIGN KEY (palvelu) REFERENCES palvelu (tunnus)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (tyontekija) REFERENCES tyontekija (tunnus)
        ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE asiakas
(
    tunnus int(11) NOT NULL AUTO_INCREMENT,
    kantaasiakas tinyint(1) NOT NULL DEFAULT 0,
    sahkoposti varchar(100) NOT NULL,
    etunimi varchar(100) NOT NULL,
    sukunimi varchar(100) NOT NULL,
    lahiosoite varchar(100),
    postinumero char(5),
    postitoimipaikka varchar(50),
    puhelinnumero varchar(20) NOT NULL,
    salasana char(32),
    PRIMARY KEY (tunnus)
);

CREATE TABLE varaus
(
    tunnus int(11) NOT NULL AUTO_INCREMENT,
    tyontekija int(11) NOT NULL,
    asiakas int(11) NOT NULL,
    paivamaara date NOT NULL,
    aloitusaika time NOT NULL,
    kesto int(11) NOT NULL,
    palvelu varchar(100) NOT NULL,
    PRIMARY KEY (tunnus),
    FOREIGN KEY (tyontekija) REFERENCES tyontekija (tunnus)
        ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (asiakas) REFERENCES asiakas (tunnus)
        ON DELETE CASCADE ON UPDATE CASCADE
);