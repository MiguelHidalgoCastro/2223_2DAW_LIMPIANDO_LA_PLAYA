<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="estilo.css" rel="stylesheet">
    <title>Alta</title>
</head>
<body>
    <form method="POST" action="controlador.php">
        <label>Usuario
            <input type="text" name="nombre"/>
        </label>
        <label>Contraseña
            <input type="password" name="pass"/>
        </label>
        <label>
          <input type="submit" name="submit" value="submit"/>
        </label>  
    </form>
</body>
</html>