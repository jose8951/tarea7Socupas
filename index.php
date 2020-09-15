<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/estilos.css">
    <script src="js/mapas.js"></script>
    <script type='text/javascript' src='http://www.bing.com/api/maps/mapcontrol?callback=GetMap&branch=experimental&key=ApGgUGz23TXxRi6D_b2mfP35WV39HW5VDxoPKzShADXMvADYxLYR6bH7cvgAqms6' async defer></script>

    <title>Document</title>
</head>

<body>
    <header>
        <img src="img/logo.png" alt="logo">
        <nav>
            <ul>
                <li><a id="iniciar">Iniciar Sesión</a></li>
                <li><a id="registrar">Registrarte</a></li>
                <li><a id="escaparate">Escaparate</a></li>
                <li><a id="insertar">Insertar</a></li>
                <li><a id="salir">Salir</a></li>
            </ul>
        </nav>
    </header>

    <div class="correcto"></div>

    <!--mapa-->
    <div id="contenedorMapa" hidden>
        <div id="myMap"></div>
        <div class="ruta">
            Origen: <input id="origen" type="text" />
            Destino: <input id="destino" type="text" />
            <button id='btnCalcularRuta' onclick="GetDirections()">Calcular ruta</button>
            <button id="cerrarMapa">Cerrar</button>
        </div>
    </div>
    
    <!-- FORMULARIO INSERTAR ANUNCIOS -->
    <div id="insertarForm" hidden>
        <form method="post" id="insForm">
            <fieldset>
                <legend class="nombreInsertar">Ingresar Anuncio</legend>
                <label for="moroso">Moroso:</label>
                <input type="text" id="moroso" name="moroso" maxlength="60" required="required" />
               <br>
                <label for="localidad">Localidad:</label>
                <input type="text" id="localidad" name="localidad" maxlength="60" required="required" />
               <br>
                <label for="descripcion">Descripción:</label>
                <input type="text" id="descripcion" name="descripcion" maxlength="500" required="required" /><br /><br />
                <div class="errores"></div><br />
                <button id="btnInsertar" hidden>Insertar</button>
                <button id="btnModificar" hidden>Modificar</button>
                <button class="cerrarIns" hidden>Cerrar</button>

            </fieldset>
        </form>
    </div>

    <!-- LISTADO DE ANUNCIOS-->
    <div id="listadoAnuncios" hidden>
        <table>
            <thead>
                <tr>
                    <th>Autor</th>
                    <th>Moroso</th>
                    <th>Localidad</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Eliminar</th>
                    <th>Modificar</th>
                </tr>
            </thead>
            <tbody id="anuncios">
            </tbody>
        </table>
    </div>

     <!-- FORMULARIO INICIAR -->
     <div id="iniciarForm" hidden>
            <form method="post" id="iniForm">
                <fieldset>
                    <legend>Iniciar Sesión</legend><br/>
                    <label for="login">Usuario:</label>
                    <input type="text" id="login" name="login" required="required"/><br/><br/>
                    <label for="password">Contraseña:</label>
                    <input type="password" id="password" name="password" required="required" /><br/><br/>
                    <div class="errores"></div><br/>
                    <button id="btnIniciar">Iniciar</button>
                    <button class="cerrarIni">Cerrar</button>
                </fieldset>
            </form>
        </div>

    <!-- FORMULARIO REGISTRARSE -->
    <div id="registrarForm" hidden>
        <form method="post" id="regForm">
            <fieldset>
                <legend>Registrarse</legend>
                <br /> <label for="loginRegistro">Login:</label>
                <input type="text" id="loginRegistro" name="loginRegistro" maxlength="20" required="required" /><br /><br />
                <label for="passwordRegistro">Password:</label>
                <input type="text" id="passwordRegistro" name="passwordRegistro" maxlength="20" required="required" /><br /><br />
                <label for="passwordRegistro2">Repite password:</label>
                <input type="text" id="passwordRegistro2" name="passwordRegistro2" maxlength="20" required="required" /><br /><br />
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" maxlength="50" required="required" /><br /><br /><br />
                <div class="errores"></div><br />
                <button id="btnRegistrar">Registrar</button>
                <button class="cerrarReg">Cerrar</button>
            </fieldset>
        </form>
    </div>

    <!--JAVASCRIPT -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="js/validar.js"></script>
    <script src="js/JS.js"></script>

</body>

</html>