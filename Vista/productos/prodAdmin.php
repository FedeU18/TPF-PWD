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
                            <button class="btn btn-warning btn-sm editar-producto" id="btn-editarProd"
                                data-id="<?php echo $producto->getidproducto(); ?>">Editar</button>
                            <button
                                class="btn <?php echo ($producto->getprocantstock() < 0) ? 'btn-primary habilitar-producto' : 'btn-danger eliminar-producto'; ?> btn-sm"
                                data-id="<?php echo $producto->getidproducto(); ?>">
                                <?php echo ($producto->getprocantstock() <= -1) ? 'Habilitar' : 'Eliminar'; ?>
                            </button>
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
        // Función para mostrar mensajes tipo "toast"
        function showToast(message, type = "success") {
            const toast = document.getElementById("toast");
            toast.className = `toast ${type} show`;
            toast.textContent = message;
            setTimeout(() => {
                toast.className = "toast";
            }, 3000);
        }

        // Acción para editar producto
        $(".editar-producto").click(function() {
            let btn = $(this);
            let row = btn.closest("tr");
            let idProducto = btn.data("id");

            // Reemplazar celdas con campos de entrada
            row.find("td:eq(1)").html(
                `<input type="text" class="form-control" value="${row.find("td:eq(1)").text().trim()}">`
            );
            row.find("td:eq(2)").html(
                `<input type="text" class="form-control" value="${row.find("td:eq(2)").text().trim()}">`
            );
            row.find("td:eq(3)").html(
                `<input type="number" class="form-control" value="${row.find("td:eq(3)").text().replace('$', '').trim()}">`
            );
            row.find("td:eq(4)").html(
                `<input type="number" class="form-control" value="${row.find("td:eq(4)").text().trim()}">`
            );

            // Cambiar botón "Editar" a "Guardar"
            btn.removeClass("btn-warning").addClass("btn-success").text("Guardar").off("click").click(
                function() {
                    let nuevoNombre = row.find("td:eq(1) input").val().trim();
                    let nuevoDetalle = row.find("td:eq(2) input").val().trim();
                    let nuevoPrecio = row.find("td:eq(3) input").val().trim();
                    let nuevoStock = row.find("td:eq(4) input").val().trim();

                    // Validar campos
                    if (!nuevoNombre || !nuevoDetalle || isNaN(nuevoPrecio) || isNaN(nuevoStock)) {
                        showToast("Por favor, completa todos los campos correctamente.", "error");
                        return;
                    }

                    // Enviar datos con AJAX
                    $.ajax({
                        type: "POST",
                        url: "actionEditarProducto.php",
                        data: {
                            idProducto: idProducto,
                            pronombre: nuevoNombre,
                            prodetalle: nuevoDetalle,
                            precio: nuevoPrecio,
                            procantstock: nuevoStock,
                            accion: "editar",
                        },
                        dataType: "json",
                        success: function(respuesta) {
                            if (respuesta.success) {
                                row.find("td:eq(1)").text(nuevoNombre);
                                row.find("td:eq(2)").text(nuevoDetalle);
                                row.find("td:eq(3)").text(
                                    `$${parseFloat(nuevoPrecio).toFixed(2)}`);
                                row.find("td:eq(4)").text(nuevoStock);

                                // Restaurar botón
                                btn.removeClass("btn-success").addClass("btn-warning").text(
                                    "Editar");
                                showToast(respuesta.message, "success");

                            } else {
                                showToast(respuesta.message, "error");
                            }
                        },
                        error: function(e1) {
                            showToast("Error al conectar con el servidor.", "error");
                            console.log(e1)
                        },
                    });
                });
        });

        // Acción para eliminar producto
        // Acción para eliminar producto
        $(".eliminar-producto, .habilitar-producto").click(function() {
            let btn = $(this);
            let row = btn.closest("tr");
            let idProducto = btn.data("id");
            let pronombre = row.find("td:eq(1)").text().trim();
            let prodetalle = row.find("td:eq(2)").text().trim();
            let precio = parseFloat(row.find("td:eq(3)").text().replace("$", "").trim());
            let procantstock = parseInt(row.find("td:eq(4)").text().trim());
            let accion = $(this).hasClass("habilitar-producto") ? "habilitar" : "eliminar";

            // Enviar datos del producto al servidor
            $.ajax({
                type: "POST",
                url: "eliminarProducto.php",
                data: {
                    id: idProducto,
                    pronombre: pronombre,
                    prodetalle: prodetalle,
                    precio: precio,
                    procantstock: procantstock, // Cambiar stock si es eliminar
                    accion: accion
                },
                dataType: "json",
                success: function(respuesta) {
                    console.log(respuesta);
                    if (respuesta.success) {
                        showToast(respuesta.message, "success");
                        // Recargar para actualizar el estado del botón
                        setTimeout(() => location.reload(), 2000);
                    } else {
                        showToast(respuesta.message, "error");
                    }
                },
                error: function(e) {
                    console.log(e);
                    showToast("Error al conectar con el servidor.", "error");
                }
            });
        });


    });
</script>



<?php include_once "../../estructura/footer.php"; ?>