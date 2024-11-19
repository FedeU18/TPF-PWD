<?php
include_once "../../config.php";
include_once "../../vendor/autoload.php";
$session = new Session();
$objProducto = new ABMProducto();

$carrito = $session->obtenerProductosCarrito();

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();
$stripe_secret_key = $_ENV["stripe_secret_key"];

$productosCarrito = [];
foreach ($carrito as $idProducto => $cantidad) {
  $producto = $objProducto->buscar(['idproducto' => $idProducto])[0];
  $productoInfo = [
    'idproducto' => $idProducto,
    'nombre' => $producto->getpronombre(),
    'precio' => $producto->getprecio(),
    'cantidad' => $cantidad,
    'subtotal' => $producto->getprecio() * $cantidad
  ];
  $productosCarrito[] = $productoInfo;
}

$items = [];
foreach ($productosCarrito as $item) {
  $detalle = [
    "quantity" => $item["cantidad"],
    "price_data" => [
      "currency" => "usd",
      "unit_amount" => $item["precio"] * 100, // Convertir a centavos
      "product_data" => [
        "name" => $item["nombre"]
      ]
    ]
  ];
  $items[] = $detalle;
}

\Stripe\Stripe::setApiKey($stripe_secret_key);

$checkout_session = \Stripe\Checkout\Session::create([
  "mode" => "payment",
  "success_url" => "http://localhost/TPF-PWD/Vista/Carrito/exito.php",
  "cancel_url" => "http://localhost/TPF-PWD/Vista/Carrito/carrito.php",
  "locale" => "es",
  "line_items" => $items
]);

// Retornar la URL para redirigir
echo json_encode([
  'success' => true,
  'url' => $checkout_session->url
]);
