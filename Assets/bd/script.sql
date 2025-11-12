CREATE TABLE mensajes (
    id INT(11) NOT NULL AUTO_INCREMENT,
    CODIGO INT,
    NOMBRE VARCHAR(255),
    TIPO_CAUSA TEXT,
    DIAGNOSTICO TEXT,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    user_c int(2) DEFAULT 0,
    user_m int(2) DEFAULT 0,
    estado int(2) NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`)
);

INSERT INTO mensajes (CODIGO, NOMBRE, TIPO_CAUSA, DIAGNOSTICO) VALUES
(101, 'VOLTAJE DE BATERÍA BAJO', 'El voltaje de la batería está por debajo de 9 voltios.', '1.Verifique la batería. 2.Verifique los cables de la batería.'),
(102, 'FALLA DE ENTRADA DIGITAL', 'Las entradas digitales han estado cambiando una vez por segundo durante los últimos 10 segundos.', 'Esta condición indica ruido en la línea, una conexión suelta o un sensor defectuoso.'),
(103, 'VOLTAJE DE SALIDA < 180 V', 'El motor está en funcionamiento y el campo del excitador está energizado, pero el voltaje de salida está por debajo de 360 voltios durante 30 segundos.', 'Revise el alternador para ver si tiene un rendimiento bajo.'),
(104, 'FILTRO DE AIRE BLOQUEADO', 'No utilizado', ''),
(105, 'NIVEL DE REFRIGERANTE BAJO', 'El Sensor de Nivel de Refrigerante indica un nivel bajo de refrigerante durante 30 segundos.', '1.Verifique el nivel de refrigerante. 2.Verifique el Sensor de Nivel de Refrigerante. 3.Verifique los circuitos hacia el Sensor de Nivel de Refrigerante.'),
(106, 'SALIDA DE FRECUENCIA BAJA', 'La frecuencia de salida está por debajo de 45 Hz durante 30 segundos (RPM del motor por debajo de 1350)', 'Verifique y ajuste la velocidad del motor.'),
(107, 'FRECUENCIA DE SALIDA ALTA', 'La frecuencia de salida está por encima de 70 Hz durante 30 segundos (RPM del motor por encima de 2100).', 'Verifique y ajuste la velocidad del motor.'),
(108, 'NIVEL DE ACEITE BAJO', 'El interruptor de nivel de aceite indica un nivel bajo de aceite durante 3 minutos.', '1.Verifique el nivel de aceite. 2.Verifique el interruptor de nivel de aceite. 3.Verifique los circuitos hacia el interruptor de nivel de aceite.'),
(109, 'EL CONTADOR DE HORAS 1 HA EXCEDIDO EL UMBRAL', 'El Contador de Horas 1 (HM1) ha excedido el umbral establecido en el Menú de Configuración.', 'Reconozca el mensaje para reiniciar el temporizador.'),
(110, 'EL CONTADOR DE HORAS 2 HA EXCEDIDO EL UMBRAL', 'El Contador de Horas 2 (HM2) ha excedido el umbral establecido en el Menú de Configuración.', 'Reconozca el mensaje para reiniciar el temporizador.'),
(111, 'NIVEL DE COMBUSTIBLE BAJO', 'El nivel de combustible está por debajo del "Nivel de Combustible" establecido en el Menú de Configuración.', '1.Verifique el nivel de combustible. 2.Verifique el Sensor de Nivel de Combustible. 3.Verifique los circuitos hacia el Sensor de Nivel de Combustible.'),
(112, 'FALLA DEL SENSOR DE RPM DEL MOTOR', 'El motor está en funcionamiento y la entrada del Interruptor de Baja Presión de Aceite está alta (conectada a tierra), pero las RPM están por debajo de 800.', '1.Verifique el Sensor de RPM. 2.Verifique los circuitos hacia el Sensor de RPM.'),
(113, 'FALLA DEL SENSOR DE TEMPERATURA DEL AGUA', 'La lectura del sensor de temperatura del agua está por debajo de -40 °C (-40 °F) o por encima de 130 °C (266 °F).', '1.Verifique los circuitos del sensor y las conexiones de cableado. 2.Verifique si el sensor está defectuoso.'),
(114, 'BAJA PRESIÓN DE ACEITE', 'El motor está en funcionamiento y la entrada del Interruptor de Baja Presión de Aceite está baja (conectada a tierra) durante 60 segundos.', '1.Verifique el nivel de aceite. 2.Verifique la presión de aceite usando el submenú de Entradas Analógicas del Menú de Datos. 3.Verifique el Interruptor de Baja Presión de Aceite. 4.Verifique el circuito OPS.'),
(115, 'FALLA DE RETROALIMENTACIÓN RL6 (CALENTADOR DE AIRE)', 'No hay retroalimentación cuando el relé está energizado, o hay retroalimentación cuando el relé no está energizado.', '1.Verifique el relé RL6 (Precalentamiento). 2.Verifique los circuitos PHR, PPHR y FPHR.'),
(116, 'EL TEMPORIZADOR DE CUENTA REGRESIVA HA EXPIRADO', 'Si el contador de horas excede la configuración del usuario.', '1.Reconozca el mensaje y reinicie el temporizador.'),
(117, 'ALTA PRESIÓN DE ACEITE MIENTRAS EL MOTOR NO ESTÁ FUNCIONANDO', 'Durante la entrada PTI, la entrada del Interruptor de Baja Presión de Aceite está alta (no conectada a tierra) cuando el motor no estaba funcionando.', '1.Verifique el Interruptor de Baja Presión de Aceite. 2.Verifique el circuito OPS.'),
(118, 'FALLA DEL INTERRUPTOR DE PRESIÓN DE ACEITE', 'La entrada del Interruptor de Baja Presión de Aceite está alta (no conectada a tierra) antes de que el motor arranque.', '1.Verifique el Interruptor de Baja Presión de Aceite. 2.Verifique el circuito OPS.'),
(119, 'ALTA TEMPERATURA DEL AGUA', 'Si la temperatura del agua es >107 °C durante 5 segundos - reiniciando.', '1.Verifique el sensor de temperatura del agua. 2.Verifique el circuito WTP/WTN.'),
(120, 'EL MOTOR NO ARRANCÓ', 'El motor no arrancó.', '1.Verifique la batería, los cables de la batería y el motor de arranque. 2.Verifique el circuito 8S. 3.Verifique el Relay de Arranque. 4.Verifique si el motor o el alternador están bloqueados.'),
(121, 'EL MOTOR NO ARRANCÓ', 'No hay presión de aceite y no alcanzó las 800 RPM - reiniciando.', '1.Verifique el nivel de combustible. 2.Verifique el solenoide de combustible, la bomba de combustible y el sistema de combustible tanto eléctrica como mecánicamente. 3.En temperaturas ambientales frías, verifique si el combustible se está gelificando. 4.Verifique si el filtro de aire o el sistema de admisión de aire están restringidos. 5.Verifique el calentador de aire de admisión.'),
(122, 'SOBRECARGA DEL SISTEMA', 'Si la salida está en cortocircuito - reiniciando.', '1.Desconecte la carga e intente reiniciar. 2.Verifique el circuito de campo del alternador. 3.Verifique el circuito de salida del alternador.'),
(123, 'MOTOR NO FUNCIONANDO RAZÓN DESCONOCIDA', 'Si la presión de aceite es baja y no hay RPM, mientras está en funcionamiento - reiniciando.', '1.Verifique el nivel de combustible. 2.Verifique el solenoide de combustible, la bomba de combustible y el sistema de combustible tanto eléctrica como mecánicamente. 3.En temperaturas ambientales frías, verifique si el combustible se está gelificando. 4.Verifique si el motor o el alternador están bloqueados.'),
(124, 'RPM SIN CARGA MENOR A 1550', 'RPM menor a 1550 después del arranque.', '1.Verifique la velocidad del motor. 2.Verifique el sensor de RPM.'),
(125, 'FALLA DE RETROALIMENTACIÓN DEL SOLENOIDE DE VELOCIDAD', 'No hay retroalimentación cuando el relé está energizado, o hay retroalimentación cuando el relé no está energizado.', '1.Verifique el relé RL3 (Solenoide de Velocidad [Acelerador]). 2.Verifique el circuito 7D.'),
(126, 'SENSOR DE NIVEL DE COMBUSTIBLE FUERA DE RANGO', 'La lectura del nivel de combustible está por encima del valor máximo del tanque.', '1.Verifique el sensor de nivel de combustible. 2.Verifique los circuitos FPOS, FNEG y FOUT. 3.Verifique la configuración del tamaño del tanque de combustible en el submenú de Configuración del Sistema.'),
(127, 'DISMINUCIÓN RÁPIDA DEL NIVEL DE COMBUSTIBLE', 'La lectura del nivel de combustible disminuyó más rápido de lo normalmente esperado. NOTA: Debe usar la contraseña (0007) para borrar este mensaje.', '1.Verifique si hay fugas en el tanque de combustible. 2.Verifique si se ha retirado combustible del tanque de combustible.');


CREATE TABLE alarmas (
    id INT(11) NOT NULL AUTO_INCREMENT,
    CODIGO INT,
    NOMBRE VARCHAR(255),
    TIPO_CAUSA TEXT,
    DIAGNOSTICO TEXT,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT NULL,
    user_c int(2) DEFAULT 0,
    user_m int(2) DEFAULT 0,
    estado int(2) NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`)
);

