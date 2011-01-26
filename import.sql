SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

CREATE SCHEMA IF NOT EXISTS `dory` DEFAULT CHARACTER SET latin1 ;
USE `dory`;

-- -----------------------------------------------------
-- Table `dory`.`pages`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `dory`.`pages` (
  `title` VARCHAR(200) NOT NULL ,
  `file` VARCHAR(10) NOT NULL ,
  `id` INT(3) NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
AUTO_INCREMENT = 3
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `dory`.`posts`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `dory`.`posts` (
  `title` VARCHAR(200) NOT NULL ,
  `id` INT(4) NOT NULL AUTO_INCREMENT ,
  `author` VARCHAR(200) NOT NULL ,
  `file` VARCHAR(10) NOT NULL ,
  `time` INT(10) NOT NULL ,
  `category` VARCHAR(50) NOT NULL ,
  `views` INT(5) NOT NULL ,
  `publish` INT(11) NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = MyISAM
AUTO_INCREMENT = 8
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `dory`.`users`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `dory`.`users` (
  `email` VARCHAR(200) NOT NULL ,
  `role` VARCHAR(30) NOT NULL ,
  `password` VARCHAR(32) NOT NULL ,
  `name` VARCHAR(200) NOT NULL ,
  `url1` VARCHAR(500) NOT NULL ,
  `url2` VARCHAR(500) NOT NULL ,
  `url3` VARCHAR(500) NOT NULL ,
  `aboutme` TEXT NOT NULL ,
  `uid` INT(4) NOT NULL AUTO_INCREMENT ,
  PRIMARY KEY (`uid`) )
ENGINE = MyISAM
AUTO_INCREMENT = 2
DEFAULT CHARACTER SET = latin1;


-- -----------------------------------------------------
-- Table `dory`.`UserRole`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `dory`.`UserRole` (
  `idUserRole` INT NOT NULL ,
  `Role` VARCHAR(45) NULL ,
  PRIMARY KEY (`idUserRole`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dory`.`User`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `dory`.`User` (
  `ID_User` INT NOT NULL ,
  `email` VARCHAR(50) NULL ,
  `UserRole_idUserRole` INT NOT NULL ,
  PRIMARY KEY (`ID_User`) ,
  INDEX `fk_User_UserRole` (`UserRole_idUserRole` ASC) ,
  CONSTRAINT `fk_User_UserRole`
    FOREIGN KEY (`UserRole_idUserRole` )
    REFERENCES `dory`.`UserRole` (`idUserRole` )
    ON DELETE SET NULL
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dory`.`Posts`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `dory`.`Posts` (
  `idPosts` INT NOT NULL ,
  `relAuthor` INT NOT NULL ,
  `strFile` VARCHAR(45) NULL ,
  `datTimeCreated` DATE NULL ,
  `relUserRole` INT NOT NULL ,
  `datTimeModified` DATE NULL ,
  `isPublished` TINYINT(1) NULL ,
  `iViews` BIGINT NULL ,
  `strTitle` VARCHAR(500) NULL ,
  PRIMARY KEY (`idPosts`) ,
  INDEX `fk_Posts_User1` (`relAuthor` ASC) ,
  INDEX `fk_Posts_UserRole1` (`relUserRole` ASC) ,
  CONSTRAINT `fk_Posts_User1`
    FOREIGN KEY (`relAuthor` )
    REFERENCES `dory`.`User` (`ID_User` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Posts_UserRole1`
    FOREIGN KEY (`relUserRole` )
    REFERENCES `dory`.`UserRole` (`idUserRole` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dory`.`Category`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `dory`.`Category` (
  `idCategory` INT NOT NULL ,
  `Posts_idPosts` INT NOT NULL ,
  `strCategory` VARCHAR(50) NULL ,
  PRIMARY KEY (`idCategory`, `Posts_idPosts`) ,
  INDEX `fk_Category_Posts1` (`Posts_idPosts` ASC) ,
  CONSTRAINT `fk_Category_Posts1`
    FOREIGN KEY (`Posts_idPosts` )
    REFERENCES `dory`.`Posts` (`idPosts` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dory`.`Comments`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `dory`.`Comments` (
  `idComments` INT NOT NULL ,
  `strName` VARCHAR(200) NULL ,
  `strEMail` VARCHAR(500) NULL ,
  `strComment` TEXT NULL ,
  `Posts_idPosts` INT NOT NULL ,
  PRIMARY KEY (`idComments`) ,
  INDEX `fk_Comments_Posts1` (`Posts_idPosts` ASC) ,
  CONSTRAINT `fk_Comments_Posts1`
    FOREIGN KEY (`Posts_idPosts` )
    REFERENCES `dory`.`Posts` (`idPosts` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `dory`.`UserURLs`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `dory`.`UserURLs` (
  `idUserURLs` INT NOT NULL ,
  `User_ID_User` INT NOT NULL ,
  `strUrl` VARCHAR(1024) NULL ,
  PRIMARY KEY (`idUserURLs`) ,
  INDEX `fk_UserURLs_User1` (`User_ID_User` ASC) ,
  CONSTRAINT `fk_UserURLs_User1`
    FOREIGN KEY (`User_ID_User` )
    REFERENCES `dory`.`User` (`ID_User` )
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
