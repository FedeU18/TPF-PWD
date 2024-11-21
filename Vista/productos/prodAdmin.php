<?php
if (basename($_SERVER['PHP_SELF']) === 'prodAdmin.php') {
  header("Location: Productos.php");
  exit;
}
$objProductos = new ABMProducto();
$productos = $objProductos->buscar(null);
?>



<div class="table-responsive">
<a href="formAgregarProd.php" class="btn btn-primary">Agregar productos</a><br><br>

<div id="toast" class="toast"></div>

<br><br>
  <table class="table table-striped table-bordered">
    <thead class="table-dark">
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Detalle</th>
        <th>Precio</th>
        <th>Stock</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($productos)) { ?>
        <?php foreach ($productos as $producto) { ?>
          <tr>
            <td><?php echo htmlspecialchars($producto->getidproducto()); ?></td>
            <td><?php echo htmlspecialchars($producto->getpronombre()); ?></td>
            <td><?php echo htmlspecialchars($producto->getprodetalle()); ?></td>
            <td>$<?php echo htmlspecialchars($producto->getprecio()); ?></td>
            <td><?php echo htmlspecialchars($producto->getprocantstock()); ?></td>
            <td>
                <a href="editarProducto.php?id=<?php echo $producto->getidproducto(); ?>" class="btn btn-warning btn-sm">Editar</a>
                <button class="btn btn-danger btn-sm eliminar-producto" id="btn-eliminarProd" data-id="<?php echo $producto->getidproducto(); ?>">Eliminar</button>
                

              </td>

          </tr>
        <?php } ?>
      <?php } else { ?>
        <tr>
          <td colspan="6" class="text-center">No se encontraron productos.</td>
        </tr>
      <?php } ?>
    </tbody>
  </table>
</div>
<style>
  
  .toast {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: #333;
    color: #fff;
    padding: 15px 20px;
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    opacity: 0;
    transform: translateY(50px);
    transition: opacity 0.3s ease, transform 0.3s ease;
    z-index: 1000;
  }

  .toast.show {
    opacity: 1;
    transform: translateY(0);
  }

  .toast.success {
    background-color: #28a745; /* Verde */
  }

  .toast.error {
    background-color: #dc3545; /* Rojo */
  }

</style>




<script>
  function showToast(message, type = "success") {
  const toast = document.getElementById("toast");
  
  // Aplicar clase según el tipo de mensaje
  toast.className = `toast ${type} show`;
  toast.textContent = message;
  
  // Ocultar el mensaje después de 3 segundos
  setTimeout(() => {
    toast.className = "toast";
  }, 3000);
}


$(document).ready(function() {
  $(".eliminar-producto").click(function(e) {
    e.preventDefault();

    let idProducto = $(this).data('id');

    if (confirm('¿Estás seguro de que deseas eliminar este producto?')) {
      $.ajax({
        type: 'POST',
        url: 'eliminarProducto.php',
        data: { id: idProducto },
        dataType: 'json',
        success: function(respuesta) {
          console.log(respuesta)
          if (respuesta.success) {
            showToast(respuesta.message, "success");
            
          } else {
            showToast(respuesta.message, "error");
          }
        },
        error: function(error) {
          console.log(error)
          showToast("Error en la conexión al servidor.", "error");
        }
      });
    }
  });
});

</script>


<?php include_once "../../estructura/footer.php"; ?>
