/*
*Gentamicene calculator
*SQL code for database creation
*Aiden MacLeod - Inverness College UHI
*/

# added staffPassword
# added result number to blood
# added dosage table

/*
*run first
*delete tables of same name to create new tables
*/

DROP TABLE IF EXISTS patientInfo;
DROP TABLE IF EXISTS staff;
DROP TABLE IF EXISTS dosage;
DROP TABLE IF EXISTS dosagesDue;
DROP TABLE IF EXISTS bloods;
DROP TABLE IF EXISTS records;
DROP TRIGGER IF EXISTS updateRecord;

/*
*Table : Patient table
*/
CREATE TABLE patientInfo (
  patientID int(5),
  patientFirstName varchar(50),
  patientLastName varchar(50),
  patientWeight int(3),
  patientDOB DATE,
  patientHeight int(3),
  patientCurrentWard varchar(10),
  patientGender Char(1),
  PRIMARY KEY (patientID)
);

/*
*Table : Dosage table
*/
CREATE TABLE dosage (
  patientID int(5),
  dosage int(3),
  hourlyRate int(3),
  PRIMARY KEY (patientID)
);

/*
*Table : Blood tests/results table
*/
CREATE TABLE bloods (
  patientBloodResultNumber VARCHAR(10),
  patientID int(5),
  patientBloodTakenDate DATE,
#   patientBloodTakenBy int(3),
#   patientBloodRecievedBy int(5),
#   patientBloodResultsEnteredBy int(5),
#   patientBloodResultsEnteredDate DATE,
  patientPlasmaCreatinine DOUBLE(3,1),
  PRIMARY KEY (patientBloodResultNumber)
);

/*
*Table : Dosage Information
*/
CREATE TABLE dosagesDue (
  patientID int(5),
#   patientDosageGivenDate DATE,
  patientDosageDue DATETIME,
  patientDosageHourlyRate int(3),
  patientDosage int(3),
#   patientDosageGivenBy int(5),
#   patientDoseGivenWard VARCHAR(10),
#   prescriptionID varchar(10),
  PRIMARY KEY (patientID)#,patientDosageGivenDate)
);

/*
*Table : Staff Info
*/

CREATE TABLE staff (
  staffID int,
  staffTitle VARCHAR(80),
  staffFirstName VARCHAR(80),
  staffLastName VARCHAR(80),
  staffRole CHAR(25),
  staffPassword VARCHAR(256),
  PRIMARY KEY (staffID)
);

/*
*Table: Records Table
*/

CREATE TABLE records (
#   recordID int(5),
  patientID int(5),
  recordDosageGivenDate DATETIME,
  recordDosageDue DATETIME,
  recordDosageGivenAmount int(3),
  recordDosageGivenBy int(5),
  recordDoseGivenWard VARCHAR(10),
#   recordPrescriptionID VARCHAR(10),
  PRIMARY KEY (patientID,recordDosageGivenDate)
);

/*
*Trigger : Complete Dosage
*Not functioning properly
*Suggest using a php query to do the same
*/

# CREATE TRIGGER `updateRecord`
# BEFORE DELETE ON `dosages`
# FOR EACH ROW
# BEGIN
#   INSERT INTO records VALUES (
#     (SELECT * FROM dosages
#      WHERE patientID = '1'
#      AND patientDosageGivenDate = 'blah')
#   );
# END;

# CREATE TRIGGER updateRecord
# BEFORE DELETE ON dosages
# FOR EACH ROW
# BEGIN
#   INSERT INTO records
#     SELECT * FROM dosages WHERE Transaction_status = 2;
#   DELETE FROM dosages WHERE Transaction_status = 2;
# END;

/* Sample data */
INSERT INTO patientInfo VALUES ('12345','John','Doe','190','1956-02-01','156','Ward 1','M');
INSERT INTO patientInfo VALUES ('32641','Jane','Doe','140','1943-04-09','147','Ward 2','F');
INSERT INTO patientInfo VALUES ('95632','Henry','Hippo','148','1932-05-04','132','Ward 1','M');
INSERT INTO patientInfo VALUES ('25845','Harry','Happy','80','1951-12-12','110','Ward','M');

# INSERT INTO bloods VALUES ('12345','2018-01-01','123','421','421','2018-01-03','21.1');
# INSERT INTO bloods VALUES ('95632','2018-04-06','123','421','421','2018-04-08','14.2');
# INSERT INTO bloods VALUES ('25845','2018-03-02','321','421','421','2018-03-05','36.3');

INSERT INTO staff VALUES ('123','Dr','Bill','Lee','Doctor','test');
INSERT INTO staff VALUES ('321','Dr','Bob','Bing','Doctor','test');
INSERT INTO staff VALUES ('421','Dr','Bonnie','Lass','LabWorker','test');