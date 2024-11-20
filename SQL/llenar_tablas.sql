INSERT INTO
  `rol` (`idrol`, `rodescripcion`)
VALUES
  (1, 'Cliente'),
  (2, 'Administrador'),
  (3, 'Depósito');

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

  Compras y productos para llenar

  
INSERT INTO `compra` (`idusuario`)
VALUES 
(20), id clientes
(21);


INSERT INTO `compraestado` (`idcompra`, `idcompraestadotipo`, `cefechaini`)
VALUES 
(1, 1, NOW()),
(2, 1, NOW());


INSERT INTO `producto` (`pronombre`, `prodetalle`, `procantstock`, `precio`)
VALUES
('Producto A', 'Detalle del producto A', 100, 150),
('Producto B', 'Detalle del producto B', 50, 300);


INSERT INTO `compraitem` (`idproducto`, `idcompra`, `cicantidad`)
VALUES
(1, 1, 2),
(2, 1, 1);


INSERT INTO `compraitem` (`idproducto`, `idcompra`, `cicantidad`)
VALUES
(1, 2, 1),
(2, 2, 2);
