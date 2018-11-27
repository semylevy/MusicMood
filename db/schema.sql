-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `mydb` DEFAULT CHARACTER SET utf8 ;
USE `mydb` ;

-- -----------------------------------------------------
-- Table `mydb`.`User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`User` (
  `idUser` INT NOT NULL AUTO_INCREMENT,
  `imageUser` VARCHAR(128) NOT NULL,
  `nameUser` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idUser`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Song`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Song` (
  `idSong` INT NOT NULL AUTO_INCREMENT,
  `genreSong` VARCHAR(45) NOT NULL,
  `videoSong` VARCHAR(128) NOT NULL,
  `nameSong` VARCHAR(45) NULL,
  PRIMARY KEY (`idSong`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Like`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Like` (
  `User_idUser` INT NOT NULL,
  `Song_idSong` INT NOT NULL,
  `dateLike` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`User_idUser`, `Song_idSong`),
  INDEX `fk_Song_User_idx` (`User_idUser` ASC),
  INDEX `fk_Likes_Song1_idx` (`Song_idSong` ASC),
  CONSTRAINT `fk_Song_User`
    FOREIGN KEY (`User_idUser`)
    REFERENCES `mydb`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Likes_Song1`
    FOREIGN KEY (`Song_idSong`)
    REFERENCES `mydb`.`Song` (`idSong`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Photo`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Photo` (
  `idPhoto` INT NOT NULL AUTO_INCREMENT,
  `User_idUser` INT NOT NULL,
  `datePhoto` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  `urlPhoto` VARCHAR(128) NULL,
  PRIMARY KEY (`idPhoto`, `User_idUser`),
  INDEX `fk_Photo_User1_idx` (`User_idUser` ASC),
  CONSTRAINT `fk_Photo_User1`
    FOREIGN KEY (`User_idUser`)
    REFERENCES `mydb`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Emotion`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Emotion` (
  `idEmotion` INT NOT NULL,
  `nameEmotion` VARCHAR(45) NULL,
  `emojiEmotion` VARCHAR(45) NULL,
  PRIMARY KEY (`idEmotion`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `mydb`.`Feel`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`Feel` (
  `User_idUser` INT NOT NULL,
  `Emotion_idEmotion` INT NOT NULL,
  `dateMood` DATETIME NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`User_idUser`, `Emotion_idEmotion`),
  INDEX `fk_Mood_User1_idx` (`User_idUser` ASC),
  INDEX `fk_Feel_Emotion1_idx` (`Emotion_idEmotion` ASC),
  CONSTRAINT `fk_Mood_User1`
    FOREIGN KEY (`User_idUser`)
    REFERENCES `mydb`.`User` (`idUser`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Feel_Emotion1`
    FOREIGN KEY (`Emotion_idEmotion`)
    REFERENCES `mydb`.`Emotion` (`idEmotion`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
