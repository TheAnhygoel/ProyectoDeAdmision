<!DOCTYPE html_>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddddd;
        }
    </style>

    <title>Book</title>
    <h1>Book</h1>
</head>


<body>

    <!-- pagina -->

    <form method="post" enctype="multipart/form-data">
        <label>Titulo</label>
        <input type="text" name="libro">
        <label>Autor</label>
        <input type="text" name="author">
        <label>Subir archivo</label>
        <input type="File" name="file">
        <input type="submit" name="submit">


    </form>

    <!-- Directorio de guardado -->

    <?php
    $localhost = "Localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "libros";

    $conn = Mysqli_connect($localhost, $dbusername, $dbpassword, $dbname);

    if (isset($_POST["submit"])) {
        $title = $_POST["libro"];

        $pname = rand(1000, 10000) . "-" . $_FILES["file"]["name"];

        $pauthor = $_POST["author"];

        $tname = $_FILES["file"]["tmp_name"];

        $uploads_dir = './libros';
        move_uploaded_file($tname, $uploads_dir . '/' . $pname);

        $sql = "INSERT into fileup(title,archive,author) VALUES('$title','$pname','$pauthor')";

        if (mysqli_query($conn, $sql)) {

            echo "Listo";
        } else {
            echo "El libro lamentablemente y por desgracia. Me temo que dicho libro no va a poder ser elevado a lo que es el sitio";
        }
    }

    ?>



    <!-- TABLA -->


    <?php

    $consultaLibroSql = "SELECT * FROM fileup";

    $result = $conn->query($consultaLibroSql);

    if ($result->num_rows > 0) {
        echo "<table>
         <tr> 
            <th>Titulo</th>
            <th>Autor</th>
            <th>Archivo</th>
            <th>Modificar/Eliminar</th>
         </tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>" .
                "<td>" . $row["title"]   . "</td>" .
                "<td>" . $row["author"]  . "</td>" .
                "<td>" . substr($row["archive"], 5) . "</td>" .
                "<td><i class=\"fa fa-edit\"></i>&nbsp;<i class=\"fa fa-trash\"></i></td>" .
                "</tr>";
        }
        echo "</table>";
    }





    ?>



</body>

</html>