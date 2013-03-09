SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `gradesheet` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ;
USE `gradesheet` ;

-- -----------------------------------------------------
-- Table `gradesheet`.`semester`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `gradesheet`.`semester` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `semester` TINYINT NULL ,
  `school_year` VARCHAR(4) NULL ,
  `description` VARCHAR(45) NULL ,
  `date_created` DATETIME NULL ,
  `date_last_modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gradesheet`.`subject`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `gradesheet`.`subject` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `short_name` VARCHAR(15) NULL ,
  `description` VARCHAR(45) NULL ,
  `date_created` DATETIME NULL ,
  `date_last_modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gradesheet`.`offer`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `gradesheet`.`offer` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `subject_id` INT NOT NULL ,
  `code` VARCHAR(5) NOT NULL ,
  `name` VARCHAR(45) NOT NULL ,
  `description` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_Offer_Subject1_idx` (`subject_id` ASC) ,
  CONSTRAINT `fk_Offer_Subject1`
    FOREIGN KEY (`subject_id` )
    REFERENCES `gradesheet`.`subject` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gradesheet`.`semester_offer`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `gradesheet`.`semester_offer` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `semester_id` INT NOT NULL ,
  `offer_id` INT NOT NULL ,
  `date_created` DATETIME NULL ,
  `date_last_modified` TIMESTAMP NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_semester_offer_semester1_idx` (`semester_id` ASC) ,
  INDEX `fk_semester_offer_offer1_idx` (`offer_id` ASC) ,
  CONSTRAINT `fk_semester_offer_semester1`
    FOREIGN KEY (`semester_id` )
    REFERENCES `gradesheet`.`semester` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_semester_offer_offer1`
    FOREIGN KEY (`offer_id` )
    REFERENCES `gradesheet`.`offer` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gradesheet`.`country`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `gradesheet`.`country` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(45) NULL ,
  `abbreviation` VARCHAR(5) NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gradesheet`.`province`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `gradesheet`.`province` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `country_id` INT NOT NULL ,
  `name` VARCHAR(45) NULL ,
  `abbreviation` VARCHAR(5) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_State_Country1_idx` (`country_id` ASC) ,
  CONSTRAINT `fk_State_Country1`
    FOREIGN KEY (`country_id` )
    REFERENCES `gradesheet`.`country` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gradesheet`.`account`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `gradesheet`.`account` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(45) NOT NULL ,
  `password` VARCHAR(45) NOT NULL ,
  `date_added` DATE NULL ,
  `_active` TINYINT(1) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gradesheet`.`profile`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `gradesheet`.`profile` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `first_name` VARCHAR(45) NULL ,
  `middle_name` VARCHAR(45) NULL ,
  `last_name` VARCHAR(45) NULL ,
  `email_address` VARCHAR(255) NULL ,
  `address_1` VARCHAR(45) NULL ,
  `address_2` VARCHAR(45) NULL ,
  `city` VARCHAR(45) NULL ,
  `zip_code` VARCHAR(10) NULL ,
  `province_id` INT NOT NULL DEFAULT 1 ,
  `country_id` INT NOT NULL DEFAULT 1 ,
  `home_phone` VARCHAR(10) NULL ,
  `mobile_phone` VARCHAR(10) NULL ,
  `date_created` DATETIME NULL ,
  `date_last_modified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
  `_active` TINYINT(1) NOT NULL DEFAULT 1 ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_profile_province1_idx` (`province_id` ASC) ,
  INDEX `fk_profile_country1_idx` (`country_id` ASC) ,
  INDEX `fk_profile_user1_idx` (`user_id` ASC) ,
  CONSTRAINT `fk_profile_province1`
    FOREIGN KEY (`province_id` )
    REFERENCES `gradesheet`.`province` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_profile_country1`
    FOREIGN KEY (`country_id` )
    REFERENCES `gradesheet`.`country` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_profile_user1`
    FOREIGN KEY (`user_id` )
    REFERENCES `gradesheet`.`account` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gradesheet`.`adviser`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `gradesheet`.`adviser` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `profile_id` INT NOT NULL ,
  `date_hired` DATE NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_adviser_profile1_idx` (`profile_id` ASC) ,
  CONSTRAINT `fk_adviser_profile1`
    FOREIGN KEY (`profile_id` )
    REFERENCES `gradesheet`.`profile` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gradesheet`.`class`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `gradesheet`.`class` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `term_offer_id` INT NOT NULL ,
  `adviser_id` INT NOT NULL ,
  `location` VARCHAR(45) NULL ,
  `schedule` VARCHAR(45) NULL ,
  `date_created` DATETIME NULL ,
  `date_last_modified` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_Classes_Terms_has_Offers1_idx` (`term_offer_id` ASC) ,
  INDEX `fk_class_adviser1_idx` (`adviser_id` ASC) ,
  CONSTRAINT `fk_Classes_Terms_has_Offers1`
    FOREIGN KEY (`term_offer_id` )
    REFERENCES `gradesheet`.`semester_offer` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_class_adviser1`
    FOREIGN KEY (`adviser_id` )
    REFERENCES `gradesheet`.`adviser` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gradesheet`.`student`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `gradesheet`.`student` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `profile_id` INT NOT NULL ,
  `date_registered` DATE NULL ,
  `_active` TINYINT(1) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_student_profile1_idx` (`profile_id` ASC) ,
  CONSTRAINT `fk_student_profile1`
    FOREIGN KEY (`profile_id` )
    REFERENCES `gradesheet`.`profile` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gradesheet`.`enrollment`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `gradesheet`.`enrollment` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `student_id` INT NOT NULL ,
  `semester_id` INT NOT NULL ,
  `date_enrolled` DATE NULL ,
  INDEX `fk_student_has_semester_semester1_idx` (`semester_id` ASC) ,
  INDEX `fk_student_has_semester_student1_idx` (`student_id` ASC) ,
  PRIMARY KEY (`id`) ,
  CONSTRAINT `fk_student_has_semester_student1`
    FOREIGN KEY (`student_id` )
    REFERENCES `gradesheet`.`student` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_student_has_semester_semester1`
    FOREIGN KEY (`semester_id` )
    REFERENCES `gradesheet`.`semester` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gradesheet`.`enrollment_class`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `gradesheet`.`enrollment_class` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `class_id` INT NOT NULL ,
  `enrollment_id` INT NOT NULL ,
  `class_standing_id` INT NOT NULL ,
  `date_added` DATETIME NULL ,
  `_dropped` TINYINT(1) NOT NULL DEFAULT 0 ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_Classes_has_Students_Classes1_idx` (`class_id` ASC) ,
  INDEX `fk_class_student_enrollment1_idx` (`enrollment_id` ASC) ,
  CONSTRAINT `fk_Classes_has_Students_Classes1`
    FOREIGN KEY (`class_id` )
    REFERENCES `gradesheet`.`class` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_class_student_enrollment1`
    FOREIGN KEY (`enrollment_id` )
    REFERENCES `gradesheet`.`enrollment` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gradesheet`.`term`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `gradesheet`.`term` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `class_id` INT NOT NULL ,
  `date_start` DATE NULL ,
  `date_end` DATE NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_Term_Class1_idx` (`class_id` ASC) ,
  CONSTRAINT `fk_Term_Class1`
    FOREIGN KEY (`class_id` )
    REFERENCES `gradesheet`.`class` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gradesheet`.`term_requirement`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `gradesheet`.`term_requirement` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `term_id` INT NOT NULL ,
  `requirement_type_id` INT NOT NULL ,
  `description` VARCHAR(45) NULL ,
  `weight` INT NULL ,
  `notes` VARCHAR(45) NULL ,
  `order_id` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_TermRequirement_Term1_idx` (`term_id` ASC) ,
  CONSTRAINT `fk_TermRequirement_Term1`
    FOREIGN KEY (`term_id` )
    REFERENCES `gradesheet`.`term` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gradesheet`.`term_requiement_item`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `gradesheet`.`term_requiement_item` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `term_requirement_id` INT NOT NULL ,
  `description` VARCHAR(45) NULL ,
  `total_score` INT NULL ,
  `passing_percentage` INT NULL DEFAULT 75 ,
  `weight` INT NULL ,
  `_valid` TINYINT(1) NULL DEFAULT 1 ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_term_requiement_item_term_requirement1_idx` (`term_requirement_id` ASC) ,
  CONSTRAINT `fk_term_requiement_item_term_requirement1`
    FOREIGN KEY (`term_requirement_id` )
    REFERENCES `gradesheet`.`term_requirement` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `gradesheet`.`enrollment_requirement`
-- -----------------------------------------------------
CREATE  TABLE IF NOT EXISTS `gradesheet`.`enrollment_requirement` (
  `enrollment_class_id` INT NOT NULL ,
  `term_requiement_item_id` INT NOT NULL ,
  `score` INT NULL ,
  `notes` VARCHAR(45) NULL ,
  PRIMARY KEY (`enrollment_class_id`, `term_requiement_item_id`) ,
  INDEX `fk_enrollment_class_has_term_requiement_item_term_requiemen_idx` (`term_requiement_item_id` ASC) ,
  INDEX `fk_enrollment_class_has_term_requiement_item_enrollment_cla_idx` (`enrollment_class_id` ASC) ,
  CONSTRAINT `fk_enrollment_class_has_term_requiement_item_enrollment_class1`
    FOREIGN KEY (`enrollment_class_id` )
    REFERENCES `gradesheet`.`enrollment_class` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_enrollment_class_has_term_requiement_item_term_requiement_1`
    FOREIGN KEY (`term_requiement_item_id` )
    REFERENCES `gradesheet`.`term_requiement_item` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `gradesheet` ;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
