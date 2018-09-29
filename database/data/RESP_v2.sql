
drop schema if exists resp;
-- -----------------------------------------------------
-- Schema resp
-- -----------------------------------------------------


-- -----------------------------------------------------
-- Schema resp
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `resp`;



USE `resp` ;

-- -----------------------------------------------------
-- Table  `tbl_Gruppo_Anatomico_P`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_Gruppo_Anatomico_P` ;

CREATE TABLE IF NOT EXISTS  `tbl_Gruppo_Anatomico_P` (
  `ID_Gruppo_Anatomico` CHAR(1)  ,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `Descrizione` VARCHAR(45)  ,
  PRIMARY KEY (`ID_Gruppo_Anatomico`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `ATC_Gruppo_Terapeutico_P`
-- -----------------------------------------------------


CREATE TABLE IF NOT EXISTS  `ATC_Gruppo_Terapeutico_P` (
  `Codice_Gruppo_Teraputico` CHAR(3)  ,
  `Codice_GTP` CHAR(2)  ,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `Descrizione` VARCHAR(45)  ,
  `ID_Gruppo_Anatomico` CHAR(1)  ,
  PRIMARY KEY (`Codice_Gruppo_Teraputico`),
  INDEX `FOREIGN_GruppoT_GruppoA_idx` (`ID_Gruppo_Anatomico` ASC),
  CONSTRAINT `FOREIGN_GruppoT_GruppoA_idx`
    FOREIGN KEY (`ID_Gruppo_Anatomico`)
    REFERENCES  `tbl_Gruppo_Anatomico_P` (`ID_Gruppo_Anatomico`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `ATC_Sottogruppo_Terapeutico_F`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `ATC_Sottogruppo_Terapeutico_F` ;

CREATE TABLE IF NOT EXISTS  `ATC_Sottogruppo_Terapeutico_F` (
  `id_sottogruppoTF` CHAR(4)  ,
  `Codice_Gruppo_Teraputico` CHAR(1)  ,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `Descrizione` VARCHAR(45)  ,
  `ID_Gruppo_Terapeutico` CHAR(3)  ,
  PRIMARY KEY (`id_sottogruppoTF`),
  INDEX `FOREIGN_SottogruppoT_GruppoT_idx` (`ID_Gruppo_Terapeutico` ASC),
  CONSTRAINT `FOREIGN_SottogruppoT_GruppoT_idx`
    FOREIGN KEY (`ID_Gruppo_Terapeutico`)
    REFERENCES  `ATC_Gruppo_Terapeutico_P` (`Codice_Gruppo_Teraputico`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `ATC_Sottogruppo_Chimico_TF`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `ATC_Sottogruppo_Chimico_TF` ;

CREATE TABLE IF NOT EXISTS  `ATC_Sottogruppo_Chimico_TF` (
  `id_sottogruppoCTF` CHAR(5)  ,
  `Codice_Sottogruppo_Teraputico` CHAR(1)  ,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `Descrizione` VARCHAR(45)  ,
  `ID_Sottogruppo_Terapeutico` CHAR(4)  ,
  PRIMARY KEY (`id_sottogruppoCTF`),
  INDEX `FOREIGN_SottogruppoCFT_SottogruppoTF_idx` (`ID_Sottogruppo_Terapeutico` ASC),
  CONSTRAINT `FOREIGN_SottogruppoCFT_SottogruppoTF_idx`
    FOREIGN KEY (`ID_Sottogruppo_Terapeutico`)
    REFERENCES  `ATC_Sottogruppo_Terapeutico_F` (`id_sottogruppoTF`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `ATC_Sottogruppo_Chimico`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `ATC_Sottogruppo_Chimico` ;

CREATE TABLE IF NOT EXISTS  `ATC_Sottogruppo_Chimico` (
  `Codice_ATC` CHAR(7)  ,
  `Codice_Sottogruppo_CTF` CHAR(2)  ,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `Descrizione` VARCHAR(45)  ,
  `ID_Sottogruppo_CTF` CHAR(5)  ,
  PRIMARY KEY (`Codice_ATC`),
  INDEX `FOREIGN_SottogruppoC_SottogruppoCTF_idx` (`ID_Sottogruppo_CTF` ASC),
  CONSTRAINT `FOREIGN_SottogruppoC_SottogruppoCTF_idx`
    FOREIGN KEY (`ID_Sottogruppo_CTF`)
    REFERENCES  `ATC_Sottogruppo_Chimico_TF` (`id_sottogruppoCTF`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_ICD9_IDPT_Organi`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_ICD9_IDPT_Organi` ;

CREATE TABLE IF NOT EXISTS  `tbl_ICD9_IDPT_Organi` (
  `id_IDPT_Organo` CHAR(2)  ,
  `descrizione` VARCHAR(20)  ,
  PRIMARY KEY (`id_IDPT_Organo`),
  UNIQUE INDEX `tbl_icd9_idpt_organi_id_idpt_organo_unique` (`id_IDPT_Organo` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_ICD9_IDPT_ST`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_ICD9_IDPT_ST` ;

CREATE TABLE IF NOT EXISTS  `tbl_ICD9_IDPT_ST` (
  `id_IDPT_ST` VARCHAR(2)  ,
  `descrizione_sede` VARCHAR(45)  ,
  `descrizione_tipo_intervento` VARCHAR(45)  ,
  PRIMARY KEY (`id_IDPT_ST`),
  UNIQUE INDEX `tbl_icd9_idpt_st_id_idpt_st_unique` (`id_IDPT_ST` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `Tbl_ICD9_ICPT`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `Tbl_ICD9_ICPT` ;

CREATE TABLE IF NOT EXISTS  `Tbl_ICD9_ICPT` (
  `Codice_ICD9` VARCHAR(5)  ,
  `IDPT_Organo` CHAR(2)  ,
  `IDPT_ST` VARCHAR(2)  ,
  `Descizione_ICD9` VARCHAR(45)  ,
  PRIMARY KEY (`Codice_ICD9`),
  UNIQUE INDEX `tbl_icd9_icpt_codice_icd9_unique` (`Codice_ICD9` ASC),
  INDEX `tbl_icd9_icpt_idpt_organo_foreign` (`IDPT_Organo` ASC),
  INDEX `tbl_icd9_icpt_idpt_st_foreign` (`IDPT_ST` ASC),
  CONSTRAINT `tbl_icd9_icpt_idpt_organo_foreign`
    FOREIGN KEY (`IDPT_Organo`)
    REFERENCES  `tbl_ICD9_IDPT_Organi` (`id_IDPT_Organo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `tbl_icd9_icpt_idpt_st_foreign`
    FOREIGN KEY (`IDPT_ST`)
    REFERENCES  `tbl_ICD9_IDPT_ST` (`id_IDPT_ST`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `migrations`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `migrations` ;

CREATE TABLE IF NOT EXISTS  `migrations` (
  `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255)  ,
  `batch` INT(11) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 75;


-- -----------------------------------------------------
-- Table  `password_resets`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `password_resets` ;

CREATE TABLE IF NOT EXISTS  `password_resets` (
  `email` VARCHAR(255)  ,
  `token` VARCHAR(255)  ,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  INDEX `password_resets_email_index` (`email` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_Parente`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_Parente` ;

CREATE TABLE IF NOT EXISTS  `tbl_Parente` (
  `id_parente` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `codice_fiscale` CHAR(16) COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  `nome` VARCHAR(25)  ,
  `cognome` VARCHAR(25)  ,
  `sesso` VARCHAR(8)  ,
  `data_nascita` DATE NOT NULL,
  `et` INT(11) NOT NULL,
  `decesso` TINYINT(1) NOT NULL,
  `et?_decesso` INT(11) NOT NULL,
  `data_decesso` DATE NOT NULL,
  PRIMARY KEY (`id_parente`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_utenti_tipologie`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_utenti_tipologie` ;

CREATE TABLE IF NOT EXISTS  `tbl_utenti_tipologie` (
  `id_tipologia` CHAR(3)  ,
  `tipologia_descrizione` VARCHAR(100)  ,
  `tipologia_nome` VARCHAR(30)  ,
  INDEX `fk_tbl_tipologia_idx` (`id_tipologia` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_utenti`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_utenti` ;

CREATE TABLE IF NOT EXISTS  `tbl_utenti` (
  `id_utente` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_tipologia` CHAR(3)  ,
  `utente_nome` VARCHAR(50)  ,
  `utente_password` VARCHAR(130)  ,
  `utente_stato` TINYINT(4) NOT NULL,
  `utente_scadenza` DATE NOT NULL,
  `utente_email` VARCHAR(100)  ,
  `utente_token_accesso` VARCHAR(60) COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  `utente_dati_condivisione` TINYINT(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_utente`),
  UNIQUE INDEX `utente_email_UNIQUE` (`utente_email` ASC),
  INDEX `fk_tbl_utenti_ruoli_idx` (`id_tipologia` ASC),
  CONSTRAINT `fk_tbl_utenti_tipologia_idx`
    FOREIGN KEY (`id_tipologia`)
    REFERENCES  `tbl_utenti_tipologie` (`id_tipologia`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table  `tbl_stati_matrimoniali`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_stati_matrimoniali` ;

CREATE TABLE IF NOT EXISTS  `tbl_stati_matrimoniali` (
  `id_stato_matrimoniale` SMALLINT(6) NOT NULL,
  `stato_matrimoniale_nome` VARCHAR(45)  ,
  `stato_matrimoniale_descrizione` VARCHAR(100)  ,
  INDEX `fk_tbl_stati_matrimoniali_tbl_pazienti_idx` (`id_stato_matrimoniale` ASC))
ENGINE = InnoDB;

CREATE TABLE Gender (
Code CHAR(10) PRIMARY KEY

);

CREATE TABLE MaritalStatus (
Code VARCHAR(5) PRIMARY KEY,
Text VARCHAR(50) NOT NULL


);

CREATE TABLE Languages (
Code VARCHAR(5) PRIMARY KEY,
Display VARCHAR(20) NOT NULL


);

-- -----------------------------------------------------
-- Table  `tbl_pazienti`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_pazienti` ;

CREATE TABLE IF NOT EXISTS  `tbl_pazienti` (
  `id_paziente` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_utente` INT(10) UNSIGNED NOT NULL,
  `id_stato_matrimoniale` VARCHAR(5) NOT NULL,
  `paziente_nome` VARCHAR(45)  ,
  `paziente_cognome` VARCHAR(45)  ,
  `paziente_nascita` DATE NOT NULL,
  `paziente_codfiscale` CHAR(16)  ,
  `paziente_sesso` CHAR(10) NOT NULL,
  `paziente_gruppo` TINYINT(4) ,
  `paziente_rh` CHAR(3)  ,
  `paziente_donatore_organi` TINYINT(4) ,
  `paziente_lingua` VARCHAR(5) NOT NULL,
  PRIMARY KEY (`id_paziente`),
  UNIQUE INDEX `paziente_codfiscale_UNIQUE` (`paziente_codfiscale` ASC),
  INDEX `FOREIGN_UTENTE_idx` (`id_utente` ASC),
  CONSTRAINT `FOREIGN_UTENTE_idx`
    FOREIGN KEY (`id_utente`)
    REFERENCES  `tbl_utenti` (`id_utente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    FOREIGN KEY (`id_stato_matrimoniale`)
    REFERENCES  `MaritalStatus` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    
	FOREIGN KEY (`paziente_sesso`)
    REFERENCES  `Gender` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (`paziente_lingua`)
    REFERENCES  `Languages` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table  `tbl_anamnesi_familiare`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_anamnesi_familiare` ;

CREATE TABLE IF NOT EXISTS  `tbl_anamnesi_familiare` (
  `id_paziente` INT(10) UNSIGNED NOT NULL,
  `id_anamnesi_log` INT(11) NOT NULL,
  `anamnesi_contenuto` TEXT,
  PRIMARY KEY (`id_paziente`),
  CONSTRAINT `tbl_anamnesi_familiare_ibfk_1`
    FOREIGN KEY (`id_paziente`)
    REFERENCES  `tbl_pazienti` (`id_paziente`))
ENGINE = InnoDB;


CREATE TABLE FamilyMemberHistoryStatus (
Code VARCHAR(20) PRIMARY KEY
);

-- -----------------------------------------------------
-- Table  `tbl_AnamnesiF`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_AnamnesiF` ;

CREATE TABLE IF NOT EXISTS  `tbl_AnamnesiF` (
  `id_anamnesiF` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  -- relationship si ricava tramite la codifica "relationship" in contatto, datp che i coontatti contegono anche i parenti
  `descrizione` TEXT  ,
  `id_paziente` INT(10) UNSIGNED NOT NULL,
  `id_parente` INT(10) UNSIGNED NOT NULL,
  `status` VARCHAR(20)  ,
  `notDoneReason` VARCHAR(10)  ,
  `note` TEXT  ,
  -- decesso lo vado a prendere in tbl_parente
  `data` DATE NOT NULL,
  PRIMARY KEY (`id_anamnesiF`),
  INDEX `FOREIGN_Anamnesi_Parente_I1` (`id_parente` ASC),
  INDEX `FOREIGN_Anamnesi_Parente_I2` (`id_paziente` ASC),
  CONSTRAINT `FOREIGN_Anamnesi_Parente_I1`
    FOREIGN KEY (`id_parente`)
    REFERENCES  `tbl_Parente` (`id_parente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FOREIGN_Anamnesi_Parente_I2`
    FOREIGN KEY (`id_paziente`)
    REFERENCES  `tbl_anamnesi_familiare` (`id_paziente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (`status`)
    REFERENCES  `FamilyMemberHistoryStatus` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


CREATE TABLE ConditionCode (
Code VARCHAR(10) PRIMARY KEY,
Text VARCHAR(50) NOT NULL
);

CREATE TABLE FamilyMemberHistoryConditionOutcome (
Code VARCHAR(10) PRIMARY KEY,
Text VARCHAR(50) NOT NULL
);

-- -----------------------------------------------------
-- Table  `tbl_FamilyCondiction`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_FamilyCondiction` ;

CREATE TABLE IF NOT EXISTS  `tbl_FamilyCondiction` (
  `id_Condition` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code_fhir` VARCHAR(10) NOT NULL,  
  `Codice_ICD9` VARCHAR(5)  ,
  `outCome` VARCHAR(10)  ,
  `id_parente` INT(10) UNSIGNED NOT NULL,
  `onSetAge` TINYINT(1) NOT NULL DEFAULT '1',
  `onSetAgeRange_low` INT(11) NOT NULL,
  `onSetAgeRange_hight` INT(11) NOT NULL,
  `onSetAgeValue` INT(11) NOT NULL,
  `Note` TEXT  ,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id_Condition`),
  INDEX `FOREIGN_Diagn_Condition` (`Codice_ICD9` ASC),
  INDEX `FOREIGN_Parente_Condition` (`id_parente` ASC),
  CONSTRAINT `FOREIGN_Diagn_Condition`
    FOREIGN KEY (`Codice_ICD9`)
    REFERENCES  `Tbl_ICD9_ICPT` (`Codice_ICD9`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FOREIGN_Parente_Condition`
    FOREIGN KEY (`id_parente`)
    REFERENCES  `tbl_Parente` (`id_parente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	    FOREIGN KEY (`code_fhir`)
    REFERENCES  `ConditionCode` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
		    FOREIGN KEY (`outCome`)
    REFERENCES  `FamilyMemberHistoryConditionOutcome` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_accessi_log`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_accessi_log` ;

CREATE TABLE IF NOT EXISTS  `tbl_accessi_log` (
  `accesso_ip` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'IPV4 & IPV6\r\n',
  `accesso_contatore` TINYINT(4) NOT NULL DEFAULT '0',
  `accesso_data` DATETIME NOT NULL,
  PRIMARY KEY (`accesso_ip`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_anamnesi_fisiologica`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_anamnesi_fisiologica` ;

CREATE TABLE IF NOT EXISTS  `tbl_anamnesi_fisiologica` (
  `id_anamnesi_fisiologica` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_paziente` INT(11) NOT NULL,
  `id_anamnesi_log` INT(11) NOT NULL,
  PRIMARY KEY (`id_anamnesi_fisiologica`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_anamnesi_pt_prossima`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_anamnesi_pt_prossima` ;

CREATE TABLE IF NOT EXISTS  `tbl_anamnesi_pt_prossima` (
  `id_anamnesi_prossima` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_paziente` INT(11) NOT NULL,
  `id_anamnesi_log` INT(11) NOT NULL,
  `anamnesi_prossima_contenuto` TEXT  ,
  PRIMARY KEY (`id_anamnesi_prossima`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_anamnesi_pt_remota`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_anamnesi_pt_remota` ;

CREATE TABLE IF NOT EXISTS  `tbl_anamnesi_pt_remota` (
  `id_anamnesi_remota` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_paziente` INT(11) NOT NULL,
  `id_anamnesi_log` INT(11) NOT NULL,
  `anamnesi_remota_contenuto` TEXT  ,
  PRIMARY KEY (`id_anamnesi_remota`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_auditlog_log`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_auditlog_log` ;

CREATE TABLE IF NOT EXISTS  `tbl_auditlog_log` (
  `id_audit` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `audit_nome` VARCHAR(100)  ,
  `audit_ip` VARCHAR(39)  ,
  `id_visitato` INT(10) UNSIGNED NOT NULL,
  `id_visitante` INT(10) UNSIGNED NOT NULL,
  `audit_data` DATE NOT NULL,
  `dispositivo` VARCHAR(39)  ,
  `ruolo` VARCHAR(39)  ,
  PRIMARY KEY (`id_audit`),
  INDEX `fk_tbl_auditlog_log_tbl_utenti2_idx` (`id_visitato` ASC),
  INDEX `fk_tbl_auditlog_log_tbl_utenti1_idx` (`id_visitante` ASC),
  CONSTRAINT `fk_tbl_auditlog_log_tbl_utenti1_idx`
    FOREIGN KEY (`id_visitante`)
    REFERENCES  `tbl_utenti` (`id_utente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_auditlog_log_tbl_utenti2_idx`
    FOREIGN KEY (`id_visitato`)
    REFERENCES  `tbl_utenti` (`id_utente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1;

CREATE TABLE QualificationCode (
Code CHAR(10) PRIMARY KEY,
Display VARCHAR(50) NOT NULL

);
-- -----------------------------------------------------
-- Table  `tbl_care_provider`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_care_provider` ;

CREATE TABLE IF NOT EXISTS  `tbl_care_provider` (
  `id_cpp` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_utente` INT(10) UNSIGNED NOT NULL,
  `cpp_nome` VARCHAR(45)  ,
  `cpp_cognome` VARCHAR(45)  ,
  `cpp_nascita_data` DATE NOT NULL,
  `cpp_codfiscale` CHAR(16)  ,
  `cpp_sesso` CHAR(10) NOT NULL  ,
  `cpp_n_iscrizione` VARCHAR(7)  ,
  `cpp_localita_iscrizione` VARCHAR(50)  ,
  `specializzation` VARCHAR(45)  ,
  `cpp_lingua` VARCHAR(10)  ,
  `active` TINYINT(1) DEFAULT '0'  ,
  PRIMARY KEY (`id_cpp`),
  UNIQUE INDEX `cpp_codfiscale_UNIQUE` (`cpp_codfiscale` ASC),
  INDEX `FOREIGN_CPP_UTENTE_idx` (`id_utente` ASC),
  CHECK (specializzation IN (SELECT QC.Display FROM QualificationCode QC)),
  CONSTRAINT `FOREIGN_CPP_UTENTE_idx`
    FOREIGN KEY (`id_utente`)
    REFERENCES  `tbl_utenti` (`id_utente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	
	FOREIGN KEY (`cpp_lingua`)
    REFERENCES  `Languages` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	
	FOREIGN KEY (`cpp_sesso`)
    REFERENCES  `Gender` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1;




CREATE TABLE CppQualification (
id_cpp INT(10) UNSIGNED NOT NULL,
Code CHAR(10) NOT NULL,
Start_Period DATE NOT NULL,
End_Period DATE NOT NULL,
Issuer VARCHAR(30) NOT NULL,

FOREIGN KEY(Code) REFERENCES QualificationCode(Code)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,

FOREIGN KEY (`id_cpp`)
    REFERENCES  `tbl_care_provider` (`id_cpp`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION

);

CREATE TABLE OrganizationType (
Code CHAR(6) PRIMARY KEY,
Text VARCHAR(30) NOT NULL,

INDEX code_org_type(Code)
);
-- -----------------------------------------------------
-- Table  `tbl_centri_tipologie`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_centri_tipologie` ;

CREATE TABLE IF NOT EXISTS  `tbl_centri_tipologie` (
  `id_centro_tipologia` SMALLINT(6) NOT NULL,
  `tipologia_nome` VARCHAR(60)  ,
  `code_fhir` CHAR(6)  DEFAULT 'other',
  INDEX `fk_tbl_cpp_persona_tbl_centri_indagini1_idx` (`id_centro_tipologia` ASC),
  FOREIGN KEY (`code_fhir`)
    REFERENCES  `OrganizationType` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_nazioni`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_nazioni` ;

CREATE TABLE IF NOT EXISTS  `tbl_nazioni` (
  `id_nazione` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nazione_nominativo` VARCHAR(45)  ,
  `nazione_prefisso_telefonico` VARCHAR(4)  ,
  PRIMARY KEY (`id_nazione`))
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table  `tbl_comuni`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_comuni` ;

CREATE TABLE IF NOT EXISTS  `tbl_comuni` (
  `id_comune` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_comune_nazione` INT(10) UNSIGNED NOT NULL,
  `comune_nominativo` VARCHAR(45)  ,
  `comune_cap` CHAR(5)  ,
  PRIMARY KEY (`id_comune`),
    FOREIGN KEY (`id_comune_nazione`)
    REFERENCES  `tbl_nazioni` (`id_nazione`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 14481;


-- -----------------------------------------------------
-- Table  `tbl_cpp_persona`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_cpp_persona` ;

CREATE TABLE IF NOT EXISTS  `tbl_cpp_persona` (
  `id_persona` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_utente` INT(10) UNSIGNED NOT NULL,
  `id_comune` INT(10) UNSIGNED NOT NULL,
  `persona_nome` VARCHAR(45)  ,
  `persona_cognome` VARCHAR(45)  ,
  `persona_telefono` VARCHAR(45)  ,
  `persona_fax` VARCHAR(45)  ,
  `persona_reperibilita` VARCHAR(45)  ,
  `persona_attivo` TINYINT(4) NOT NULL,
  PRIMARY KEY (`id_persona`),
  INDEX `fk_tbl_cpp_persona_tbl_comuni1_idx` (`id_comune` ASC),
  INDEX `fk_tbl_cpp_persona_tbl_utenti1_idx` (`id_utente` ASC),
  CONSTRAINT `fk_tbl_cpp_persona_tbl_comuni1_idx`
    FOREIGN KEY (`id_comune`)
    REFERENCES  `tbl_comuni` (`id_comune`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_cpp_persona_tbl_utenti1_idx`
    FOREIGN KEY (`id_utente`)
    REFERENCES  `tbl_utenti` (`id_utente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table  `tbl_centri_indagini`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_centri_indagini` ;

CREATE TABLE IF NOT EXISTS  `tbl_centri_indagini` (
  `id_centro` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_tipologia` SMALLINT(6) NOT NULL,
  `id_comune` INT(10) UNSIGNED NOT NULL,
  `id_ccp_persona` INT(10) UNSIGNED NOT NULL,
  `centro_nome` VARCHAR(80)  ,
  `centro_indirizzo` VARCHAR(100)  ,
  `centro_mail` VARCHAR(50)  ,
  `centro_resp` TINYINT(4) NOT NULL,
  PRIMARY KEY (`id_centro`),
  INDEX `fk_tbl_centri_indagini_tbl_cpp_persona1_idx` (`id_ccp_persona` ASC),
  INDEX `fk_tbl_centri_indagini_tbl_comuni1_idx` (`id_comune` ASC),
  INDEX `fk_tbl_centri_indagini_tbl_centri_tipologie1_idx` (`id_tipologia` ASC),
  CONSTRAINT `fk_tbl_centri_indagini_tbl_centri_tipologie1_idx`
    FOREIGN KEY (`id_tipologia`)
    REFERENCES  `tbl_centri_tipologie` (`id_centro_tipologia`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_centri_indagini_tbl_comuni1_idx`
    FOREIGN KEY (`id_comune`)
    REFERENCES  `tbl_comuni` (`id_comune`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_centri_indagini_tbl_cpp_persona1_idx`
    FOREIGN KEY (`id_ccp_persona`)
    REFERENCES  `tbl_cpp_persona` (`id_persona`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table  `tbl_modalita_contatti`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_modalita_contatti` ;

CREATE TABLE IF NOT EXISTS  `tbl_modalita_contatti` (
  `id_modalita` SMALLINT(6) NOT NULL,
  `modalita_nome` VARCHAR(50)  ,
  INDEX `fk_tbl_centri_indagini_tbl_centri_contatti1_idx` (`id_modalita` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_centri_contatti`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_centri_contatti` ;

CREATE TABLE IF NOT EXISTS  `tbl_centri_contatti` (
  `id_contatto` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_centro` INT(10) UNSIGNED NOT NULL,
  `id_modalita_contatto` SMALLINT(6) NOT NULL,
  `contatto_valore` VARCHAR(100)  ,
  PRIMARY KEY (`id_contatto`),
  INDEX `fk_tbl_centri_contatti_tbl_centri_indagini1_idx` (`id_centro` ASC),
  INDEX `fk_tbl_centri_contatti_tbl_modalita_contatti1_idx` (`id_modalita_contatto` ASC),
  CONSTRAINT `fk_tbl_centri_contatti_tbl_centri_indagini1_idx`
    FOREIGN KEY (`id_centro`)
    REFERENCES  `tbl_centri_indagini` (`id_centro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_centri_contatti_tbl_modalita_contatti1_idx`
    FOREIGN KEY (`id_modalita_contatto`)
    REFERENCES  `tbl_modalita_contatti` (`id_modalita`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 5;


-- -----------------------------------------------------
-- Table  `tbl_codici_operazioni`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_codici_operazioni` ;

CREATE TABLE IF NOT EXISTS  `tbl_codici_operazioni` (
  `id_codice` CHAR(2)  ,
  `codice_descrizione` VARCHAR(100)  ,
  INDEX `fk_tbl_codici_operazioni_tbl_operazioni_log_idx` (`id_codice` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_cpp_diagnosi`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_cpp_diagnosi` ;

CREATE TABLE IF NOT EXISTS  `tbl_cpp_diagnosi` (
  `id_diagnosi` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `diagnosi_stato` VARCHAR(15)  ,
  `careprovider` TEXT  ,
  PRIMARY KEY (`id_diagnosi`))
ENGINE = InnoDB
AUTO_INCREMENT = 5;


-- -----------------------------------------------------
-- Table  `tbl_livelli_confidenzialita`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_livelli_confidenzialita` ;

CREATE TABLE IF NOT EXISTS  `tbl_livelli_confidenzialita` (
  `id_livello_confidenzialita` SMALLINT(6) NOT NULL,
  `confidenzialita_descrizione` VARCHAR(45)  ,
  INDEX `fk_tbl_livelli_confidenzialita_tbl_diagnosi_idx` (`id_livello_confidenzialita` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_cpp_paziente`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_cpp_paziente` ;

CREATE TABLE IF NOT EXISTS  `tbl_cpp_paziente` (
  `id_cpp` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_paziente` INT(10) UNSIGNED NOT NULL,
  `assegnazione_confidenzialita` SMALLINT(6) NOT NULL,
  PRIMARY KEY (`id_cpp`),
  UNIQUE INDEX `tbl_cpp_paziente_id_cpp_unique` (`id_cpp` ASC),
  INDEX `fk_tbl_medici_assegnati_tbl_livelli_confidenzialita1_idx` (`assegnazione_confidenzialita` ASC),
  INDEX `fk_tbl_medici_assegnati_tbl_medici1_idx` (`id_cpp` ASC),
  CONSTRAINT `fk_tbl_medici_assegnati_tbl_livelli_confidenzialita1_idx`
    FOREIGN KEY (`assegnazione_confidenzialita`)
    REFERENCES  `tbl_livelli_confidenzialita` (`id_livello_confidenzialita`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_medici_assegnati_tbl_medici1_idx`
    FOREIGN KEY (`id_cpp`)
    REFERENCES  `tbl_care_provider` (`id_cpp`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    FOREIGN KEY (`id_paziente`)
    REFERENCES  `tbl_pazienti` (`id_paziente`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 2;


-- -----------------------------------------------------
-- Table  `tbl_specialization`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_specialization` ;

CREATE TABLE IF NOT EXISTS  `tbl_specialization` (
  `id_spec` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `desc_specialization` VARCHAR(45)  ,
  PRIMARY KEY (`id_spec`))
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table  `tbl_cpp_specialization`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_cpp_specialization` ;

CREATE TABLE IF NOT EXISTS  `tbl_cpp_specialization` (
  `id_cpp_specialization` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_specialization` INT(10) UNSIGNED NOT NULL,
  `id_cpp` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_cpp_specialization`),
  INDEX `FOREIGN_CPP_Specialization_idx` (`id_cpp` ASC),
  INDEX `FOREIGN_Specialization_Cpp_idx` (`id_specialization` ASC),
  CONSTRAINT `FOREIGN_CPP_Specialization_idx`
    FOREIGN KEY (`id_cpp`)
    REFERENCES  `tbl_care_provider` (`id_cpp`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `FOREIGN_Specialization_Cpp_idx`
    FOREIGN KEY (`id_specialization`)
    REFERENCES  `tbl_specialization` (`id_spec`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1;

CREATE TABLE ConditionClinicalStatus (
Code VARCHAR(15) PRIMARY KEY
);	

CREATE TABLE ConditionVerificationStatus (
Code VARCHAR(20) PRIMARY KEY
);	

CREATE TABLE ConditionSeverity (
Code VARCHAR(30) PRIMARY KEY,
Text VARCHAR(50) NOT NULL
);	


CREATE TABLE ConditionBodySite (
Code VARCHAR(10) PRIMARY KEY,
Text VARCHAR(50) NOT NULL
);	

CREATE TABLE ConditionStageSummary (
Code VARCHAR(10) PRIMARY KEY,
Text VARCHAR(50) NOT NULL
);	

CREATE TABLE ConditionEvidenceCode (
Code VARCHAR(10) PRIMARY KEY,
Text VARCHAR(50) NOT NULL
);	

-- -----------------------------------------------------
-- Table  `tbl_diagnosi`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_diagnosi` ;

CREATE TABLE IF NOT EXISTS  `tbl_diagnosi` (
  `id_diagnosi` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_paziente` INT(10) UNSIGNED NOT NULL,
  verificationStatus VARCHAR(20) NOT NULL,
  severity VARCHAR(30) NOT NULL,
  code VARCHAR(10) NOT NULL,
    bodySite VARCHAR(10) NOT NULL,
	stageSummary VARCHAR(10) NOT NULL,
	evidenceCode VARCHAR(10) NOT NULL,
  `diagnosi_confidenzialita` SMALLINT(6) NOT NULL,
  `diagnosi_inserimento_data` DATE NOT NULL,
  `diagnosi_aggiornamento_data` DATE NOT NULL,
  `diagnosi_patologia` TEXT  ,
  `diagnosi_stato` VARCHAR(15) NOT NULL,
  `diagnosi_guarigione_data` DATE NOT NULL,
  `note` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`id_diagnosi`),
  INDEX `fk_tbl_diagnosi_tbl_livelli_confidenzialita1_idx` (`diagnosi_confidenzialita` ASC),
  INDEX `fk_tbl_diagnosi_tbl_pazienti1_idx` (`id_paziente` ASC),
    FOREIGN KEY (`diagnosi_confidenzialita`)
    REFERENCES  `tbl_livelli_confidenzialita` (`id_livello_confidenzialita`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    FOREIGN KEY (`id_paziente`)
    REFERENCES  `tbl_pazienti` (`id_paziente`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
	FOREIGN KEY (`diagnosi_stato`)
    REFERENCES  `ConditionClinicalStatus` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (`verificationStatus`)
    REFERENCES  `ConditionVerificationStatus` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (`severity`)
    REFERENCES  `ConditionSeverity` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (`code`)
    REFERENCES  `ConditionCode` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (`bodySite`)
    REFERENCES  `ConditionBodySite` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (`stageSummary`)
    REFERENCES  `ConditionStageSummary` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (`evidenceCode`)
    REFERENCES  `ConditionEvidenceCode` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 5;


-- -----------------------------------------------------
-- Table  `tbl_diagnosi_eliminate`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_diagnosi_eliminate` ;

CREATE TABLE IF NOT EXISTS  `tbl_diagnosi_eliminate` (
  `id_diagnosi_eliminata` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_utente` INT(10) UNSIGNED NOT NULL,
  `id_diagnosi` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_diagnosi_eliminata`),
  INDEX `fk_tbl_diagnosi_eliminate_tbl_diagnosi1_idx` (`id_diagnosi` ASC),
  INDEX `fk_tbl_diagnosi_eliminate_tbl_pazienti1_idx` (`id_utente` ASC),
  CONSTRAINT `fk_tbl_diagnosi_eliminate_tbl_diagnosi1_idx`
    FOREIGN KEY (`id_diagnosi`)
    REFERENCES  `tbl_diagnosi` (`id_diagnosi`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_diagnosi_eliminate_tbl_pazienti1_idx`
    FOREIGN KEY (`id_utente`)
    REFERENCES  `tbl_pazienti` (`id_paziente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_effetti_collaterali`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_effetti_collaterali` ;

CREATE TABLE IF NOT EXISTS  `tbl_effetti_collaterali` (
  `id_effetto_collaterale` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_paziente` INT(10) UNSIGNED NOT NULL,
  `id_audit_log` INT(10) UNSIGNED NOT NULL,
  `effetto_collaterale_descrizione` TEXT  ,
  PRIMARY KEY (`id_effetto_collaterale`),
  INDEX `fk_tbl_effetti_collaterali_tbl_auditlog_log1_idx` (`id_audit_log` ASC),
  INDEX `fk_tbl_effetti_collaterali_tbl_pazienti1_idx` (`id_paziente` ASC),
  CONSTRAINT `fk_tbl_effetti_collaterali_tbl_auditlog_log1_idx`
    FOREIGN KEY (`id_audit_log`)
    REFERENCES  `tbl_auditlog_log` (`id_audit`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_effetti_collaterali_tbl_pazienti1_idx`
    FOREIGN KEY (`id_paziente`)
    REFERENCES  `tbl_pazienti` (`id_paziente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_loinc_risposte`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_loinc_risposte` ;

CREATE TABLE IF NOT EXISTS  `tbl_loinc_risposte` (
  `id_codice` VARCHAR(10)  ,
  `codice_risposta` VARCHAR(100)  ,
  `codice_loinc` VARCHAR(100)  ,
  INDEX `fk_tbl_loinc_risposte1_idx` (`id_codice` ASC),
  INDEX `fk_tbl_loinc_risposte2_idx` (`codice_risposta` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_esami_obiettivi`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_esami_obiettivi` ;

CREATE TABLE IF NOT EXISTS  `tbl_esami_obiettivi` (
  `id_esame_obiettivo` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_paziente` INT(10) UNSIGNED NOT NULL,
  `codice_risposta_loinc` VARCHAR(10)  ,
  `id_diagnosi` INT(11) NOT NULL,
  `esame_data` DATE NOT NULL,
  `esame_aggiornamento` DATE NOT NULL,
  `esame_stato` VARCHAR(15)  ,
  `esame_risultato` VARCHAR(15)  ,
  PRIMARY KEY (`id_esame_obiettivo`),
  INDEX `fk_tbl_esami_obiettivi_tbl_loinc_risposte1_idx` (`codice_risposta_loinc` ASC),
  INDEX `fk_tbl_esami_obiettivi_tbl_pazienti1_idx` (`id_paziente` ASC),
  CONSTRAINT `fk_tbl_esami_obiettivi_tbl_loinc_risposte1_idx`
    FOREIGN KEY (`codice_risposta_loinc`)
    REFERENCES  `tbl_loinc_risposte` (`codice_risposta`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_esami_obiettivi_tbl_pazienti1_idx`
    FOREIGN KEY (`id_paziente`)
    REFERENCES  `tbl_pazienti` (`id_paziente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_familiarita_decessi`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_familiarita_decessi` ;

CREATE TABLE IF NOT EXISTS  `tbl_familiarita_decessi` (
  `id_paziente` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `familiare_data_decesso` DATE NOT NULL,
  PRIMARY KEY (`id_paziente`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_farmaci_categorie`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_farmaci_categorie` ;

CREATE TABLE IF NOT EXISTS  `tbl_farmaci_categorie` (
  `id_categoria` VARCHAR(6)  ,
  `categoria_descrizione` VARCHAR(120)  ,
  INDEX `fk_tbl_farmaci_categorie_tbl_farmaci_idx` (`id_categoria` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_farmaci`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_farmaci` ;

CREATE TABLE IF NOT EXISTS  `tbl_farmaci` (
  `id_farmaco` VARCHAR(8)  ,
  `id_categoria_farmaco` VARCHAR(6)  ,
  `farmaco_nome` VARCHAR(50)  ,
  INDEX `fk_tbl_farmaci_tbl_farmaci_vietati_idx` (`id_farmaco` ASC),
  INDEX `fk_tbl_farmaci_tbl_farmaci_categorie1_idx` (`id_categoria_farmaco` ASC),
  CONSTRAINT `fk_tbl_farmaci_tbl_farmaci_categorie1_idx`
    FOREIGN KEY (`id_categoria_farmaco`)
    REFERENCES  `tbl_farmaci_categorie` (`id_categoria`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE MedicationCode (
Code VARCHAR(10) PRIMARY KEY,
Text VARCHAR(50) NOT NULL
);

CREATE TABLE MedicationStatus (
Code VARCHAR(20) PRIMARY KEY
);

CREATE TABLE MedicationForm (
Code VARCHAR(10) PRIMARY KEY,
Text VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS  `farmaci_assunti` (
  `id_farmaco`VARCHAR(10) NOT NULL  ,
  `id_paziente` INT(10) UNSIGNED NOT NULL ,
  `status` VARCHAR(20) NOT NULL ,
  `isOverTheCounter` TINYINT(1),
  `form` VARCHAR(10) NOT NULL,
	    FOREIGN KEY (`id_paziente`)
    REFERENCES  `tbl_pazienti` (`id_paziente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	    FOREIGN KEY (`id_farmaco`)
    REFERENCES  `MedicationCode` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (`status`)
    REFERENCES  `MedicationStatus` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
		FOREIGN KEY (`form`)
    REFERENCES  `MedicationForm` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
	

ENGINE = InnoDB;




-- -----------------------------------------------------
-- Table  `tbl_farmaci_tipologie_somm`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_farmaci_tipologie_somm` ;

CREATE TABLE IF NOT EXISTS  `tbl_farmaci_tipologie_somm` (
  `id_farmaco_somministrazione` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `somministrazione_descrizione` TEXT  ,
  PRIMARY KEY (`id_farmaco_somministrazione`))
ENGINE = InnoDB
AUTO_INCREMENT = 21;


-- -----------------------------------------------------
-- Table  `tbl_farmaci_vietati`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_farmaci_vietati` ;

CREATE TABLE IF NOT EXISTS  `tbl_farmaci_vietati` (
  `id_farmaco_vietato` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_paziente` INT(10) UNSIGNED NOT NULL,
  `id_farmaco` VARCHAR(8)  ,
  `farmaco_vietato_motivazione` TEXT  ,
  `farmaco_vietato_confidenzialita` SMALLINT(6) NOT NULL,
  PRIMARY KEY (`id_farmaco_vietato`),
  INDEX `fk_tbl_farmaci_vietati_tbl_farmaci1_idx` (`id_farmaco` ASC),
  INDEX `fk_tbl_farmaci_vietati_tbl_pazienti1_idx` (`id_paziente` ASC),
  INDEX `fk_tbl_farmaci_vietati_tbl_livelli_confidenzialita1_idx` (`farmaco_vietato_confidenzialita` ASC),
  CONSTRAINT `fk_tbl_farmaci_vietati_tbl_farmaci1_idx`
    FOREIGN KEY (`id_farmaco`)
    REFERENCES  `tbl_farmaci` (`id_farmaco`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_farmaci_vietati_tbl_livelli_confidenzialita1_idx`
    FOREIGN KEY (`farmaco_vietato_confidenzialita`)
    REFERENCES  `tbl_livelli_confidenzialita` (`id_livello_confidenzialita`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_farmaci_vietati_tbl_pazienti1_idx`
    FOREIGN KEY (`id_paziente`)
    REFERENCES  `tbl_pazienti` (`id_paziente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_files`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_files` ;

CREATE TABLE IF NOT EXISTS  `tbl_files` (
  `id_file` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_paziente` INT(10) UNSIGNED NOT NULL,
  `id_audit_log` INT(10) UNSIGNED NOT NULL,
  `id_file_confidenzialita` SMALLINT(6) NOT NULL,
  `file_nome` VARCHAR(60)  ,
  `file_commento` TEXT  ,
  `updated_at` DATE NOT NULL,
  `created_at` DATE NOT NULL,
  PRIMARY KEY (`id_file`),
  INDEX `fk_tbl_files_tbl_pazienti1_idx` (`id_paziente` ASC),
  INDEX `fk_tbl_files_tbl_livelli_confidenzialita1_idx` (`id_file_confidenzialita` ASC),
  INDEX `fk_tbl_files_tbl_auditlog_log1_idx` (`id_audit_log` ASC),
  CONSTRAINT `fk_tbl_files_tbl_auditlog_log1_idx`
    FOREIGN KEY (`id_audit_log`)
    REFERENCES  `tbl_auditlog_log` (`id_audit`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_files_tbl_livelli_confidenzialita1_idx`
    FOREIGN KEY (`id_file_confidenzialita`)
    REFERENCES  `tbl_livelli_confidenzialita` (`id_livello_confidenzialita`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_files_tbl_pazienti1_idx`
    FOREIGN KEY (`id_paziente`)
    REFERENCES  `tbl_pazienti` (`id_paziente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_icd9_grup_diag_codici`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_icd9_grup_diag_codici` ;

CREATE TABLE IF NOT EXISTS  `tbl_icd9_grup_diag_codici` (
  `codice` VARCHAR(4)  ,
  `gruppo_descrizione` VARCHAR(120)  ,
  INDEX `fk_tbl_icd9_grup_diag_codici_idx` (`codice` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_icd9_bloc_diag_codici`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_icd9_bloc_diag_codici` ;

CREATE TABLE IF NOT EXISTS  `tbl_icd9_bloc_diag_codici` (
  `codice_blocco` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `codice_gruppo` VARCHAR(4)  ,
  `blocco_cod_descrizione` TEXT  ,
  PRIMARY KEY (`codice_blocco`),
  INDEX `fk_tbl_icd9_bloc_diag_codici_tbl_icd9_grup_diag_codici1_idx` (`codice_gruppo` ASC),
  CONSTRAINT `fk_tbl_icd9_bloc_diag_codici_tbl_icd9_grup_diag_codici1_idx`
    FOREIGN KEY (`codice_gruppo`)
    REFERENCES  `tbl_icd9_grup_diag_codici` (`codice`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_icd9_cat_diag_codici`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_icd9_cat_diag_codici` ;

CREATE TABLE IF NOT EXISTS  `tbl_icd9_cat_diag_codici` (
  `codice_categoria` VARCHAR(6)  ,
  `codice_blocco` VARCHAR(4)  ,
  `categoria_cod_descrizione` VARCHAR(120)  ,
  INDEX `fk_tbl_icd9_cat_diag_codici_idx` (`codice_blocco` ASC),
  CONSTRAINT `fk_tbl_icd9_cat_diag_codici_idx`
    FOREIGN KEY (`codice_blocco`)
    REFERENCES  `tbl_icd9_grup_diag_codici` (`codice`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_icd9_diag_codici`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_icd9_diag_codici` ;

CREATE TABLE IF NOT EXISTS  `tbl_icd9_diag_codici` (
  `codice_diag` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `codice_categoria` VARCHAR(6)  ,
  `codice_descrizione` VARCHAR(120)  ,
  PRIMARY KEY (`codice_diag`),
  INDEX `codie_categoria` (`codice_categoria` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_icd9_esami_strumenti_codici`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_icd9_esami_strumenti_codici` ;

CREATE TABLE IF NOT EXISTS  `tbl_icd9_esami_strumenti_codici` (
  `esame_codice` VARCHAR(7)  ,
  `esame_descrizione` VARCHAR(120)  ,
  INDEX `fk_tbl_loinc_tbl_indagini_1_idx` (`esame_codice` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_indagini`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_indagini` ;

CREATE TABLE IF NOT EXISTS  `tbl_indagini` (
  `id_indagine` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_centro_indagine` INT(10) UNSIGNED NULL DEFAULT NULL,
  `id_diagnosi` INT(10) UNSIGNED NULL DEFAULT NULL,
  `id_paziente` INT(10) UNSIGNED NOT NULL,
  `id_cpp` INT(10) UNSIGNED NULL DEFAULT NULL,
  `careprovider` TEXT  ,
  `indagine_data` DATE NOT NULL,
  `indagine_aggiornamento` DATE NOT NULL,
  `indagine_stato` VARCHAR(12)  ,
  `indagine_tipologia` TEXT  ,
  `indagine_motivo` TEXT  ,
  `indagine_referto` TEXT  ,
  `indagine_allegato` TEXT  ,
  PRIMARY KEY (`id_indagine`),
  INDEX `fk_tbl_indagini_tbl_centri_indagini1_idx` (`id_centro_indagine` ASC),
  INDEX `fk_tbl_indagini_tbl_cpp_persona1_idx` (`id_cpp` ASC),
  CONSTRAINT `fk_tbl_indagini_tbl_care_provider_idx`
    FOREIGN KEY (`id_cpp`)
    REFERENCES  `tbl_care_provider` (`id_cpp`)
    ON DELETE NO ACTION,
  CONSTRAINT `fk_tbl_indagini_tbl_centri_indagini1_idx`
    FOREIGN KEY (`id_centro_indagine`)
    REFERENCES  `tbl_centri_indagini` (`id_centro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    FOREIGN KEY (`id_diagnosi`)
    REFERENCES  `tbl_diagnosi` (`id_diagnosi`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
    FOREIGN KEY (`id_paziente`)
    REFERENCES  `tbl_pazienti` (`id_paziente`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table  `tbl_indagini_eliminate`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_indagini_eliminate` ;

CREATE TABLE IF NOT EXISTS  `tbl_indagini_eliminate` (
  `id_indagine_eliminata` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_utente` INT(10) UNSIGNED NOT NULL,
  `id_indagine` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_indagine_eliminata`),
  INDEX `fk_tbl_indagini_eliminate_tbl_indagini1_idx` (`id_indagine` ASC),
  INDEX `fk_tbl_indagini_eliminate_tbl_utenti1_idx` (`id_utente` ASC),
  CONSTRAINT `fk_tbl_indagini_eliminate_tbl_indagini1_idx`
    FOREIGN KEY (`id_indagine`)
    REFERENCES  `tbl_indagini` (`id_indagine`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_indagini_eliminate_tbl_utenti1_idx`
    FOREIGN KEY (`id_utente`)
    REFERENCES  `tbl_utenti` (`id_utente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_loinc`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_loinc` ;

CREATE TABLE IF NOT EXISTS  `tbl_loinc` (
  `codice_loinc` VARCHAR(10)  ,
  `loinc_classe` VARCHAR(100)  ,
  `loinc_componente` VARCHAR(100)  ,
  `loinc_proprieta` VARCHAR(10)  ,
  `loinc_temporizzazione` VARCHAR(10)  ,
  `loinc_sistema` VARCHAR(50)  ,
  `loinc_scala` VARCHAR(5)  ,
  `loinc_metodo` VARCHAR(25)  ,
  INDEX `fk_tbl_loinc_tbl_loinc1_idx` (`codice_loinc` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_loinc_valori`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_loinc_valori` ;

CREATE TABLE IF NOT EXISTS  `tbl_loinc_valori` (
  `id_esclab` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_codice` VARCHAR(10)  ,
  `valore_normale` VARCHAR(120)  ,
  PRIMARY KEY (`id_esclab`),
  INDEX `fk_tbl_loinc_valori_tbl_loinc1_idx` (`id_codice` ASC),
  CONSTRAINT `fk_tbl_loinc_valori_tbl_loinc1_idx`
    FOREIGN KEY (`id_codice`)
    REFERENCES  `tbl_loinc` (`codice_loinc`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 18;


-- -----------------------------------------------------
-- Table  `tbl_operazioni_log`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_operazioni_log` ;

CREATE TABLE IF NOT EXISTS  `tbl_operazioni_log` (
  `id_operazione` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_audit_log` INT(10) UNSIGNED NOT NULL,
  `operazione_codice` CHAR(2)  ,
  `operazione_orario` TIME NOT NULL,
  PRIMARY KEY (`id_operazione`),
  INDEX `fk_tbl_operazioni_log_tbl_codici_operazioni1_idx` (`operazione_codice` ASC),
  INDEX `fk_tbl_operazioni_log_tbl_auditlog_log1_idx` (`id_audit_log` ASC),
  CONSTRAINT `fk_tbl_operazioni_log_tbl_auditlog_log1_idx`
    FOREIGN KEY (`id_audit_log`)
    REFERENCES  `tbl_auditlog_log` (`id_audit`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_operazioni_log_tbl_codici_operazioni1_idx`
    FOREIGN KEY (`operazione_codice`)
    REFERENCES  `tbl_codici_operazioni` (`id_codice`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_parametri_vitali`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_parametri_vitali` ;

CREATE TABLE IF NOT EXISTS  `tbl_parametri_vitali` (
  `id_parametro_vitale` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_paziente` INT(10) UNSIGNED NOT NULL,
  `id_audit_log` INT(10) UNSIGNED NOT NULL,
  `parametro_altezza` SMALLINT(6) NOT NULL,
  `parametro_peso` SMALLINT(6) NOT NULL,
  `parametro_pressione_minima` SMALLINT(6) NOT NULL,
  `parametro_pressione_massima` SMALLINT(6) NOT NULL,
  `parametro_frequenza_cardiaca` SMALLINT(6) NOT NULL,
  `parametro_dolore` TINYINT(4) NOT NULL,
  PRIMARY KEY (`id_parametro_vitale`),
  INDEX `fk_tbl_parametri_vitali_tbl_auditlog_log1_idx` (`id_audit_log` ASC),
  CONSTRAINT `fk_tbl_parametri_vitali_tbl_auditlog_log1_idx`
    FOREIGN KEY (`id_audit_log`)
    REFERENCES  `tbl_auditlog_log` (`id_audit`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    FOREIGN KEY (`id_paziente`)
    REFERENCES  `tbl_pazienti` (`id_paziente`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table  `tbl_tipologie_contatti`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_tipologie_contatti` ;

CREATE TABLE IF NOT EXISTS  `tbl_tipologie_contatti` (
  `id_tipologia_contatto` SMALLINT(6) NOT NULL,
  `tipologia_nome` VARCHAR(50)  ,
  INDEX `fk_tbl_tipologie_contatti_tbl_contatti_pazienti1_idx` (`id_tipologia_contatto` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_pazienti_contatti`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_pazienti_contatti` ;

CREATE TABLE IF NOT EXISTS  `tbl_pazienti_contatti` (
  `id_contatto` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_paziente` INT(10) UNSIGNED NOT NULL,
  `id_contatto_tipologia` SMALLINT(6) NOT NULL,
  `contatto_nominativo` VARCHAR(45)  ,
  `contatto_telefono` VARCHAR(15)  ,
  PRIMARY KEY (`id_contatto`),
  INDEX `fk_tbl_contatti_pazienti_tbl_tipologie_contatti1_idx` (`id_contatto_tipologia` ASC),
  INDEX `fk_tbl_contatti_pazienti_tbl_pazienti1_idx` (`id_paziente` ASC),
  CONSTRAINT `fk_tbl_contatti_pazienti_tbl_pazienti1_idx`
    FOREIGN KEY (`id_paziente`)
    REFERENCES  `tbl_pazienti` (`id_paziente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_contatti_pazienti_tbl_tipologie_contatti1_idx`
    FOREIGN KEY (`id_contatto_tipologia`)
    REFERENCES  `tbl_tipologie_contatti` (`id_tipologia_contatto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_pazienti_decessi`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_pazienti_decessi` ;

CREATE TABLE IF NOT EXISTS  `tbl_pazienti_decessi` (
  `id_paziente` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `paziente_data_decesso` DATE NOT NULL,
  PRIMARY KEY (`id_paziente`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_pazienti_familiarita`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_pazienti_familiarita` ;

CREATE TABLE IF NOT EXISTS  `tbl_pazienti_familiarita` (
  `id_familiarita` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_paziente` INT(10) UNSIGNED NOT NULL,
  `id_parente` INT(10) UNSIGNED NOT NULL,
  `familiarita_grado_parentela` VARCHAR(25)  ,
  `familiarita_aggiornamento_data` DATE NOT NULL,
  `familiarita_conferma` TINYINT(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_familiarita`),
  INDEX `fk_tbl_pazienti_familiarita_tbl_utenti1_idx` (`id_parente` ASC),
  INDEX `fk_tbl_pazienti_familiarita_tbl_pazienti1_idx` (`id_paziente` ASC),
  CONSTRAINT `fk_tbl_pazienti_familiarita_tbl_pazienti1_idx`
    FOREIGN KEY (`id_paziente`)
    REFERENCES  `tbl_pazienti` (`id_paziente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_pazienti_familiarita_tbl_utenti1_idx`
    FOREIGN KEY (`id_parente`)
    REFERENCES  `tbl_utenti` (`id_utente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE EncounterReason (
Code VARCHAR(15) PRIMARY KEY,
Text VARCHAR(50) NOT NULL, 

INDEX code_encounter_reason(Code)
);


-- -----------------------------------------------------
-- Table  `tbl_pazienti_visite`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_pazienti_visite` ;

CREATE TABLE IF NOT EXISTS  `tbl_pazienti_visite` (
  `id_visita` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_cpp` INT(10) UNSIGNED NOT NULL, -- ABBIAMO IL VINCOLO CHE DEVE PARTECIPARE ALMENO UN CPP ALLA VISITA
  `id_paziente` INT(10) UNSIGNED NOT NULL,
  `visita_data` DATE NOT NULL,
  `visita_motivazione` VARCHAR(100)  ,
  `visita_osservazioni` TEXT COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  `visita_conclusioni` TEXT COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  `stato_visita` TEXT  ,
  `codice_priorit` INT(10) UNSIGNED NOT NULL,
  `tipo_richiesta` TEXT  ,
  `status` TEXT  ,
  `richiesta_visita_inizio` DATE NULL DEFAULT NULL,
  `richiesta_visita_fine` DATE NULL DEFAULT NULL,
  PRIMARY KEY (`id_visita`),
  INDEX `fk_tbl_pazienti_visite_tbl_medici1_idx` (`id_cpp` ASC),
  CONSTRAINT `fk_tbl_pazienti_visite_tbl_medici1_idx`
    FOREIGN KEY (`id_cpp`)
    REFERENCES  `tbl_care_provider` (`id_cpp`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    FOREIGN KEY (`id_paziente`)
    REFERENCES  `tbl_pazienti` (`id_paziente`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1;


CREATE TABLE Esito (
Code VARCHAR(15) PRIMARY KEY,
id_visita INT(10) UNSIGNED NOT NULL, 

FOREIGN KEY (`id_visita`)
REFERENCES  `tbl_pazienti_visite` (`id_visita`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	
		FOREIGN KEY (`Code`)
    REFERENCES  `EncounterReason` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);

CREATE TABLE EncounterParticipantType (
Code CHAR(30) PRIMARY KEY,
Text VARCHAR(50) NOT NULL
);

CREATE TABLE VisitaCP (
id_visita INT(10) UNSIGNED NOT NULL,
id_cpp INT(10) UNSIGNED NOT NULL,
Start_Period DATE,
End_Period DATE ,
tipo CHAR(30) ,

    FOREIGN KEY (`id_cpp`)
    REFERENCES  `tbl_care_provider` (`id_cpp`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (`id_visita`)
    REFERENCES  `tbl_pazienti_visite` (`id_visita`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (`tipo`)
    REFERENCES  `EncounterParticipantType` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);




-- -----------------------------------------------------
-- Table  `tbl_proc_cat`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_proc_cat` ;

CREATE TABLE IF NOT EXISTS  `tbl_proc_cat` (
  `codice` INT(10) UNSIGNED NOT NULL,
  `descrizione` VARCHAR(25)  ,
  PRIMARY KEY (`codice`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_proc_outcome`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_proc_outcome` ;

CREATE TABLE IF NOT EXISTS  `tbl_proc_outcome` (
  `codice` INT(10) UNSIGNED NOT NULL,
  `descrizione` VARCHAR(25)  ,
  PRIMARY KEY (`codice`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_proc_status`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_proc_status` ;

CREATE TABLE IF NOT EXISTS  `tbl_proc_status` (
  `codice` VARCHAR(20)  ,
  `descrizione` TEXT  ,
  PRIMARY KEY (`codice`),
  UNIQUE INDEX `tbl_proc_status_codice_unique` (`codice` ASC))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_proc_terapeutiche`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_proc_terapeutiche` ;

CREATE TABLE ProcedureCode (
Code VARCHAR(10) PRIMARY KEY,
Text VARCHAR(50) NOT NULL
);

CREATE TABLE ProcedureReasonCode (
Code VARCHAR(10) PRIMARY KEY,
Text VARCHAR(50) NOT NULL
);

CREATE TABLE ProcedureNotDoneReason (
Code VARCHAR(20) PRIMARY KEY,
Text VARCHAR(50) NOT NULL
);

CREATE TABLE ProcedureBodySite (
Code VARCHAR(10) PRIMARY KEY,
Text VARCHAR(50) NOT NULL
);

CREATE TABLE ProcedureFollowUp (
Code VARCHAR(15) PRIMARY KEY,
Text VARCHAR(50) NOT NULL
);

CREATE TABLE ProcedureComplication (
Code VARCHAR(20) PRIMARY KEY,
Text VARCHAR(50) NOT NULL
);

CREATE TABLE IF NOT EXISTS  `tbl_proc_terapeutiche` (
  `id_Procedure_Terapeutiche` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `descrizione` VARCHAR(45) COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  `Data_Esecuzione` DATE NOT NULL,
  `Paziente` INT(10) UNSIGNED NOT NULL,
  `Diagnosi` INT(10) UNSIGNED NOT NULL,
  `CareProvider` INT(10) UNSIGNED NOT NULL,
  `Codice_icd9` VARCHAR(7)  ,
  `Status` VARCHAR(20)  ,
  `code` VARCHAR(10)  ,
  `reasonCode` VARCHAR(10)  ,
  `bodySite` VARCHAR(10)  ,
  `followUp` VARCHAR(10)  ,
  `notDoneReason` VARCHAR(20) NOT NULL,
  `complication` VARCHAR(20) NOT NULL,
  `Category` INT(10) UNSIGNED NOT NULL,
  `outCome` INT(10) UNSIGNED NOT NULL,
  `note` TEXT COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  PRIMARY KEY (`id_Procedure_Terapeutiche`),
  INDEX `fk_tb_cpp_tb_procedure_treapeutiche` (`CareProvider` ASC),
  INDEX `fk_tb_icd9_tb_procedure_treapeutiche` (`Codice_icd9` ASC),
  INDEX `fk_tb_proc_category` (`Category` ASC),
  INDEX `fk_tb_proc_outcome` (`outCome` ASC),
  INDEX `fk_tb_proc_status` (`Status` ASC),
  CONSTRAINT `fk_tb_cpp_tb_procedure_treapeutiche`
    FOREIGN KEY (`CareProvider`)
    REFERENCES  `tbl_care_provider` (`id_cpp`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    FOREIGN KEY (`Diagnosi`)
    REFERENCES  `tbl_diagnosi` (`id_diagnosi`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_icd9_tb_procedure_treapeutiche`
    FOREIGN KEY (`Codice_icd9`)
    REFERENCES  `Tbl_ICD9_ICPT` (`Codice_ICD9`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    FOREIGN KEY (`Paziente`)
    REFERENCES  `tbl_pazienti` (`id_paziente`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_proc_category`
    FOREIGN KEY (`Category`)
    REFERENCES  `tbl_proc_cat` (`codice`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_proc_outcome`
    FOREIGN KEY (`outCome`)
    REFERENCES  `tbl_proc_outcome` (`codice`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tb_proc_status`
    FOREIGN KEY (`Status`)
    REFERENCES  `tbl_proc_status` (`codice`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	    FOREIGN KEY (`code`)
    REFERENCES  `ProcedureCode` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (`reasonCode`)
    REFERENCES  `ProcedureReasonCode` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
		FOREIGN KEY (`bodySite`)
    REFERENCES  `ProcedureBodySite` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
			FOREIGN KEY (`followUp`)
    REFERENCES  `ProcedureFollowUp` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
				FOREIGN KEY (`notDoneReason`)
    REFERENCES  `ProcedureNotDoneReason` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
					FOREIGN KEY (`complication`)
    REFERENCES  `ProcedureComplication` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)

ENGINE = InnoDB
AUTO_INCREMENT = 2;


-- -----------------------------------------------------
-- Table  `tbl_recapiti`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_recapiti` ;

CREATE TABLE IF NOT EXISTS  `tbl_recapiti` (
  `id_contatto` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_utente` INT(10) UNSIGNED NOT NULL,
  `id_comune_residenza` INT(10) UNSIGNED NOT NULL,
  `id_comune_nascita` INT(10) UNSIGNED ,
  `contatto_telefono` VARCHAR(30)  ,
  `contatto_indirizzo` VARCHAR(100)  ,
  PRIMARY KEY (`id_contatto`),
    FOREIGN KEY (`id_comune_residenza`)
    REFERENCES  `tbl_comuni` (`id_comune`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    FOREIGN KEY (`id_utente`)
    REFERENCES  `tbl_utenti` (`id_utente`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1;


-- -----------------------------------------------------
-- Table  `tbl_taccuino`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_taccuino` ;

CREATE TABLE IF NOT EXISTS  `tbl_taccuino` (
  `id_taccuino` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_paziente` INT(10) UNSIGNED NOT NULL,
  `taccuino_descrizione` VARCHAR(45)  ,
  `taccuino_data` DATE NOT NULL,
  `taccuino_report_anteriore` LONGBLOB NOT NULL,
  `taccuino_report_posteriore` LONGBLOB NOT NULL,
  PRIMARY KEY (`id_taccuino`),
  INDEX `fk_tbl_taccuino_tbl_pazienti1_idx` (`id_paziente` ASC),
  CONSTRAINT `fk_tbl_taccuino_tbl_pazienti1_idx`
    FOREIGN KEY (`id_paziente`)
    REFERENCES  `tbl_pazienti` (`id_paziente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


CREATE TABLE ImmunizationVaccineCode (
Code VARCHAR(10) PRIMARY KEY,
Text VARCHAR(50) NOT NULL

);

CREATE TABLE ImmunizationStatus (
Code VARCHAR(20) PRIMARY KEY
);

CREATE TABLE ImmunizationRoute (
Code CHAR(10) PRIMARY KEY,
Text VARCHAR(30) NOT NULL
);

-- -----------------------------------------------------
-- Table  `tbl_vaccinazione`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_vaccinazione` ;

CREATE TABLE IF NOT EXISTS  `tbl_vaccinazione` (
  `id_vaccinazione` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_paziente` INT(10) UNSIGNED NOT NULL,
  `id_cpp` INT(10) UNSIGNED NOT NULL,
  `vaccineCode` VARCHAR(10) NOT NULL,
  `vaccinazione_confidenzialita` SMALLINT(6) NOT NULL,
  `vaccinazione_data` DATE NOT NULL,
  `vaccinazione_aggiornamento` VARCHAR(45)  ,
  `vaccinazione_stato` VARCHAR(20) NOT NULL,
  `vaccinazione_notGiven` TINYINT(1) NOT NULL,
  `vaccinazione_quantity` INT(11) NOT NULL,
  `vaccinazione_route` CHAR(10) ,
  `vaccinazione_note` VARCHAR(45)  ,
  `vaccinazione_explanation` TEXT COLLATE 'utf8mb4_unicode_ci' NULL DEFAULT NULL,
  PRIMARY KEY (`id_vaccinazione`),
  INDEX `fk_tbl_vaccinazione_tbl_livelli_confidenzialita1_idx` (`vaccinazione_confidenzialita` ASC),
  INDEX `fk_tbl_vaccinazione_tbl_care_provider1_idx` (`id_cpp` ASC),
  INDEX `fk_tbl_vaccinazione_tbl_pazienti1_idx` (`id_paziente` ASC),
  CONSTRAINT `fk_tbl_vaccinazione_tbl_care_provider1_idx`
    FOREIGN KEY (`id_cpp`)
    REFERENCES  `tbl_care_provider` (`id_cpp`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_vaccinazione_tbl_livelli_confidenzialita1_idx`
    FOREIGN KEY (`vaccinazione_confidenzialita`)
    REFERENCES  `tbl_livelli_confidenzialita` (`id_livello_confidenzialita`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_vaccinazione_tbl_pazienti1_idx`
    FOREIGN KEY (`id_paziente`)
    REFERENCES  `tbl_pazienti` (`id_paziente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	
FOREIGN KEY (`vaccineCode`)
    REFERENCES  `ImmunizationVaccineCode` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	
	FOREIGN KEY (`vaccinazione_stato`)
    REFERENCES  `ImmunizationStatus` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	
		FOREIGN KEY (`vaccinazione_route`)
    REFERENCES  `ImmunizationRoute` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_vaccinazioni_reaction`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_vaccinazioni_reaction` ;

CREATE TABLE IF NOT EXISTS  `tbl_vaccinazioni_reaction` (
  `id_vacc_reaction` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `id_vaccinazione` INT(10) UNSIGNED NOT NULL,
  `date` DATE NOT NULL,
  `id_centro` INT(10) UNSIGNED NOT NULL,
  `reported` TINYINT(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_vacc_reaction`),
  INDEX `fk_tbl_centri_indagini_tbl_reazioni` (`id_centro` ASC),
  INDEX `fk_tbl_reazioni_tbl_vaccinazione` (`id_vaccinazione` ASC),
  CONSTRAINT `fk_tbl_centri_indagini_tbl_reazioni`
    FOREIGN KEY (`id_centro`)
    REFERENCES  `tbl_centri_indagini` (`id_centro`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_tbl_reazioni_tbl_vaccinazione`
    FOREIGN KEY (`id_vaccinazione`)
    REFERENCES  `tbl_vaccinazione` (`id_vaccinazione`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_vaccini`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_vaccini` ;

CREATE TABLE IF NOT EXISTS  `tbl_vaccini` (
  `id_vaccino` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_vaccinazione` INT(10) UNSIGNED NOT NULL,
  `vaccino_codice` VARCHAR(7)  ,
  `vaccino_descrizione` TEXT  ,
  `vaccino_nome` TEXT  ,
  `vaccino_durata` INT(11) NOT NULL,
  `vaccino_manufactured` VARCHAR(45)  ,
  `vaccino_expirationDate` DATE NOT NULL,
  `Codice_ATC` CHAR(7)  ,
  PRIMARY KEY (`id_vaccino`),
  INDEX `fk_tbl_vaccino_tbl_vaccinazione1_idx` (`id_vaccinazione` ASC),
  INDEX `Codice_ATC` (`Codice_ATC` ASC),
  CONSTRAINT `fk_tbl_vaccino_tbl_vaccinazione1_idx`
    FOREIGN KEY (`id_vaccinazione`)
    REFERENCES  `tbl_vaccinazione` (`id_vaccinazione`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `tbl_vaccini_ibfk_1`
    FOREIGN KEY (`Codice_ATC`)
    REFERENCES  `ATC_Sottogruppo_Chimico` (`Codice_ATC`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table  `tbl_visita_specialization`
-- -----------------------------------------------------
-- -- DROP  IF EXISTS  `tbl_visita_specialization` ;

CREATE TABLE IF NOT EXISTS  `tbl_visita_specialization` (
  `id_vs` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `id_visita` INT(10) UNSIGNED NOT NULL,
  `id_specialization` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_vs`),
  INDEX `FOREIGN_Specialization_idx` (`id_specialization` ASC),
  CONSTRAINT `FOREIGN_Specialization_idx`
    FOREIGN KEY (`id_specialization`)
    REFERENCES  `tbl_specialization` (`id_spec`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    FOREIGN KEY (`id_visita`)
    REFERENCES  `tbl_pazienti_visite` (`id_visita`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB
AUTO_INCREMENT = 1;

-- Marital Status

CREATE TABLE IF NOT EXISTS `Stati_matrimoniali` (
code CHAR(3) PRIMARY KEY,
display VARCHAR(20))
ENGINE = InnoDB;

-- Ruolo_Amministratore 

CREATE TABLE IF NOT EXISTS `Ruoli_amministratori` (
Ruolo VARCHAR(30) PRIMARY KEY)
ENGINE = InnoDB;



-- Utenti_Amministrativi

CREATE TABLE IF NOT EXISTS  `Utenti_Amministrativi` (
  `id_utente` INT(10) UNSIGNED NOT NULL,
  `Ruolo` VARCHAR(45) NOT NULL,
  `Tipi_Dati_Trattati` VARCHAR(45) NOT NULL,
  `Nome` VARCHAR(45) NOT NULL,
  `Cognome` VARCHAR(45) NOT NULL,
  `Sesso` CHAR(1) NOT NULL,
  `Codice_Fiscale` VARCHAR(16) NOT NULL,
  `Data_Nascita` DATE NOT NULL,
  `Comune_Nascita` INT UNSIGNED NOT NULL,
  `Comune_Residenza` INT UNSIGNED NOT NULL,
  `Indirizzo` VARCHAR(45) NOT NULL,
  `Recapito_Telefonico` INT NOT NULL,
  `Stato_Civile` CHAR(3) NOT NULL,
  INDEX `Tit-Residenza_idx` (`Comune_Residenza` ASC),
  INDEX `Tit-Nascita_idx` (`Comune_Nascita` ASC),
  CONSTRAINT `Tit-Audit`
    FOREIGN KEY (`id_utente`)
    REFERENCES  `tbl_utenti` (`id_utente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `Tit-Nascita`
    FOREIGN KEY (`Comune_Nascita`)
    REFERENCES  `tbl_comuni` (`id_comune`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `Tit-Residenza`
    FOREIGN KEY (`Comune_Residenza`)
    REFERENCES  `tbl_comuni` (`id_comune`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    FOREIGN KEY (`Ruolo`)
    REFERENCES  `Ruoli_amministratori` (`Ruolo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
    FOREIGN KEY (`Stato_Civile`)
    REFERENCES  `Stati_matrimoniali` (`code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- Documento 

CREATE TABLE IF NOT EXISTS `Documenti` (
Id_Documento INT UNSIGNED PRIMARY KEY,	
Tipo VARCHAR(30),
`Id_Amministratore` INT(10) UNSIGNED NOT NULL,
 FOREIGN KEY (`Id_Amministratore`)
    REFERENCES  `Utenti_Amministrativi` (`id_utente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
)
ENGINE = InnoDB;

-- Moduli GS

CREATE TABLE IF NOT EXISTS `Moduli_Gruppo_Sanguigno` (
Id_Modulo INT UNSIGNED PRIMARY KEY,
Id_Paziente INT(10) UNSIGNED NOT NULL,	
documento LONGBLOB NOT NULL,
data_caricamento DATE NOT NULL,
data_convalida DATE,
note VARCHAR(255), 
Stato TINYINT(1) NOT NULL DEFAULT '0', 
Id_Amministratore INT(10) UNSIGNED,
FOREIGN KEY (Id_Amministratore)
    REFERENCES  Utenti_Amministrativi (id_utente)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION, 
    
    FOREIGN KEY (`id_Paziente`)
    REFERENCES  `tbl_pazienti` (`id_paziente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- Trattamenti_Pazienti

CREATE TABLE IF NOT EXISTS `Trattamenti_Pazienti` (
Id_Trattamento INT UNSIGNED PRIMARY KEY,
Nome_T VARCHAR(255) NOT NULL,
Finalita_T VARCHAR(255) NOT NULL,
Modalita_T VARCHAR(255) NOT NULL,
Informativa VARCHAR(500) NOT NULL,
Incaricati VARCHAR(255) NOT NULL)
ENGINE = InnoDB;


-- Trattamenti_CP

CREATE TABLE IF NOT EXISTS `Trattamenti_CP` (
Id_Trattamento INT UNSIGNED PRIMARY KEY,
Nome_T VARCHAR(255) NOT NULL,
Finalita_T VARCHAR(255) NOT NULL,
Modalita_T VARCHAR(255) NOT NULL,
Informativa VARCHAR(500) NOT NULL,
Incaricati VARCHAR(255) NOT NULL)
ENGINE = InnoDB;

-- Consenso Paziente

CREATE TABLE IF NOT EXISTS `Consenso_Paziente` (
Id_Trattamento INT UNSIGNED NOT NULL,
Id_Paziente INT(10) UNSIGNED NOT NULL,	
Consenso TINYINT(1) NOT NULL DEFAULT '0',
data_consenso DATE NOT NULL,
FOREIGN KEY (Id_Trattamento)
    REFERENCES  Trattamenti_Pazienti (Id_Trattamento)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION, 
    
    FOREIGN KEY (`Id_Paziente`)
    REFERENCES  `tbl_pazienti` (`id_paziente`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- Consenso Care Provider

CREATE TABLE IF NOT EXISTS `Consenso_CP` (
Id_Trattamento INT UNSIGNED NOT NULL,
Id_Cpp INT(10) UNSIGNED NOT NULL,	
Consenso TINYINT(1) NOT NULL DEFAULT '0',
data_consenso DATE NOT NULL,
FOREIGN KEY (Id_Trattamento)
    REFERENCES  Trattamenti_CP(Id_Trattamento)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION, 
    
    FOREIGN KEY (`Id_Cpp`)
    REFERENCES  `tbl_care_provider` (`id_cpp`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- --------------------------------------------------------------------FINE
CREATE TABLE ContactRelationship (
Code CHAR(3) PRIMARY KEY,
Display VARCHAR(50) NOT NULL
);

CREATE TABLE PatientContact (
Id_Patient INT(10) UNSIGNED ,
Relationship CHAR(3) NOT NULL,
Name CHAR(30) NOT NULL,
Surname CHAR(30) NOT NULL,
Telephone VARCHAR (15),
Mail VARCHAR(50),


FOREIGN KEY (`Id_Patient`)
    REFERENCES  `tbl_pazienti` (`id_paziente`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,

FOREIGN KEY (Relationship)
    REFERENCES  ContactRelationship(Code)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);


CREATE TABLE TipoContatto (
Code CHAR(15) PRIMARY KEY,
Text VARCHAR(30) NOT NULL
);


CREATE TABLE Contatto (
id_contatto INT(10) UNSIGNED PRIMARY KEY,
attivo TINYINT(1) DEFAULT '0',
tipo CHAR(15) NOT NULL,
nome CHAR(30) NOT NULL,
cognome CHAR(30) NOT NULL,
sesso CHAR(10) NOT NULL,
indirizzo_residenza VARCHAR(100) NOT NULL,
telefono VARCHAR (15) NULL,
mail VARCHAR(50) NULL,
data_nascita DATE NOT NULL,
data_inizio DATE NOT NULL,
data_fine DATE NOT NULL,

	FOREIGN KEY (`sesso`)
    REFERENCES  `Gender` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,

FOREIGN KEY (tipo)
    REFERENCES  TipoContatto(Code)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
	
	);

CREATE TABLE VisitaContatto (
id_visita INT(10) UNSIGNED NOT NULL,
id_contatto INT(10) UNSIGNED NOT NULL,
Start_Period DATE,
End_Period DATE ,
tipo CHAR(10) ,

    FOREIGN KEY (`id_contatto`)
    REFERENCES  `Contatto` (`id_contatto`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (`id_visita`)
    REFERENCES  `tbl_pazienti_visite` (`id_visita`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (`tipo`)
    REFERENCES  `EncounterParticipantType` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);

CREATE TABLE DeviceStatus (
Code VARCHAR(20) PRIMARY KEY
);

CREATE TABLE DeviceType (
Code VARCHAR(10) PRIMARY KEY,
Text VARCHAR(50) NOT NULL
);

CREATE TABLE DispositivoMedico (
id_dispositivo INT(10) UNSIGNED PRIMARY KEY,
tipologia VARCHAR(10) NOT NULL,
modello VARCHAR(30) NOT NULL,
fabbricante VARCHAR(30) NOT NULL,
confidenza SMALLINT(6) NOT NULL,
note VARCHAR(255),
	FOREIGN KEY (`tipologia`)
    REFERENCES  `DeviceType` (`Code`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


CREATE TABLE DispositivoImpiantabile (
id_dis INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
id_dispositivo INT(10) UNSIGNED NOT NULL,
id_paziente INT(10) UNSIGNED NOT NULL,
id_cpp INT(10) UNSIGNED NOT NULL,
stato VARCHAR(20) NOT NULL,
data_impianto DATE NOT NULL,
	FOREIGN KEY (stato)
    REFERENCES  DeviceStatus (Code)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (id_dispositivo)
    REFERENCES DispositivoMedico (id_dispositivo)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (id_paziente)
    REFERENCES  tbl_pazienti (id_paziente)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (id_cpp)
    REFERENCES  tbl_care_provider (id_cpp)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

	
	
CREATE TABLE AllergyIntolleranceClinicalStatus (
Code VARCHAR(10) PRIMARY KEY
);	
CREATE TABLE AllergyIntolleranceVerificationStatus (
Code VARCHAR(20) PRIMARY KEY
);
CREATE TABLE AllergyIntolleranceType (
Code VARCHAR(15) PRIMARY KEY
);
CREATE TABLE AllergyIntolleranceCategory (
Code VARCHAR(15) PRIMARY KEY
);
CREATE TABLE AllergyIntolleranceCriticality (
Code VARCHAR(20) PRIMARY KEY
);
CREATE TABLE AllergyIntolleranceCode (
Code VARCHAR(10) PRIMARY KEY,
Text VARCHAR(50) NOT NULL
);
	
	
CREATE TABLE AllergyIntollerance (
id_AI INT(10) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
clinicalStatus VARCHAR(10) NOT NULL,
verificationStatus VARCHAR(20) NOT NULL,
tipo VARCHAR(15) NOT NULL,
category VARCHAR(15) NOT NULL,
criticality VARCHAR(20) NOT NULL,
id_paziente INT(10) UNSIGNED NOT NULL ,
assertedDate DATE NOT NULL,
recorder INT(10) UNSIGNED NOT NULL, 
lastOccurance DATE NOT NULL,
note DATE NOT NULL,
code VARCHAR(10) NOT NULL,
confidenza SMALLINT(6) NOT NULL,

	FOREIGN KEY (clinicalStatus)
    REFERENCES  AllergyIntolleranceClinicalStatus (Code)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (verificationStatus)
    REFERENCES  AllergyIntolleranceVerificationStatus (Code)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (tipo)
    REFERENCES  AllergyIntolleranceType (Code)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (category)
    REFERENCES  AllergyIntolleranceCategory (Code)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (criticality)
	REFERENCES  AllergyIntolleranceCriticality (Code)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (id_paziente)
    REFERENCES  tbl_pazienti (id_paziente)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (recorder) -- id_cpp oppure id_paziente
    REFERENCES  tbl_care_provider (id_cpp)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (recorder) -- id_cpp oppure id_paziente
    REFERENCES  tbl_pazienti (id_paziente)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (code)
    REFERENCES  AllergyIntolleranceCode (Code)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (confidenza)
    REFERENCES  tbl_livelli_confidenzialita (id_livello_confidenzialita)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);

CREATE TABLE AllergyIntolleranceReactionSubstance (
Code VARCHAR(10) PRIMARY KEY,
Text VARCHAR(50) NOT NULL
);	

CREATE TABLE AllergyIntolleranceReactionManifestation (
Code VARCHAR(10) PRIMARY KEY,
Text VARCHAR(50) NOT NULL
);	
CREATE TABLE AllergyIntolleranceReactionSeverity (
Code VARCHAR(10) PRIMARY KEY
);	
CREATE TABLE AllergyIntolleranceReactionExposureRoute (
Code VARCHAR(10) PRIMARY KEY,
Text VARCHAR(50) NOT NULL
);	
	
CREATE TABLE AllergyIntolleranceReaction (
id_AI INT(10) UNSIGNED NOT NULL,
substance VARCHAR(10) NOT NULL,
manifestation VARCHAR(10) NOT NULL,
description VARCHAR(255) NOT NULL,
onset DATE NOT NULL,
severity VARCHAR(10) NOT NULL,
exposureRoute VARCHAR(10) NOT NULL ,
note VARCHAR(255) NOT NULL ,

	FOREIGN KEY (id_AI)
    REFERENCES  AllergyIntollerance (id_AI)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (substance)
    REFERENCES  AllergyIntolleranceReactionSubstance (Code)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (manifestation)
    REFERENCES  AllergyIntolleranceReactionManifestation (Code)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (severity)
    REFERENCES  AllergyIntolleranceReactionSeverity (Code)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
	FOREIGN KEY (exposureRoute)
    REFERENCES  AllergyIntolleranceReactionExposureRoute (Code)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION
);




	
	
	
	
	
	
