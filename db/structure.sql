-- MySQL Script generated by MySQL Workbench
-- 10/18/16 16:38:26
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema mydb
-- -----------------------------------------------------
-- -----------------------------------------------------
-- Schema packingsheets
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema packingsheets
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `packingsheets` DEFAULT CHARACTER SET utf8 ;
USE `packingsheets` ;

-- -----------------------------------------------------
-- Table `packingsheets`.`t_code`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets`.`t_code` ;

CREATE TABLE IF NOT EXISTS `packingsheets`.`t_code` (
  `code_id` INT(11) NOT NULL AUTO_INCREMENT,
  `code_label` VARCHAR(200) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`code_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets`.`t_address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets`.`t_address` ;

CREATE TABLE IF NOT EXISTS `packingsheets`.`t_address` (
  `address_id` INT(11) NOT NULL AUTO_INCREMENT,
  `address_codeId` INT(11) NOT NULL,
  `address_label` VARCHAR(500) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`address_id`),
  INDEX `fk_address_code` (`address_codeId` ASC),
  CONSTRAINT `fk_address_code`
    FOREIGN KEY (`address_codeId`)
    REFERENCES `packingsheets`.`t_code` (`code_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets`.`t_autority`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets`.`t_autority` ;

CREATE TABLE IF NOT EXISTS `packingsheets`.`t_autority` (
  `aut_id` INT(11) NOT NULL AUTO_INCREMENT,
  `aut_label` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  `aut_telNumber` VARCHAR(20) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`aut_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets`.`t_contact`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets`.`t_contact` ;

CREATE TABLE IF NOT EXISTS `packingsheets`.`t_contact` (
  `contact_id` INT(11) NOT NULL AUTO_INCREMENT,
  `contact_addressId` INT(11) NOT NULL,
  `contact_name` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  `contact_mail` VARCHAR(200) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `contact_phoneNr` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `contact_fax` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  PRIMARY KEY (`contact_id`),
  INDEX `fk_contact_address` (`contact_addressId` ASC),
  CONSTRAINT `fk_contact_address`
    FOREIGN KEY (`contact_addressId`)
    REFERENCES `packingsheets`.`t_address` (`address_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets`.`t_content`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets`.`t_content` ;

CREATE TABLE IF NOT EXISTS `packingsheets`.`t_content` (
  `cont_id` INT(11) NOT NULL AUTO_INCREMENT,
  `cont_label` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`cont_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets`.`t_currency`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets`.`t_currency` ;

CREATE TABLE IF NOT EXISTS `packingsheets`.`t_currency` (
  `curr_id` INT(11) NOT NULL AUTO_INCREMENT,
  `curr_label` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`curr_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets`.`t_customstatus`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets`.`t_customstatus` ;

CREATE TABLE IF NOT EXISTS `packingsheets`.`t_customstatus` (
  `custStat_id` INT(11) NOT NULL AUTO_INCREMENT,
  `custStat_label` VARCHAR(50) CHARACTER SET 'utf8' NOT NULL,
  `custStat_text` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`custStat_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets`.`t_imput`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets`.`t_imput` ;

CREATE TABLE IF NOT EXISTS `packingsheets`.`t_imput` (
  `imp_id` INT(11) NOT NULL AUTO_INCREMENT,
  `imp_label` VARCHAR(50) CHARACTER SET 'utf8' NOT NULL,
  `imp_text` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`imp_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets`.`t_incotermslocation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets`.`t_incotermslocation` ;

CREATE TABLE IF NOT EXISTS `packingsheets`.`t_incotermslocation` (
  `incLoc_id` INT(11) NOT NULL AUTO_INCREMENT,
  `incLoc_label` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`incLoc_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets`.`t_incotermstype`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets`.`t_incotermstype` ;

CREATE TABLE IF NOT EXISTS `packingsheets`.`t_incotermstype` (
  `incType_id` INT(11) NOT NULL AUTO_INCREMENT,
  `incType_label` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`incType_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets`.`t_memo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets`.`t_memo` ;

CREATE TABLE IF NOT EXISTS `packingsheets`.`t_memo` (
  `memo_id` INT(11) NOT NULL AUTO_INCREMENT,
  `memo_label` VARCHAR(200) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`memo_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets`.`t_packtype`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets`.`t_packtype` ;

CREATE TABLE IF NOT EXISTS `packingsheets`.`t_packtype` (
  `packType_id` INT(11) NOT NULL AUTO_INCREMENT,
  `packType_label` VARCHAR(50) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`packType_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets`.`t_priority`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets`.`t_priority` ;

CREATE TABLE IF NOT EXISTS `packingsheets`.`t_priority` (
  `prior_id` INT(11) NOT NULL AUTO_INCREMENT,
  `prior_label` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`prior_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets`.`t_service`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets`.`t_service` ;

CREATE TABLE IF NOT EXISTS `packingsheets`.`t_service` (
  `serv_id` INT(11) NOT NULL AUTO_INCREMENT,
  `serv_label` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`serv_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets`.`t_shipper`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets`.`t_shipper` ;

CREATE TABLE IF NOT EXISTS `packingsheets`.`t_shipper` (
  `ship_id` INT(11) NOT NULL AUTO_INCREMENT,
  `ship_label` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`ship_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets`.`t_packingsheet`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets`.`t_packingsheet` ;

CREATE TABLE IF NOT EXISTS `packingsheets`.`t_packingsheet` (
  `ps_id` INT(11) NOT NULL AUTO_INCREMENT,
  `ps_ref` VARCHAR(50) CHARACTER SET 'utf8' NOT NULL,
  `group_id` INT(11) NOT NULL,
  `consignedAddress_id` INT(11) NOT NULL,
  `deliveryAddress_id` INT(11) NOT NULL,
  `consignedContact_id` INT(11) NOT NULL,
  `deliveryContact_id` INT(11) NOT NULL,
  `service_id` INT(11) NOT NULL,
  `content_id` INT(11) NOT NULL,
  `priority_id` INT(11) NOT NULL,
  `shipper_id` INT(11) NOT NULL,
  `ps_yrOrder` VARCHAR(50) CHARACTER SET 'utf8' NOT NULL,
  `ps_AWB` VARCHAR(50) CHARACTER SET 'utf8' NOT NULL,
  `ps_dateIssue` DATE NOT NULL,
  `ps_collect` TINYINT(1) NULL DEFAULT NULL,
  `autority_id` INT(11) NOT NULL,
  `customStatus_id` INT(11) NOT NULL,
  `incType_id` INT(11) NOT NULL,
  `incLoc_id` INT(11) NOT NULL,
  `currency_id` INT(11) NOT NULL,
  `imput_id` INT(11) NOT NULL,
  `ps_nbrPieces` INT(11) NOT NULL,
  `ps_weight` FLOAT NOT NULL,
  `ps_totalPrice` FLOAT NOT NULL,
  `ps_signed` BIT(1) NOT NULL,
  `ps_printed` BIT(1) NOT NULL,
  `ps_memo` VARCHAR(300) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  PRIMARY KEY (`ps_id`),
  INDEX `fk_ps_service` (`service_id` ASC),
  INDEX `fk_ps_content` (`content_id` ASC),
  INDEX `fk_ps_priority` (`priority_id` ASC),
  INDEX `fk_ps_shipper` (`shipper_id` ASC),
  INDEX `fk_ps_autority` (`autority_id` ASC),
  INDEX `fk_ps_customStatus` (`customStatus_id` ASC),
  INDEX `fk_ps_incType` (`incType_id` ASC),
  INDEX `fk_ps_incLoc` (`incLoc_id` ASC),
  INDEX `fk_ps_currency` (`currency_id` ASC),
  INDEX `fk_ps_imput` (`imput_id` ASC),
  INDEX `fk_ps_consignedAddress_idx` (`consignedAddress_id` ASC),
  INDEX `fk_ps_deliveryAddress_idx` (`deliveryAddress_id` ASC),
  INDEX `fk_ps_consignedContact_idx` (`consignedContact_id` ASC),
  INDEX `fk_ps_deliveryContact_idx` (`deliveryContact_id` ASC),
  CONSTRAINT `fk_ps_autority`
    FOREIGN KEY (`autority_id`)
    REFERENCES `packingsheets`.`t_autority` (`aut_id`),
  CONSTRAINT `fk_ps_consignedAddress`
    FOREIGN KEY (`consignedAddress_id`)
    REFERENCES `packingsheets`.`t_address` (`address_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ps_consignedContact`
    FOREIGN KEY (`consignedContact_id`)
    REFERENCES `packingsheets`.`t_contact` (`contact_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ps_content`
    FOREIGN KEY (`content_id`)
    REFERENCES `packingsheets`.`t_content` (`cont_id`),
  CONSTRAINT `fk_ps_currency`
    FOREIGN KEY (`currency_id`)
    REFERENCES `packingsheets`.`t_currency` (`curr_id`),
  CONSTRAINT `fk_ps_customStatus`
    FOREIGN KEY (`customStatus_id`)
    REFERENCES `packingsheets`.`t_customstatus` (`custStat_id`),
  CONSTRAINT `fk_ps_deliveryAddress`
    FOREIGN KEY (`deliveryAddress_id`)
    REFERENCES `packingsheets`.`t_address` (`address_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ps_deliveryContact`
    FOREIGN KEY (`deliveryContact_id`)
    REFERENCES `packingsheets`.`t_contact` (`contact_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ps_imput`
    FOREIGN KEY (`imput_id`)
    REFERENCES `packingsheets`.`t_imput` (`imp_id`),
  CONSTRAINT `fk_ps_incLoc`
    FOREIGN KEY (`incLoc_id`)
    REFERENCES `packingsheets`.`t_incotermslocation` (`incLoc_id`),
  CONSTRAINT `fk_ps_incType`
    FOREIGN KEY (`incType_id`)
    REFERENCES `packingsheets`.`t_incotermstype` (`incType_id`),
  CONSTRAINT `fk_ps_priority`
    FOREIGN KEY (`priority_id`)
    REFERENCES `packingsheets`.`t_priority` (`prior_id`),
  CONSTRAINT `fk_ps_service`
    FOREIGN KEY (`service_id`)
    REFERENCES `packingsheets`.`t_service` (`serv_id`),
  CONSTRAINT `fk_ps_shipper`
    FOREIGN KEY (`shipper_id`)
    REFERENCES `packingsheets`.`t_shipper` (`ship_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets`.`t_packing`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets`.`t_packing` ;

CREATE TABLE IF NOT EXISTS `packingsheets`.`t_packing` (
  `pack_id` INT(11) NOT NULL AUTO_INCREMENT,
  `ps_id` INT(11) NOT NULL,
  `pack_netWeight` FLOAT NOT NULL,
  `pack_grossWeight` FLOAT NOT NULL,
  `pack_M1` FLOAT NOT NULL,
  `pack_M2` FLOAT NOT NULL,
  `pack_M3` FLOAT NOT NULL,
  `packType_id` INT(11) NOT NULL,
  `pack_img` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`pack_id`),
  INDEX `fk_pack_ps` (`ps_id` ASC),
  INDEX `fk_pack_packType` (`packType_id` ASC),
  CONSTRAINT `fk_pack_packType`
    FOREIGN KEY (`packType_id`)
    REFERENCES `packingsheets`.`t_packtype` (`packType_id`),
  CONSTRAINT `fk_pack_ps`
    FOREIGN KEY (`ps_id`)
    REFERENCES `packingsheets`.`t_packingsheet` (`ps_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets`.`t_part`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets`.`t_part` ;

CREATE TABLE IF NOT EXISTS `packingsheets`.`t_part` (
  `part_id` INT(11) NOT NULL AUTO_INCREMENT,
  `part_pn` VARCHAR(100) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `part_serial` VARCHAR(100) CHARACTER SET 'utf8',
  `part_desc` VARCHAR(200) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `part_price` FLOAT NOT NULL,
  `part_HSCode` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  PRIMARY KEY (`part_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets`.`t_packing_part`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets`.`t_packing_part` ;

CREATE TABLE IF NOT EXISTS `packingsheets`.`t_packing_part` (
  `pkp_id` INT(11) NOT NULL AUTO_INCREMENT,
  `pack_id` INT(11) NOT NULL,
  `part_id` INT(11) NOT NULL,
  `pkp_quantity` INT(11) NULL DEFAULT NULL,
  `pkp_origin` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  PRIMARY KEY (`pkp_id`),
  INDEX `fk_pkp_pack` (`pack_id` ASC),
  INDEX `fk_pkp_part` (`part_id` ASC),
  CONSTRAINT `fk_pkp_pack`
    FOREIGN KEY (`pack_id`)
    REFERENCES `packingsheets`.`t_packing` (`pack_id`),
  CONSTRAINT `fk_pkp_part`
    FOREIGN KEY (`part_id`)
    REFERENCES `packingsheets`.`t_part` (`part_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `packingsheets`.`t_packinglist`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets`.`t_packinglist` ;

CREATE TABLE IF NOT EXISTS `packingsheets`.`t_packinglist` (
  `pl_id` INT(11) NOT NULL AUTO_INCREMENT,
  `ps_id` INT(11) NOT NULL,
  PRIMARY KEY (`pl_id`),
  INDEX `fk_plp_ps` (`ps_id` ASC),
  CONSTRAINT `fk_plp_ps`
    FOREIGN KEY (`ps_id`)
    REFERENCES `packingsheets`.`t_packingsheet` (`ps_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `packingsheets`.`t_packinglist_part`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets`.`t_packinglist_part` ;

CREATE TABLE IF NOT EXISTS `packingsheets`.`t_packinglist_part` (
  `plp_id` INT(11) NOT NULL AUTO_INCREMENT,
  `pl_id` INT(11) NOT NULL,
  `part_id` INT(11) NOT NULL,
  `plp_quantity` INT(11) NOT NULL,
  PRIMARY KEY (`plp_id`),
  INDEX `fk_plp_pl` (`pl_id` ASC),
  INDEX `fk_plp_part` (`part_id` ASC),
  CONSTRAINT `fk_plp_pl`
    FOREIGN KEY (`pl_id`)
    REFERENCES `packingsheets`.`t_packinglist` (`pl_id`),
  CONSTRAINT `fk_plp_part`
    FOREIGN KEY (`part_id`)
    REFERENCES `packingsheets`.`t_part` (`part_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
