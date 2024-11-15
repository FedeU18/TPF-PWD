INSERT INTO
  `rol` (`idrol`, `rodescripcion`)
VALUES
  (
    1,
    'Cliente'
  ),
  (
    2,
    'Administrador'
  ),
  (
    3,
    'Depósito'
  );

INSERT INTO
  `usuario` (
    `idusuario`,
    `usnombre`,
    `uspass`,
    `usmail`,
    `usdeshabilitado`
  )
VALUES
  (
    1,
    'JuanPerez',
    MD5('password123'),
    'juanperez@example.com',
    NULL
  ),
  -- Cliente
  (
    2,
    'AdminMaster',
    MD5('admin2024'),
    'adminmaster@example.com',
    NULL
  ),
  -- Administrador
  (
    3,
    'DepoUser',
    MD5('deposit123'),
    'depouser@example.com',
    NULL
  ),
  -- Depósito
  (
    4,
    'ClienteTest',
    MD5('cliente123'),
    'clientetest@example.com',
    NULL
  ),
  -- Cliente
  (
    5,
    'MultiRolUser',
    MD5('multirole2024'),
    'multiroleuser@example.com',
    NULL
  );

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

-- MultiRolUser -> Depósito