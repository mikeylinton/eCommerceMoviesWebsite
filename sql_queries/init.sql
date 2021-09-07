CREATE DATABASE IF NOT EXISTS movieWebsite;

USE movieWebsite;

CREATE TABLE IF NOT EXISTS `Customers` (
	`cID` INT NOT NULL UNIQUE AUTO_INCREMENT,
	`cTitle` VARCHAR(3) NOT NULL CHECK (cTitle IN ('Mr', 'Mrs', 'Ms', 'Mx', 'Dr', 'Rev')),
	`cSurname` VARCHAR(255) NOT NULL,
	`cForename` VARCHAR(255) NOT NULL,
	`cEmail` VARCHAR(255) NOT NULL,
	`cPhoneNumber` VARCHAR(255) NOT NULL,
	`cAddressLine1` VARCHAR(255) NOT NULL,
	`cAddressLine2` VARCHAR(255) NOT NULL,
	`cCity` VARCHAR(255) NOT NULL,
	`cPostcode` VARCHAR(8) NOT NULL,
	PRIMARY KEY (`cID`)
);

CREATE TABLE IF NOT EXISTS `Movies` (
	`mID`	INTEGER NOT NULL UNIQUE AUTO_INCREMENT,
	`mName`	TEXT NOT NULL,
	`mDescription`	TEXT,
	`mGenre` VARCHAR(255) NOT NULL,
	`mRating` VARCHAR(255),
	`mYear`	SMALLINT,
	`mRuntime` SMALLINT,
	`mLanguage` VARCHAR(255),
	`mCountry` VARCHAR(255),
	`mDirector` VARCHAR(255),
	`mWriter` VARCHAR(255),
	`mActors` VARCHAR(255),
	`mPrice` DECIMAL(3, 2) NOT NULL,
	PRIMARY KEY(`mID`)
);

CREATE TABLE IF NOT EXISTS `Transactions` (
	`tID` INT NOT NULL UNIQUE AUTO_INCREMENT,
	`mID` INT NOT NULL,
	`cID` INT NOT NULL,
	`tDate` DATE,
    `tTime` TIME,
	FOREIGN KEY (`mID`) REFERENCES `Movies` (`mID`),
	FOREIGN KEY (`cID`) REFERENCES `Customers` (`cID`),
	PRIMARY KEY (`tID`)
);


CREATE TABLE IF NOT EXISTS `Reviews` (
	`mID` INT NOT NULL,
	`cID` INT NOT NULL,
	`rTitle` VARCHAR(255) NOT NULL,
	`rBody` TEXT NOT NULL,
	`rRating` TINYINT NOT NULL,
	FOREIGN KEY (`mID`) REFERENCES `Movies` (`mID`),
	FOREIGN KEY (`cID`) REFERENCES `Customers` (`cID`),
	PRIMARY KEY (`mID`, `cID`)
);
					
CREATE TABLE IF NOT EXISTS `Surveys` (
	`cID` INT NOT NULL,
	`sChurn` DECIMAL(2, 2),
	`sAge` VARCHAR(8),
	`sIncome` VARCHAR(64),
	`sGender` VARCHAR(64),
	`sEmployment` VARCHAR(64),
	`sRelationship` VARCHAR(64),
	`sSexuality` VARCHAR(64),
	`sGenre` VARCHAR(64) NOT NULL,
	`sSelection` TINYINT NOT NULL,
	`sPricing` TINYINT NOT NULL,
	`sSuggestions` TINYINT NOT NULL,
	`sUsability` TINYINT NOT NULL,
	`sRecommend` TINYINT NOT NULL,
	FOREIGN KEY (`cID`) REFERENCES `Customers` (`cID`),
	PRIMARY KEY (`cID`)
);
