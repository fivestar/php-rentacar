CREATE  TABLE IF NOT EXISTS `rentacar`.`user` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(100) NOT NULL ,
  `email` VARCHAR(100) NOT NULL ,
  `password` VARCHAR(100) NOT NULL ,
  `tel` VARCHAR(20) NULL ,
  `birthday` DATE NULL ,
  `activation_key` VARCHAR(100) NULL ,
  `created_at` DATETIME NOT NULL ,
  `updated_at` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

CREATE  TABLE IF NOT EXISTS `rentacar`.`car_class` (
  `id` INT NOT NULL ,
  `name` VARCHAR(20) NOT NULL ,
  `car_types` VARCHAR(100) NOT NULL ,
  `seats` VARCHAR(20) NOT NULL ,
  `image` VARCHAR(255) NULL ,
  `price3` DECIMAL(9,3) NOT NULL ,
  `price6` DECIMAL(9,3) NOT NULL ,
  `price12` DECIMAL(9,3) NOT NULL ,
  `price24` DECIMAL(9,3) NOT NULL ,
  `insurance_price` DECIMAL(9,3) NOT NULL ,
  `created_at` DATETIME NOT NULL ,
  `updated_at` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

CREATE  TABLE IF NOT EXISTS `rentacar`.`location` (
  `id` INT NOT NULL ,
  `name` VARCHAR(255) NOT NULL ,
  `created_at` DATETIME NOT NULL ,
  `updated_at` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) )
ENGINE = InnoDB;

CREATE  TABLE IF NOT EXISTS `rentacar`.`reservation` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `user_id` INT NOT NULL ,
  `car_class_id` INT NOT NULL ,
  `departure_location_id` INT NOT NULL ,
  `return_location_id` INT NOT NULL ,
  `departure_at` DATETIME NOT NULL ,
  `return_at` DATETIME NOT NULL ,
  `has_insurance` TINYINT NOT NULL ,
  `car_subtotal` DECIMAL(9,3) NULL ,
  `option_subtotal` DECIMAL(9,3) NULL ,
  `total_amount` DECIMAL(9,3) NULL ,
  `note` TEXT NULL ,
  `created_at` DATETIME NOT NULL ,
  `updated_at` DATETIME NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `fk_reservation_user` (`user_id` ASC) ,
  INDEX `fk_reservation_car_type1` (`car_class_id` ASC) ,
  INDEX `fk_reservation_location1` (`departure_location_id` ASC) ,
  INDEX `fk_reservation_location2` (`return_location_id` ASC) ,
  CONSTRAINT `fk_reservation_user`
    FOREIGN KEY (`user_id` )
    REFERENCES `rentacar`.`user` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_reservation_car_type1`
    FOREIGN KEY (`car_class_id` )
    REFERENCES `rentacar`.`car_class` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_reservation_location1`
    FOREIGN KEY (`departure_location_id` )
    REFERENCES `rentacar`.`location` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_reservation_location2`
    FOREIGN KEY (`return_location_id` )
    REFERENCES `rentacar`.`location` (`id` )
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;
