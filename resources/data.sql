INSERT INTO `owner`
VALUES (1, 'George', 'Franklin', '110 W. Liberty St.', 'Madison', '6085551023'),
	(2, 'Betty', 'Davis', '638 Cardinal Ave.', 'Sun Prairie', '6085551749'),
	(3, 'Eduardo', 'Rodriquez', '2693 Commerce St.', 'McFarland', '6085558763'),
	(4, 'Harold', 'Davis', '563 Friendly St.', 'Windsor', '6085553198'),
	(5, 'Peter', 'McTavish', '2387 S. Fair Way', 'Madison', '6085552765'),
	(6, 'Jean', 'Coleman', '105 N. Lake St.', 'Monona', '6085552654'),
	(7, 'Jeff', 'Black', '1450 Oak Blvd.', 'Monona', '6085555387'),
	(8, 'Maria', 'Escobito', '345 Maple St.', 'Madison', '6085557683'),
	(9, 'David', 'Schroeder', '2749 Blackhawk Trail', 'Madison', '6085559435'),
	(10, 'Carlos', 'Estaban', '2335 Independence La.', 'Waunakee', '6085555487');

INSERT INTO `pet`
VALUES (1, 1, 1, 'Leo', '2000-09-07'),
	(2, 2, 6, 'Basil', '2002-08-06'),
	(3, 3, 2, 'Rosy', '2001-04-17'),
	(4, 3, 2, 'Jewel', '2000-03-07'),
	(5, 4, 3, 'Iggy', '2000-11-30'),
	(6, 5, 4, 'George', '2000-01-20'),
	(7, 6, 1, 'Samantha', '1995-09-04'),
	(8, 6, 1, 'Max', '1995-09-04'),
	(9, 7, 5, 'Lucky', '1999-08-06'),
	(10, 8, 2, 'Mulligan', '1997-02-24'),
	(11, 9, 5, 'Freddy', '2000-03-09'),
	(12, 10, 2, 'Lucky', '2000-06-24'),
	(13, 10, 1, 'Sly', '2002-06-08');

INSERT INTO `pet_type`
VALUES (5, 'bird'),
	(1, 'cat'),
	(2, 'dog'),
	(6, 'hamster'),
	(3, 'lizard'),
	(4, 'snake');

INSERT INTO `specialty`
VALUES (3, 'dentistry'),
	(1, 'radiology'),
	(2, 'surgery');

INSERT INTO `vet`
VALUES (1, 'James', 'Carter'),
	(2, 'Helen', 'Leary'),
	(3, 'Linda', 'Douglas'),
	(4, 'Rafael', 'Ortega'),
	(5, 'Henry', 'Stevens'),
	(6, 'Sharon', 'Jenkins');

INSERT INTO `vet_specialty`
VALUES (2, 1),
	(5, 1),
	(3, 2),
	(4, 2),
	(3, 3);

INSERT INTO `visit`
VALUES (1, 7, '2010-03-04', 'rabies shot'),
	(2, 8, '2011-03-04', 'rabies shot'),
	(3, 8, '2009-06-04', 'neutered'),
	(4, 7, '2008-09-04', 'spayed');