INSERT INTO alarmas (CODIGO, NOMBRE, TIPO_CAUSA, DIAGNOSTICO) VALUES
(101, 'TEMPERATURA DE AGUA ELEVADA', 'Alarma de reinicio retrasado: El motor está en funcionamiento y las temperaturas del agua están por encima de 107 °C (225 °F) durante 25 segundos. Luego, el motor se detiene e intenta reiniciarse.', '1. Verifique la causa del motor sobrecalentado: Revise el nivel de refrigerante del motor. Revise la correa de la bomba de agua. Revise el flujo de aire del radiador y Restricciones de flujo de refrigerante. 2. Compruebe si el sensor de temperatura del agua esta defectuoso'),
(102, 'FALLÓ AL ARRANCAR', 'Alarma de reinicio retrasado: el motor falló al arrancar. Se convierte en una alarma de apagado cuando el número de intentos de reinicio es mayor que el número de reinicios de arranque establecidos en el menu de configuración.', '1.Verifique la batería, los cables de la batería y el motor de arranque. 2.Verifique el circuito 8S. 3.Verifique el relay de arranque. 4.Verifique si el motor o el alternador están bloqueados.'),
(103, 'FALLÓ AL INICIAR', 'Alarma de reinicio retrasado: El motor falló al arrancar. Se convierte en una alarma de apagado cuando el número de intentos de reinicio es mayor que el número de reinicios de arranque configurado en el menu de configuración.', '1.Verifique el nivel de combustible. 2.Verifique el solenoide de combustible, la bomba de combustible y el sistema de combustible tanto eléctrica como mecánicamente. 3.En temperaturas ambientales frías, verifique si el combustible se esta gelificando. 4.Verifique si el filtro de aire o el sistema de admisión de aire están restringidos. 5.Verifique el calentador de aire de admisión.'),
(104, 'FALLA DE RETROALIMENTACIÓN RL2 (FUEL H)', 'Alarma de apagado: No hay retroalimentación cuando el relay está energizado, o hay retroalimentación cuando el relay no está energizado.', '1.Verifique el relay RL2 (Retencion de Combustible). 2.Verifique el circuito 8D.'),
(105, 'FALLA DE RETROALIMENTACIÓN RL1 (FUEL P)', 'Alarma de apagado: No hay retroalimentación cuando el relay está energizado, o hay retroalimentación cuando el relay no está energizado.', '1.Verifique el relay RL1 (Extracción de Combustible). 2.Verifique el circuito 8D.'),
(106, 'FALLA DE RETROALIMENTACIÓN RL5 (ARRANCADOR)', 'Alarma de apagado: No hay retroalimentación cuando el relay está energizado, o hay retroalimentación cuando el relay no está energizado.', '1.Verifique el relay RL5 (Arranque). 2.Verifique los circuitos SR, PSR y FSR.'),
(107, 'SISTEMA SOBRECARGADO', 'Alarma de reinicio retrasado', '1.Desconecte la carga e intente reiniciar. 2.Verifique el circuito de campo del alternador. 3.Verifique el circuito de salida del alternador.'),
(108, 'MOTOR NO FUNCIONANDO RAZÓN DESCONOCIDA', 'Alarma de reinicio retrasado: La entrada del interruptor de baja presión de aceite está baja (conectada a tierra) y las RPM son iguales a 0 cuando el motor debería estar funcionando. • El motor intentará reiniciar en 20 minutos.', '1.Verifique el nivel de combustible. 2.Verifique el solenoide de combustible, la bomba de combustible y el sistema de combustible tanto eléctrica como mecánicamente. 3.En temperaturas ambientales frías, verifique si el combustible se está gelificando. 4.Verifique si el motor o el alternador están bloqueados.'),
(109, 'BAJO NIVEL DE ACEITE', 'Si el nivel de aceite bajo y la presion de aceite baja estan presentes al mismo tiempo.', '1.Verifique el nivel de aceite. 2.Verifique el Interruptor de Nivel de Aceite. 3.Verifique los circuitos hacia el Interruptor de Nivel de Aceite. 4.Verifique la presion de aceite usando el submenu de Entradas Analogicas del Menu de Datos. 5.Verifique el Interruptor de Baja Presion de Aceite. 6.Verifique el circuito OPS.');

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `apellido` varchar(50) NOT NULL,
  `correo` varchar(255) NOT NULL,
  `ruc` varchar(255) NOT NULL,
  `empresa` varchar(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  `user_c` int(2) DEFAULT 0,
  `user_m` int(2) DEFAULT 0,
  `estado` int(2) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuarios` (`id`, `usuario`, `nombre`, `apellido`, `correo`, `ruc`, `empresa`, `created_at`, `updated_at`, `user_c`, `user_m`, `estado`) VALUES
(1, 'admin', 'admin', 'admin', 'admin@gmail.com', '-', 'SAC ADMIN', CURRENT_TIMESTAMP, NULL, 0, 0, 1),
(2, 'pgrillo', 'Pinocho', 'Grillo', 'pgrillo@gmail.com', '12345678901', 'SAC PINOCHO', CURRENT_TIMESTAMP, NULL, 0, 0, 1);


CREATE TABLE `mantenimientos`(
    `id` INT(11) NOT NULL AUTO_INCREMENT,
    `dispositivo` VARCHAR(255),
    `fecha_ultimo_mantenimiento` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `horometro_actual` INT(11),
    `condicion` VARCHAR(255),
    `tipo_mantenimiento` VARCHAR(255),
    `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    `user_c` INT(2) DEFAULT 0,
    `user_m` INT(2) DEFAULT 0,
    `estado` INT(2) NOT NULL DEFAULT 1,
    PRIMARY KEY (`id`)
) 

/*ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;*/


/*INSERT INTO `mantenimientos` (`id`, `dispositivo`, `fecha_ultimo_mantenimiento`, `proximo_mantenimiento`, `horometro_actual`, `tipo_mantenimiento`, `created_at`, `updated_at`, `user_c`, `user_m`, `estado`) VALUES
(1, '11111111','2024-09-01 00:00:00', '2024-09-01 00:00:00', 0, 'M1', '2024-09-01 00:00:00', NULL, 0, 0, 1);*/
