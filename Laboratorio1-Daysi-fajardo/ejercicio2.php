<!DOCTYPE html> 
<html> 
<head>     
    <title>Resultados de Notas</title>     
    <style>         
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            text-align: center;
        }
        h2 {
            color: #333;
        }
        form {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: inline-block;
            margin-bottom: 20px;
        }
        input {
            margin: 5px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #218838;
        }
        table {
            border-collapse: collapse;
            width: 60%;
            margin: 20px auto;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .aprobado {
            background-color: #90EE90;
        }
        .reprobado {
            background-color: #FF7F7F;
        }
    </style>
</head> 
<body>     
    <h2>Ingresar Notas</h2>     
    <form method="post">         
        Nombre: <input type="text" name="nombre" required>         
        Teórico: <input type="number" step="0.1" name="teorico" required>         
        Práctico: <input type="number" step="0.1" name="practico" required>         
        Trabajo: <input type="number" step="0.1" name="trabajo" required>         
        Proyecto: <input type="number" step="0.1" name="proyecto" required>         
        <button type="submit">Agregar</button>     
    </form>      
    <h2>Resultados Notas</h2>     
    <table>         
        <tr>             
            <th>Alumno</th>             
            <th>Promedio individual</th>             
            <th>Estado</th>         
        </tr>         
        <?php         
        //session_start();         
        if (!isset($_SESSION['alumnos'])) {             
            $_SESSION['alumnos'] = [];         
        }         
        if ($_SERVER["REQUEST_METHOD"] == "POST") {             
            $nuevo_alumno = [                 
                "nombre" => $_POST['nombre'],                 
                "teorico" => floatval($_POST['teorico']),                 
                "practico" => floatval($_POST['practico']),                 
                "trabajo" => floatval($_POST['trabajo']),                 
                "proyecto" => floatval($_POST['proyecto'])             
            ];             
            $_SESSION['alumnos'][] = $nuevo_alumno;         
        }         
        $aprobados = 0;         
        $reprobados = 0;         
        $promedio_grupal = 0;         
        $total_alumnos = count($_SESSION['alumnos']);         
        foreach ($_SESSION['alumnos'] as $alumno) {             
            $promedio = ($alumno["teorico"] * 0.2) + ($alumno["practico"] * 0.2) + ($alumno["trabajo"] * 0.2) + ($alumno["proyecto"] * 0.4);             
            $estado = $promedio >= 6 ? "Aprobado" : "Reprobado";             
            $clase = $promedio >= 6 ? "aprobado" : "reprobado";             
            if ($estado == "Aprobado") {                 
                $aprobados++;             
            } else {                 
                $reprobados++;             
            }             
            $promedio_grupal += $promedio;             
            echo "<tr class='$clase'><td>{$alumno['nombre']}</td><td>" . number_format($promedio, 2) . "</td><td>$estado</td></tr>";         
        }         
        if ($total_alumnos > 0) {             
            $promedio_grupal /= $total_alumnos;             
            $porcentaje_aprobados = ($aprobados / $total_alumnos) * 100;             
            $porcentaje_reprobados = ($reprobados / $total_alumnos) * 100;         
        } else {             
            $promedio_grupal = $porcentaje_aprobados = $porcentaje_reprobados = 0;         
        }         
        ?>     
    </table>     
    <br>     
    <p><strong>Promedio grupal:</strong> <?php echo number_format($promedio_grupal, 2); ?></p>     
    <p><strong>% de Aprobados:</strong> <?php echo number_format($porcentaje_aprobados, 2); ?>%</p>     
    <p><strong>% de Reprobados:</strong> <?php echo number_format($porcentaje_reprobados, 2); ?>%</p> 
</body> 
</html>
