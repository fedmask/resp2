
-- -----------------------------------------------------
-- Table `mydb`.`tbl_nazioni`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `mydb`.`tbl_nazioni` (
  `id_nazioni` INT NOT NULL,
  `nazione_nominativo` VARCHAR(45) NULL,
  `nazione_prefisso_telefonico` VARCHAR(45) NULL,
  PRIMARY KEY (`id_nazioni`))
