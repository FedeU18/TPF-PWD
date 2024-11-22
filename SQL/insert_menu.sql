--insert para tabla menú
INSERT INTO
  menu (
    idmenu,
    menombre,
    medescripcion,
    idpadre,
    medeshabilitado
  )
VALUES
  (1, 'cliente', '-', NULL, '0000-00-00 00:00:00'),
  (
    2,
    'administrador',
    '-',
    NULL,
    '0000-00-00 00:00:00'
  ),
  (3, 'deposito', '-', NULL, '0000-00-00 00:00:00'),
  (
    12,
    'Productos',
    '../productos/productos.php',
    1,
    '0000-00-00 00:00:00'
  ),
  (
    13,
    'Compras',
    '../compras/compras.php',
    3,
    '0000-00-00 00:00:00'
  ),
  (
    14,
    'Ver usuarios',
    '../usersAdmin/listaUsers.php',
    2,
    '0000-00-00 00:00:00'
  ),
  (
    15,
    'Ver Carrito',
    '../Carrito/carrito.php',
    1,
    '0000-00-00 00:00:00'
  ),
  (
    16,
    'Menús',
    '../menu/menu.php',
    2,
    '0000-00-00 00:00:00'
  ),
  (
    17,
    'Mi perfil',
    '../perfil/index.php',
    1,
    '0000-00-00 00:00:00'
  ),
  (
    18,
    'Mi perfil',
    '../perfil/index.php',
    2,
    '0000-00-00 00:00:00'
  ),
  (
    19,
    'Mi perfil',
    '../perfil/index.php',
    3,
    '0000-00-00 00:00:00'
  ),
  (
    20,
    'productos',
    '../productos/productos.php',
    2,
    '0000-00-00 00:00:00'
  ),
  (
    21,
    'Productos',
    '../productos/productos.php',
    3,
    '0000-00-00 00:00:00'
  );

--insert para tabla menurol
INSERT INTO
  table_name (idmenu, idrol)
VALUES
  (1, 1);

INSERT INTO
  table_name (idmenu, idrol)
VALUES
  (2, 2);

INSERT INTO
  table_name (idmenu, idrol)
VALUES
  (3, 3);