-- Set up the database

SHOW DATABASES;
USE assign2db; 

-- ----------
-- Question 1
-- ----------

SELECT * FROM hospital;

-- St. Joseph
UPDATE hospital SET headdoc = 'GD56', headdocstartdate = '2010-12-19' WHERE hoscode = 'BBC';
-- Victoria London
UPDATE hospital SET headdoc = 'SE66', headdocstartdate = '2004-05-30' WHERE hoscode = 'ABC';
-- Victoria Victoria
UPDATE hospital SET headdoc = 'YT67', headdocstartdate = '2001-06-01' WHERE hoscode = 'DDE';

SELECT * FROM hospital;

-- ----------
-- Question 2
-- ----------

-- Insert
INSERT INTO doctor VALUES ('TT80','Johnny', 'Sins','2000-05-17', '1979-12-03','ABC','ENT');

INSERT INTO patient VALUES ('746582967','Brad','Pitt','1963-12-18');

INSERT INTO looksafter VALUES ('TT80','746582967');

INSERT INTO hospital VALUES ('BTO','Lions Gate', 'Vancouver', 'BC', 268, 'TT80', '2022-10-15');

-- Verify
SELECT * FROM doctor WHERE licensenum = 'TT80';

SELECT * FROM patient WHERE firstname = 'Brad' AND lastname = 'Pitt';

SELECT * FROM looksafter WHERE licensenum = 'TT80';

SELECT * FROM hospital WHERE hoscode = 'BTO';

-- ----------
-- Question 3
-- ----------

-- 1
SELECT lastname FROM patient;

-- 2
SELECT DISTINCT lastname FROM patient;

-- 3
SELECT * FROM doctor ORDER BY lastname ASC;

-- 4
SELECT hosname, hoscode FROM hospital WHERE numofbed > 1500;

-- 5
SELECT firstname, lastname FROM doctor where hosworksat = (SELECT hoscode FROM hospital WHERE hosname = 'St. Joseph');

-- 6
SELECT firstname, lastname FROM patient WHERE lastname LIKE 'G%';

-- 7
SELECT firstname, lastname FROM patient WHERE ohipnum IN (SELECT ohipnum FROM looksafter WHERE licensenum = (SELECT licensenum FROM doctor WHERE lastname = 'Webster'));

-- 8
SELECT hosname, city, lastname FROM hospital, doctor WHERE headdoc = licensenum;

-- 9
SELECT SUM(numofbed) FROM hospital;

-- 10
SELECT patient.firstname, patient.lastname, doctor.firstname, doctor.lastname, doctor.licensenum, patient.ohipnum FROM patient, doctor, looksafter, hospital WHERE patient.ohipnum = looksafter.ohipnum AND doctor.licensenum = looksafter.licensenum AND doctor.licensenum = hospital.headoc;

-- 11
SELECT firstname, lastname, prov FROM doctor, hospital WHERE speciality = 'Surgeon' AND hosworksat IN (SELECT hoscode FROM hospital WHERE hosname = 'Victoria') AND hosworksat = hoscode;

-- 12
SELECT firstname from doctor WHERE licensenum NOT IN (SELECT DISTINCT licensenum FROM looksafter);

-- 13

-- 14
SELECT firstname, lastname FROM doctor, hospital WHERE doctor.licensenum = hospital.headdoc AND NOT doctor.hosworksat = hospital.hoscode;

-- 15
-- Display first and last name of Doc if they have been head doc for 10+ years
SELECT firstname, lastname FROM doctor, hospital WHERE doctor.licensenum = hospital.headdoc AND headdocstartdate < '2012-01-01';


-- ----------
-- Question 4
-- ----------

-- create view
CREATE VIEW of_your_choice AS SELECT doctor.firstname AS dfname, doctor.lastname as dlname, doctor.birthdate as dbday, patient.firstname AS pfname, patient.lastname as plname, patient.birthdate as pbday FROM doctor, patient, looksafter WHERE patient.ohipnum = looksafter.ohipnum AND doctor.licensenum = looksafter.licensenum;

-- verify
SELECT * FROM of_your_choice;

-- doctor younger than patient
SELECT dlname, dbday, plname, pbday FROM of_your_choice WHERE dbday > pbday;

-- patient info
SELECT * FROM patient;

-- looksafter info
SELECT * FROM looksafter;

-- delete custom patient
DELETE FROM patient WHERE firstname = 'Brad' AND lastname = 'Pitt';

-- verify delete
SELECT * FROM patient WHERE firstname = 'Brad' AND lastname = 'Pitt';
SELECT * FROM looksafter WHERE ohipnum = '746582967';

-- doctor info
SELECT * FROM doctor;

-- delete Bernie
DELETE FROM doctor WHERE firsname = 'Bernie';

-- verify delete
SELECT * FROM doctor WHERE firstname = 'Bernie';

-- delete custom doctor
DELETE FROM doctor WHERE firstname = 'Johnny' AND lastname = 'Sins';
-- cannot delete due to foreign key in looksafter table that has RESTRICT keyword on delete and the doctor we are deleting has a reference in the looksafter table.

