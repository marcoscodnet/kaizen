ALTER TABLE stockpieza ADD ds_remito VARCHAR( 255 ) NULL ;
ALTER TABLE estadopedido ENGINE = innodb ;
ALTER TABLE pedido ENGINE = innodb ;
ALTER TABLE pieza ENGINE = innodb ;
ALTER TABLE proveedor ENGINE = innodb ;
ALTER TABLE stockpieza ENGINE = innodb ;
ALTER TABLE ventapieza ENGINE = innodb ;
ALTER TABLE ventapieza_unidad ENGINE = innodb ;
ALTER TABLE ventapieza_unidad ADD cd_sucursal INT NOT NULL AFTER cd_pieza ;
ALTER TABLE ADD INDEX fk_ventapieza_has_pieza_sucursal1 ( cd_sucursal ) ;
ALTER TABLE ventapieza_unidad DROP PRIMARY KEY ,
ADD PRIMARY KEY ( cd_ventapieza , cd_pieza , cd_sucursal ); 

ALTER TABLE ventapieza ADD cd_usuario INT NOT NULL ;

ALTER TABLE ventapieza ADD INDEX ( cd_usuario ) ;

CREATE TABLE servicio (
cd_servicio INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
dt_carga DATETIME NOT NULL ,
cd_cliente INT NOT NULL ,
cd_vehiculo_servicio INT NOT NULL ,
cd_tipo_servicio INT NOT NULL ,
ds_kmshoras VARCHAR( 100 ) NOT NULL ,
ds_obsgral TEXT NULL ,
ds_descpedidocte TEXT NULL ,
dt_ingresovehiculo DATE NULL DEFAULT '0000-00-00',
ds_diagyreprealizada TEXT NULL ,
ds_repuestosusados TEXT NULL ,
ds_mecanicos TEXT NULL ,
ds_instmedusados TEXT NULL ,
ds_tiempomanoobra VARCHAR( 255 ) NULL ,
dt_compromisoentrega DATE NULL DEFAULT '0000-00-00',
cd_usuario INT NOT NULL ,
nu_monto FLOAT NOT NULL DEFAULT '0',
bl_pagado BINARY NOT NULL DEFAULT '0',
INDEX ( cd_cliente ),
INDEX (cd_vehiculo_servicio),
INDEX (cd_tipo_servicio ),
INDEX (cd_usuario)
) ENGINE = INNODB CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE tipo_servicio (
cd_tipo_servicio INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
ds_tipo_servicio VARCHAR( 255 ) NOT NULL
) ENGINE = innodb CHARACTER SET utf8 COLLATE utf8_unicode_ci;

CREATE TABLE vehiculo_servicio (
cd_vehiculo_servicio INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
ds_modelo VARCHAR( 255 ) NULL ,
nu_anio VARCHAR( 10 ) NULL ,
nu_chasis VARCHAR( 50 ) NULL ,
nu_motor VARCHAR( 50 ) NULL,
dt_venta DATE NULL DEFAULT '0000-00-00'
) ENGINE = innodb CHARACTER SET utf8 COLLATE utf8_unicode_ci;

ALTER TABLE servicio ADD FOREIGN KEY ( cd_cliente ) REFERENCES cliente (
cd_cliente
);

ALTER TABLE servicio ADD FOREIGN KEY ( cd_vehiculo_servicio ) REFERENCES vehiculo_servicio (
cd_vehiculo_servicio
);

ALTER TABLE servicio ADD FOREIGN KEY ( cd_tipo_servicio ) REFERENCES tipo_servicio (
cd_tipo_servicio
);

ALTER TABLE servicio ADD FOREIGN KEY ( cd_usuario ) REFERENCES usuario (
cd_usuario
);

