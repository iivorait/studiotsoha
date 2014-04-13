INSERT INTO asiakas (tunnus, kantaasiakas, sahkoposti, etunimi, sukunimi, lahiosoite, postinumero, postitoimipaikka, puhelinnumero, salasana) VALUES
(1, 1, 'siika@cs.helsinki.fi', 'Juhannes', 'Siika', 'Siikalantie 8', '01234', 'MUIKKULA', '04567890987', 'e1db2cc4be782c874ec0620eaba4c423'),
(2, 0, 'random@cs.helsinki.fi', 'Joku', 'Random', NULL, NULL, NULL, '057890987689', NULL),
(3, 1, 'noora@cs.helsinki.fi', 'Noora', 'Jingjang', 'Siilitie 3 AS 3', '00100', 'HELSINKI', '040789787', 'dsakljlkfjdslkfjdlksjlkjflkjsfdl');

INSERT INTO palvelu (tunnus, nimi, hinta, kesto, kuvaus) VALUES
(1, 'Hiustenleikkuu', 30.00, 60, 'Hommaa ammattitaitoinen hiustenlyhennys jo tänään'),
(2, 'Hiusten värjäys', 50.00, 120, 'Näytä kevään värit hiuksillasi'),
(3, 'Päänahan värjäys', 20.00, 60, 'Värikkäältä voi näyttää ilmankin hiuksia');

INSERT INTO tyontekija (tunnus, sahkoposti, nimi, johtaja, kuvaus, salasana) VALUES
(1, 'aino@tsoha.tld', 'Aino', 1, 'Yhteiskuntatieteiden parturi', '6847ee571ecd481af3008c76a760952e'),
(2, 'maiju@tsoha.tld', 'Maiju', 0, 'Diplomiparturi', 'djsfkjhdfjsdhfkjsdhkjfhsdkhdfs'),
(3, 'hakan@tsoha.tld', 'Håkan', 0, 'Datanomi', 'ad31c7ab755d6f397a290ef53e2eb374');

INSERT INTO palveluntarjoaja (palvelu, tyontekija) VALUES
(1, 1),
(2, 1),
(1, 2),
(2, 2),
(3, 3);

INSERT INTO tuntikirjaus (tyontekija, paivamaara, tuntimaara, kommentti) VALUES
(1, '2014-03-18', 5, NULL),
(1, '2014-03-19', 4, NULL),
(2, '2014-03-18', 4, NULL),
(2, '2014-03-19', 4, NULL),
(3, '2014-03-18', 3, NULL),
(3, '2014-03-19', 7, 'Värit kaatui lattialle, meni vähän aikaa siivotessa');

INSERT INTO varaus (tunnus, tyontekija, asiakas, paivamaara, aloitusaika, kesto, palvelu) VALUES
(1, 1, 1, '2014-03-20', '09:00:00', 240, 'permanentti', ''),
(2, 2, 3, '2014-03-20', '11:00:00', 240, 'hiusten pidennys', '30 sentin puntti'),
(3, 3, 2, '2014-03-20', '09:00:00', 180, 'hiusten höyläys', ''),
(4, 3, 1, '2014-03-20', '16:00:00', 60, 'kaljun värjäys', 'punaiseksi kiitos'),
(5, 3, 1, '2014-04-04', '15:00:00', 60, 'vaalennus', '');

