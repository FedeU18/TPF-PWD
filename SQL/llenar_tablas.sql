INSERT INTO
  `rol` (`idrol`, `rodescripcion`)
VALUES
  (1, 'Cliente'),
  (2, 'Administrador'),
  (3, 'Depósito');

-- Usuario con varios roles
INSERT INTO
  `usuariorol` (`idusuario`, `idrol`)
VALUES
  (1, 1),
  -- JuanPerez -> Cliente
  (2, 2),
  -- AdminMaster -> Administrador
  (3, 3),
  -- DepoUser -> Depósito
  (4, 1),
  -- ClienteTest -> Cliente
  (5, 1),
  -- MultiRolUser -> Cliente
  (5, 2),
  -- MultiRolUser -> Administrador
  (5, 3);

--MODIFICAR TABLA PRECIO
-- Cambiar el tipo de dato de la columna `pronombre` a `VARCHAR(50)`
ALTER TABLE
  `producto`
MODIFY
  `pronombre` VARCHAR(50) NOT NULL;

-- Agregar la nueva columna `precio`
ALTER TABLE
  `producto`
ADD
  COLUMN `precio` INT(11) NOT NULL
AFTER
  `idproducto`;