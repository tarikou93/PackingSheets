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
-- Schema packingsheets_dev
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema packingsheets_dev
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `packingsheets_dev` DEFAULT CHARACTER SET utf8 ;
USE `packingsheets_dev` ;

-- -----------------------------------------------------
-- Table `packingsheets_dev`.`t_code`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets_dev`.`t_code` ;

CREATE TABLE IF NOT EXISTS `packingsheets_dev`.`t_code` (
  `code_id` INT(11) NOT NULL AUTO_INCREMENT,
  `code_label` VARCHAR(200) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`code_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets_dev`.`t_address`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets_dev`.`t_address` ;

CREATE TABLE IF NOT EXISTS `packingsheets_dev`.`t_address` (
  `address_id` INT(11) NOT NULL AUTO_INCREMENT,
  `address_codeId` INT(11) NOT NULL,
  `address_label` VARCHAR(500) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`address_id`),
  INDEX `fk_address_code` (`address_codeId` ASC),
  CONSTRAINT `fk_address_code`
    FOREIGN KEY (`address_codeId`)
    REFERENCES `packingsheets_dev`.`t_code` (`code_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `packingsheets_dev`.`t_contact`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets_dev`.`t_contact` ;

CREATE TABLE IF NOT EXISTS `packingsheets_dev`.`t_contact` (
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
    REFERENCES `packingsheets_dev`.`t_address` (`address_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets_dev`.`t_content`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets_dev`.`t_content` ;

CREATE TABLE IF NOT EXISTS `packingsheets_dev`.`t_content` (
  `cont_id` INT(11) NOT NULL AUTO_INCREMENT,
  `cont_label` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`cont_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets_dev`.`t_currency`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets_dev`.`t_currency` ;

CREATE TABLE IF NOT EXISTS `packingsheets_dev`.`t_currency` (
  `curr_id` INT(11) NOT NULL AUTO_INCREMENT,
  `curr_label` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`curr_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `packingsheets_dev`.`t_header`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets_dev`.`t_header` ;

CREATE TABLE IF NOT EXISTS `packingsheets_dev`.`t_header` (
  `header_id` INT(11) NOT NULL AUTO_INCREMENT,
  `header_text` VARCHAR(2000) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`header_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `packingsheets_dev`.`t_footer`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets_dev`.`t_footer` ;

CREATE TABLE IF NOT EXISTS `packingsheets_dev`.`t_footer` (
  `footer_id` INT(11) NOT NULL AUTO_INCREMENT,
  `footer_text` VARCHAR(2000) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`footer_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets_dev`.`t_customStatus`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets_dev`.`t_customStatus` ;

CREATE TABLE IF NOT EXISTS `packingsheets_dev`.`t_customStatus` (
  `custStat_id` INT(11) NOT NULL AUTO_INCREMENT,
  `custStat_label` VARCHAR(50) CHARACTER SET 'utf8' NOT NULL,
  `custStat_text` VARCHAR(100) CHARACTER SET 'utf8',
  PRIMARY KEY (`custStat_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets_dev`.`t_imput`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets_dev`.`t_imput` ;

CREATE TABLE IF NOT EXISTS `packingsheets_dev`.`t_imput` (
  `imp_id` INT(11) NOT NULL AUTO_INCREMENT,
  `imp_label` VARCHAR(50) CHARACTER SET 'utf8' NOT NULL,
  `imp_text` VARCHAR(100) CHARACTER SET 'utf8',
  PRIMARY KEY (`imp_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets_dev`.`t_incotermsLocation`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets_dev`.`t_incotermsLocation` ;

CREATE TABLE IF NOT EXISTS `packingsheets_dev`.`t_incotermsLocation` (
  `incLoc_id` INT(11) NOT NULL AUTO_INCREMENT,
  `incLoc_label` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`incLoc_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets_dev`.`t_incotermsType`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets_dev`.`t_incotermsType` ;

CREATE TABLE IF NOT EXISTS `packingsheets_dev`.`t_incotermsType` (
  `incType_id` INT(11) NOT NULL AUTO_INCREMENT,
  `incType_label` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`incType_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets_dev`.`t_memo`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets_dev`.`t_memo` ;

CREATE TABLE IF NOT EXISTS `packingsheets_dev`.`t_memo` (
  `memo_id` INT(11) NOT NULL AUTO_INCREMENT,
  `memo_label` VARCHAR(250) CHARACTER SET 'utf8' NOT NULL,
  `memo_text` VARCHAR(100) CHARACTER SET 'utf8',
  PRIMARY KEY (`memo_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets_dev`.`t_packtype`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets_dev`.`t_packtype` ;

CREATE TABLE IF NOT EXISTS `packingsheets_dev`.`t_packtype` (
  `packtype_id` INT(11) NOT NULL AUTO_INCREMENT,
  `packtype_label` VARCHAR(50) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`packtype_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets_dev`.`t_priority`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets_dev`.`t_priority` ;

CREATE TABLE IF NOT EXISTS `packingsheets_dev`.`t_priority` (
  `prior_id` INT(11) NOT NULL AUTO_INCREMENT,
  `prior_label` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`prior_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets_dev`.`t_service`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets_dev`.`t_service` ;

CREATE TABLE IF NOT EXISTS `packingsheets_dev`.`t_service` (
  `serv_id` INT(11) NOT NULL AUTO_INCREMENT,
  `serv_label` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`serv_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets_dev`.`t_shipper`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets_dev`.`t_shipper` ;

CREATE TABLE IF NOT EXISTS `packingsheets_dev`.`t_shipper` (
  `ship_id` INT(11) NOT NULL AUTO_INCREMENT,
  `ship_label` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`ship_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets_dev`.`t_packingsheet`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets_dev`.`t_packingsheet` ;

CREATE TABLE IF NOT EXISTS `packingsheets_dev`.`t_packingsheet` (
  `ps_id` INT(11) NOT NULL AUTO_INCREMENT,
  `ps_ref` VARCHAR(50) CHARACTER SET 'utf8' NOT NULL,
  `group_id` INT(11) NOT NULL,
  `consignedAddress_id` INT(11),
  `deliveryAddress_id` INT(11),
  `consignedContact_id` INT(11),
  `deliveryContact_id` INT(11),
  `service_id` INT(11),
  `content_id` INT(11),
  `priority_id` INT(11),
  `shipper_id` INT(11),
  `ps_orderNr` VARCHAR(50) CHARACTER SET 'utf8',
  `ps_AWB` VARCHAR(50) CHARACTER SET 'utf8',
  `ps_dateIssue` DATE,
  `ps_collect` TINYINT(1) NULL DEFAULT NULL,
  `ps_autority` VARCHAR(100) CHARACTER SET 'utf8' NOT NULL,
  `customStatus_id` INT(11),
  `incType_id` INT(11),
  `incLoc_id` INT(11),
  `currency_id` INT(11),
  `imput_id` INT(11),
  `ps_nbrPieces` INT(11) NOT NULL,
  `ps_weight` FLOAT NOT NULL,
  `ps_totalPrice` FLOAT NOT NULL,
  `ps_signed` TINYINT(1) NULL DEFAULT NULL,
  `ps_printed` TINYINT(1) NULL DEFAULT NULL,
  `ps_memo` VARCHAR(500) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  PRIMARY KEY (`ps_id`),
  INDEX `fk_ps_service` (`service_id` ASC),
  INDEX `fk_ps_content` (`content_id` ASC),
  INDEX `fk_ps_priority` (`priority_id` ASC),
  INDEX `fk_ps_shipper` (`shipper_id` ASC),
  INDEX `fk_ps_customStatus` (`customStatus_id` ASC),
  INDEX `fk_ps_incType` (`incType_id` ASC),
  INDEX `fk_ps_incLoc` (`incLoc_id` ASC),
  INDEX `fk_ps_currency` (`currency_id` ASC),
  INDEX `fk_ps_imput` (`imput_id` ASC),
  INDEX `fk_ps_consignedAddress_idx` (`consignedAddress_id` ASC),
  INDEX `fk_ps_deliveryAddress_idx` (`deliveryAddress_id` ASC),
  INDEX `fk_ps_consignedContact_idx` (`consignedContact_id` ASC),
  INDEX `fk_ps_deliveryContact_idx` (`deliveryContact_id` ASC),
  CONSTRAINT `fk_ps_consignedAddress`
    FOREIGN KEY (`consignedAddress_id`)
    REFERENCES `packingsheets_dev`.`t_address` (`address_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ps_consignedContact`
    FOREIGN KEY (`consignedContact_id`)
    REFERENCES `packingsheets_dev`.`t_contact` (`contact_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ps_content`
    FOREIGN KEY (`content_id`)
    REFERENCES `packingsheets_dev`.`t_content` (`cont_id`),
  CONSTRAINT `fk_ps_currency`
    FOREIGN KEY (`currency_id`)
    REFERENCES `packingsheets_dev`.`t_currency` (`curr_id`),
  CONSTRAINT `fk_ps_customStatus`
    FOREIGN KEY (`customStatus_id`)
    REFERENCES `packingsheets_dev`.`t_customStatus` (`custStat_id`),
  CONSTRAINT `fk_ps_deliveryAddress`
    FOREIGN KEY (`deliveryAddress_id`)
    REFERENCES `packingsheets_dev`.`t_address` (`address_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ps_deliveryContact`
    FOREIGN KEY (`deliveryContact_id`)
    REFERENCES `packingsheets_dev`.`t_contact` (`contact_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_ps_imput`
    FOREIGN KEY (`imput_id`)
    REFERENCES `packingsheets_dev`.`t_imput` (`imp_id`),
  CONSTRAINT `fk_ps_incLoc`
    FOREIGN KEY (`incLoc_id`)
    REFERENCES `packingsheets_dev`.`t_incotermsLocation` (`incLoc_id`),
  CONSTRAINT `fk_ps_incType`
    FOREIGN KEY (`incType_id`)
    REFERENCES `packingsheets_dev`.`t_incotermsType` (`incType_id`),
  CONSTRAINT `fk_ps_priority`
    FOREIGN KEY (`priority_id`)
    REFERENCES `packingsheets_dev`.`t_priority` (`prior_id`),
  CONSTRAINT `fk_ps_service`
    FOREIGN KEY (`service_id`)
    REFERENCES `packingsheets_dev`.`t_service` (`serv_id`),
  CONSTRAINT `fk_ps_shipper`
    FOREIGN KEY (`shipper_id`)
    REFERENCES `packingsheets_dev`.`t_shipper` (`ship_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets_dev`.`t_packing`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets_dev`.`t_packing` ;

CREATE TABLE IF NOT EXISTS `packingsheets_dev`.`t_packing` (
  `pack_id` INT(11) NOT NULL AUTO_INCREMENT,
  `ps_id` INT(11) NOT NULL,
  `pack_netWeight` FLOAT NOT NULL,
  `pack_grossWeight` FLOAT NOT NULL,
  `pack_M1` FLOAT NOT NULL,
  `pack_M2` FLOAT NOT NULL,
  `pack_M3` FLOAT NOT NULL,
  `packType_id` INT(11) NOT NULL,
  PRIMARY KEY (`pack_id`),
  INDEX `fk_pack_ps` (`ps_id` ASC),
  INDEX `fk_pack_packtype` (`packType_id` ASC),
  CONSTRAINT `fk_pack_packtype`
    FOREIGN KEY (`packType_id`)
    REFERENCES `packingsheets_dev`.`t_packtype` (`packtype_id`),
  CONSTRAINT `fk_pack_ps`
    FOREIGN KEY (`ps_id`)
    REFERENCES `packingsheets_dev`.`t_packingsheet` (`ps_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets_dev`.`t_part`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets_dev`.`t_part` ;

CREATE TABLE IF NOT EXISTS `packingsheets_dev`.`t_part` (
  `part_id` INT(11) NOT NULL AUTO_INCREMENT,
  `part_pn` VARCHAR(100) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `part_desc` VARCHAR(200) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `part_HSCode` VARCHAR(50) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  PRIMARY KEY (`part_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;


-- -----------------------------------------------------
-- Table `packingsheets_dev`.`t_packing_part`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets_dev`.`t_packing_part` ;

CREATE TABLE IF NOT EXISTS `packingsheets_dev`.`t_packing_part` (
  `pkp_id` INT(11) NOT NULL AUTO_INCREMENT,
  `pack_id` INT(11) NOT NULL,
  `part_id` INT(11) NOT NULL,
  `pkp_quantity` INT(11) NULL DEFAULT NULL,
  `pkp_origin` VARCHAR(100) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `pkp_serial` VARCHAR(100) CHARACTER SET 'utf8' NULL DEFAULT NULL,
  `pkp_price` FLOAT NOT NULL,
  PRIMARY KEY (`pkp_id`),
  INDEX `fk_pkp_pack` (`pack_id` ASC),
  INDEX `fk_pkp_part` (`part_id` ASC),
  CONSTRAINT `fk_pkp_pack`
    FOREIGN KEY (`pack_id`)
    REFERENCES `packingsheets_dev`.`t_packing` (`pack_id`),
  CONSTRAINT `fk_pkp_part`
    FOREIGN KEY (`part_id`)
    REFERENCES `packingsheets_dev`.`t_part` (`part_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `packingsheets_dev`.`t_packinglist`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets_dev`.`t_packinglist` ;

CREATE TABLE IF NOT EXISTS `packingsheets_dev`.`t_packinglist` (
  `pl_id` INT(11) NOT NULL AUTO_INCREMENT,
  `ps_id` INT(11) NOT NULL,
  PRIMARY KEY (`pl_id`),
  INDEX `fk_plp_ps` (`ps_id` ASC),
  CONSTRAINT `fk_plp_ps`
    FOREIGN KEY (`ps_id`)
    REFERENCES `packingsheets_dev`.`t_packingsheet` (`ps_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `packingsheets_dev`.`t_packinglist_part`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets_dev`.`t_packinglist_part` ;

CREATE TABLE IF NOT EXISTS `packingsheets_dev`.`t_packinglist_part` (
  `plp_id` INT(11) NOT NULL AUTO_INCREMENT,
  `pl_id` INT(11) NOT NULL,
  `part_id` INT(11) NOT NULL,
  `plp_quantity` INT(11) NOT NULL,
  PRIMARY KEY (`plp_id`),
  INDEX `fk_plp_pl` (`pl_id` ASC),
  INDEX `fk_plp_part` (`part_id` ASC),
  CONSTRAINT `fk_plp_pl`
    FOREIGN KEY (`pl_id`)
    REFERENCES `packingsheets_dev`.`t_packinglist` (`pl_id`),
  CONSTRAINT `fk_plp_part`
    FOREIGN KEY (`part_id`)
    REFERENCES `packingsheets_dev`.`t_part` (`part_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

-- -----------------------------------------------------
-- Table `packingsheets_dev`.`t_image`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `packingsheets_dev`.`t_image` ;

CREATE TABLE IF NOT EXISTS `packingsheets_dev`.`t_image` (
  `image_id` INT(11) NOT NULL AUTO_INCREMENT,
  `image_packingId` INT(11) NOT NULL,
  `image_name` VARCHAR(200) CHARACTER SET 'utf8' NOT NULL,
  PRIMARY KEY (`image_id`),
  INDEX `fk_img_pack` (`image_packingId` ASC),
  CONSTRAINT `fk_img_pack`
    FOREIGN KEY (`image_packingId`)
    REFERENCES `packingsheets_dev`.`t_packing` (`pack_id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_unicode_ci;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