INSERT INTO funcion (
cd_funcion ,
ds_funcion
)
VALUES (
NULL , 'Alta Tipo de servicio'
);
INSERT INTO funcion (
cd_funcion ,
ds_funcion
)
VALUES (
NULL , 'Baja Tipo de servicio'
);
INSERT INTO funcion (
cd_funcion ,
ds_funcion
)
VALUES (
NULL , 'Ver Tipo de servicio'
);
INSERT INTO funcion (
cd_funcion ,
ds_funcion
)
VALUES (
NULL , 'Modificar Tipo de servicio'
);
INSERT INTO funcion (
cd_funcion ,
ds_funcion
)
VALUES (
NULL , 'Listar Tipo de servicio'
);

INSERT INTO menuoption (
cd_menuoption ,
nombre ,
href ,
cd_funcion ,
orden ,
cd_menugroup ,
cssclass ,
descripcion_panel
)
VALUES (
NULL , 'Tipos de servicios', 'doAction?action=listar_tiposservicios', '174', '9', '2', 'tiposservicios', 'Tipos de <br/> servicios'
);

INSERT INTO funcion (
cd_funcion ,
ds_funcion
)
VALUES (
NULL , 'Alta Servicio'
);
INSERT INTO funcion (
cd_funcion ,
ds_funcion
)
VALUES (
NULL , 'Baja Servicio'
);
INSERT INTO funcion (
cd_funcion ,
ds_funcion
)
VALUES (
NULL , 'Ver Servicio'
);
INSERT INTO funcion (
cd_funcion ,
ds_funcion
)
VALUES (
NULL , 'Modificar Servicio'
);
INSERT INTO funcion (
cd_funcion ,
ds_funcion
)
VALUES (
NULL , 'Listar Servicio'
);

INSERT INTO menuoption (
cd_menuoption ,
nombre ,
href ,
cd_funcion ,
orden ,
cd_menugroup ,
cssclass ,
descripcion_panel
)
VALUES (
NULL , 'Servicios', 'doAction?action=listar_servicios', '179', '9', '3', 'servicios', 'Servicios'
);

INSERT INTO funcion (
cd_funcion ,
ds_funcion
)
VALUES (
NULL , 'Ver resumen de servicio'
);

INSERT INTO funcion (
cd_funcion ,
ds_funcion
)
VALUES (
NULL , 'Imprimir Orden de Servicio'
);

####################### 24/05/2013 ######################################
  ALTER TABLE `venta` CHANGE `dt_venta` `dt_venta` DATETIME NULL DEFAULT '0000-00-00 00:00:00' 

####################### 14/12/2013 ######################################
ALTER TABLE `localidad`
	ADD COLUMN `ds_cp` VARCHAR(20) NULL AFTER `cd_provincia`;
	
UPDATE `localidad` SET `ds_cp`='1900' WHERE  `cd_localidad`=62;
UPDATE `localidad` SET `ds_cp`='1925' WHERE  `cd_localidad`=48;
UPDATE `localidad` SET `ds_cp`='1896' WHERE  `cd_localidad`=38;
UPDATE `localidad` SET `ds_cp`='1923' WHERE  `cd_localidad`=368;

####################### 17/04/2018 ######################################

ALTER TABLE `servicio`
	ADD COLUMN `cd_sucursal` INT(11) NULL AFTER `bl_pagado`;

ALTER TABLE `servicio`
	ADD CONSTRAINT `FK_servicio_sucursal` FOREIGN KEY (`cd_sucursal`) REFERENCES `sucursal` (`cd_sucursal`);

SET FOREIGN_KEY_CHECKS = 0;
UPDATE servicio INNER JOIN usuario
ON servicio.cd_usuario = usuario.cd_usuario 
SET servicio.cd_sucursal = usuario.cd_sucursal;
SET FOREIGN_KEY_CHECKS = 1;

##########################24/08/2020#######################################

ALTER TABLE `producto`
	ADD COLUMN `bl_discontinuo` BINARY(1) NULL DEFAULT '0' AFTER `cd_color`;
	
ALTER TABLE `usuario`
	ADD COLUMN `bl_activo` BINARY(1) NULL DEFAULT '1' AFTER `cd_perfil`;
