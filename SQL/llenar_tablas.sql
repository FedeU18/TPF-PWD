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
INSERT INTO
  `compra` (`idusuario`)
VALUES
  (20),
  id clientes (21);

INSERT INTO
  `compraestado` (`idcompra`, `idcompraestadotipo`, `cefechaini`)
VALUES
  (1, 1, NOW()),
  (2, 1, NOW());

INSERT INTO
  `producto` (
    `pronombre`,
    `prodetalle`,
    `procantstock`,
    `precio`
  )
VALUES
  ('Producto A', 'Detalle del producto A', 100, 150),
  ('Producto B', 'Detalle del producto B', 50, 300);

INSERT INTO
  `compraitem` (`idproducto`, `idcompra`, `cicantidad`)
VALUES
  (1, 1, 2),
  (2, 1, 1);

INSERT INTO
  `compraitem` (`idproducto`, `idcompra`, `cicantidad`)
VALUES
  (1, 2, 1),
  (2, 2, 2);

-- registros para productos:
INSERT INTO
  producto (
    idproducto,
    precio,
    pronombre,
    prodetalle,
    procantstock
  )
VALUES
  (
    1,
    750,
    'Laptop HP',
    'Laptop con procesador Intel Core i5, 8GB de RAM, 256GB SSD.',
    20
  ),
  (
    2,
    35,
    'Teclado Logitech',
    'Teclado inalámbrico con teclas retroiluminadas.',
    50
  ),
  (
    3,
    25,
    'Mouse Razer',
    'Mouse gamer con sensor de alta precisión.',
    30
  ),
  (
    4,
    200,
    'Monitor Samsung',
    'Monitor Full HD de 24 pulgadas.',
    15
  ),
  (
    5,
    150,
    'Auriculares Sony',
    'Auriculares inalámbricos con cancelación de ruido.',
    25
  ),
  (
    6,
    50,
    'Disco Duro Seagate',
    'Disco duro externo de 2TB.',
    40
  ),
  (
    7,
    850,
    'Cámara Nikon',
    'Cámara réflex digital con lente de 18-55mm.',
    10
  ),
  (
    8,
    400,
    'Smartphone Xiaomi',
    'Smartphone con pantalla AMOLED y 128GB de almacenamiento.',
    35
  ),
  (
    9,
    120,
    'Impresora Canon',
    'Impresora multifunción con conectividad Wi-Fi.',
    12
  ),
  (
    10,
    650,
    'Tablet Apple',
    'Tablet con pantalla Retina de 10.2 pulgadas y 64GB de almacenamiento.',
    18
  );