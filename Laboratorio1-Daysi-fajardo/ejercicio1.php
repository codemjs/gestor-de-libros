<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura - Pastelito</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
            margin: 20px;
        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px gray;
            width: 50%;
            margin: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color:rgb(32, 184, 192);
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 10px;
            margin: 5px 0 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"], button {
            background-color:rgb(134, 225, 251);
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            margin: 5px;
        }
        input[type="submit"]:hover, button:hover {
            background-color:rgb(39, 141, 175);
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Factura - Pastelito</h2>

        <form method="POST" action="">
            <div id="productos">
                <div class="producto">
                    <input type="text" name="nombre[]" placeholder="Nombre del Producto" required>
                    <input type="number" name="cantidad[]" placeholder="Cantidad" min="1" required>
                    <input type="number" step="0.01" name="precio[]" placeholder="Precio Unitario" required>
                </div>
            </div>
            <button type="button" onclick="agregarProducto()">Agregar otro producto</button><br><br>
            <input type="submit" value="Actualizar Factura">
            <button type="button" onclick="window.print()">Imprimir Factura</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nombres = $_POST['nombre'];
            $cantidades = $_POST['cantidad'];
            $precios = $_POST['precio'];
            $totalFactura = 0;

            if (!empty($nombres)) {
                echo "<table>";
                echo "<tr>
                        <th>Nombre del Producto</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                      </tr>";

                for ($i = 0; $i < count($nombres); $i++) {
                    $nombre = $nombres[$i];
                    $cantidad = $cantidades[$i];
                    $precio = $precios[$i];
                    $total = $cantidad * $precio;
                    $totalFactura += $total;

                    echo "<tr>
                            <td>$nombre</td>
                            <td>$cantidad</td>
                            <td>$" . number_format($precio, 2) . "</td>
                            <td>$" . number_format($total, 2) . "</td>
                          </tr>";
                }

                echo "<tr>
                        <th colspan='3'>Total a Pagar</th>
                        <th>$" . number_format($totalFactura, 2) . "</th>
                      </tr>";
                echo "</table>";
            }
        }
        ?>
    </div>

    <script>
        function agregarProducto() {
            var contenedor = document.getElementById('productos');
            var nuevoProducto = document.createElement('div');
            nuevoProducto.classList.add('producto');

            nuevoProducto.innerHTML = `
                <input type="text" name="nombre[]" placeholder="Nombre del Producto" required>
                <input type="number" name="cantidad[]" placeholder="Cantidad" min="1" required>
                <input type="number" step="0.01" name="precio[]" placeholder="Precio Unitario" required>
            `;

            contenedor.appendChild(nuevoProducto);
        }
    </script>
</body>
</html>
