$(function() {

    /*MOSTRAR ANUNCIOS*/
    $('#listadoAnuncios').attr('hidden', false);
    mostrarAnuncios();
});


/**el nav  */

$('#iniciar').on('click', function() {
    limpiar();
    $('#iniciarForm').removeAttr('hidden');
    $('#btnIniciar').on('click', function(event) {
        event.preventDefault();
        let login = $('#login').val();
        let password = $('#password').val();

        if (validarLogin(login, password)) {
            $.ajax({
                type: 'post',
                url: 'funciones.php',
                datatype: 'text',
                data: {
                    'valor': 'iniciarSesion',
                    'login': login,
                    'password': password
                },
                success: function(respuesta) {
                    res = JSON.parse(respuesta);
                    if (res === 'true') {
                        $('.correcto').html('Bienvenido a ocupa2 ' + login);
                        //muestra el listdado
                        $('#listadoAnuncios').removeAttr('hidden');
                        //oculta el formulario de iniciar
                        $('#iniciarForm').attr('hidden', true);
                        $('#insForm')[0].reset();
                    } else {
                        $('.errores').html(res);
                    }
                }
            });
        } else {
            $('.errores').html(cadena);
        }
    })

    $('.cerrarIni').on('click', function(event) {
        event.preventDefault();
        $('#iniForm')[0].reset();
        $('.errores').html('');
        //oculta el formulario
        limpiar();
        //muestra el listado de okupas
        $('#listadoAnuncios').removeAttr('hidden');
    });
});

$('#registrar').on('click', function() {
    limpiar();
    //muestra el formulario registrar
    $('#registrarForm').removeAttr('hidden');
    $('#btnRegistrar').on('click', function(event) {

        event.preventDefault();
        let log = $('#loginRegistro').val();
        let pass = $('#passwordRegistro').val();
        let pass2 = $('#passwordRegistro2').val();
        let email = $('#email').val();
        if (validarRegistro(log, pass, pass2, email)) {

            $.ajax({
                type: 'post',
                url: 'funciones.php',
                datatype: 'text',
                data: {
                    'valor': 'registrar',
                    'login': log,
                    'password': pass,
                    'password2': pass2,
                    'email': email
                },
                success: function(response) {
                    let res = JSON.parse(response);
                    //  console.log(res);
                    if (res === 'true') {
                        $('.correcto').html('usuario creado correctamente');
                        $('#listadoAnuncios').removeAttr('hidden');
                        $('#registrarForm').attr('hidden', true);
                        $('#insForm')[0].reset();

                    } else {
                        $('.errores').html(res);
                    }
                },
                error: function(result) {
                    console.log("resultado " + result);
                }
            });


        } else {
            $('.errores').html(cadena);
        }
    });

    $('.cerrarReg').on('click', function(e) {
        e.preventDefault();
        $('#regForm')[0].reset();
        $('.errores').html('');
        $('#listadoAnuncios').removeAttr('hidden');
        $('#registrarForm').attr('hidden', true);
    });
});

$('#insertar').on('click', function() {
    limpiar();
    $('#insertarForm').removeAttr('hidden');
    $('legend').text('Insertar anuncio:');
    $('#btnModificar').attr('hidden', true); //lo oculta
    $('#btnInsertar').removeAttr('hidden'); //lo muestra
    $('.cerrarIns').removeAttr('hidden'); //lo muestra

    $('#btnInsertar').on('click', function(e) {
        e.preventDefault();
        let moroso = $('#moroso').val();
        let localidad = $('#localidad').val();
        let descripcion = $('#descripcion').val();


        if (validarAnuncio(moroso, localidad, descripcion)) {

            $.post(
                'funciones.php', {
                    'valor': 'insertar',
                    'moroso': moroso,
                    'localidad': localidad,
                    'descripcion': descripcion
                },
                function(respuesta) {
                    res = JSON.parse(respuesta);
                    if (res === 'true') {
                        $('.correcto').html('Registro insertado.');
                        limpiar();
                        mostrarAnuncios();
                        $('#listadoAnuncios').removeAttr('hidden');
                        $("#insForm")[0].reset();
                    } else {
                        $('.errores').html(res);
                    }
                });
        } else {
            $('.errores').html(cadena);
        }
    })


    $('.cerrarIns').on('click', function(e) {
        e.preventDefault();
        $("#insForm")[0].reset();
        $('.errores').html("");
        limpiar();
        $('#listadoAnuncios').removeAttr('hidden'); //lo muestra el listado
    });

});



$('#escaparate').on('click', function() {
    limpiar();
    //muestra el lista y quite el hidden
    $('#listadoAnuncios').removeAttr('hidden');
    mostrarAnuncios();
});

$('#salir').on('click', function() {

    $.ajax({
        type: 'post',
        url: 'funciones.php',
        data: { 'valor': 'salir' },
        datatype: 'text',
        success: function(respuesta) {
            console.log(respuesta);
        },
        error: function(respuesta) {
            alert("Resultado : " + respuesta);
        }
    });

    location.reload();
});
/**fin del nav */




$(document).on('click', '#modificar', function() {
    limpiar();
    $('#insertarForm').removeAttr('hidden');
    //Guardamos en la variable el elemento tr para obtener el id_anuncio
    let element = $(this)[0].parentElement.parentElement;
    //<tr id_anuncio="117" localidad="Av Carlos Haya, 29010 Málaga, Málaga, Spain" id_a="usu2">
    console.log(element);
    let id_anuncio = $(element).attr('id_anuncio');
    // console.log(id_anuncio);
    //Cambiamos el texto al formulario
    $('legend').text('Modificar anuncio: ');
    $('#btnInsertar').attr('hidden', true); //Quitamos el botón insertar
    $('#btnModificar').removeAttr('hidden');
    //Nos conectamos con el servidor para recuperar los datos del anuncio a modificar

    $.ajax({
        type: 'post',
        url: 'funciones.php',
        datatype: 'text',
        data: {
            'valor': 'datosModificar',
            'id_anuncio': id_anuncio
        },
        success: function(response) {
            let anuncio = JSON.parse(response);
            console.log(anuncio)
            $('#moroso').val(anuncio[0].moroso);
            $('#localidad').val(anuncio[0].localidad);
            $('#descripcion').val(anuncio[0].descripcion);
            //Si le da al botón modificar enviamos los datos al servidor para cambiarlos

            $(document).on('click', '#btnModificar', function(e) {
                //Quitamos el evento por defecto para que no se cargue la página
                e.preventDefault();
                //console.log(anuncio[0].autor);
                let moroso = $('#moroso').val();
                let localidad = $('#localidad').val();
                let descripcion = $('#descripcion').val();
                if (validarAnuncio(moroso, localidad, descripcion)) {
                    // console.log("todo ok");
                    $.ajax({
                        type: 'post',
                        url: 'funciones.php',
                        datatype: 'text',
                        data: {
                            'valor': 'modificar',
                            'id_anuncio': id_anuncio,
                            'moroso': moroso,
                            'localidad': localidad,
                            'descripcion': descripcion
                        },
                        success: function(response) {
                            let res = JSON.parse(response);
                            if (res === 'true') {
                                limpiar();
                                $('.correcto').html('Registro modificado correctamente.');
                                mostrarAnuncios();
                                //muestra el listado con la modificación
                                $('#listadoAnuncios').removeAttr('hidden');
                            }
                        },
                        error: function(response) {
                            console.log("respuesta" + response);
                        }
                    });

                } else {
                    $('.errores').html(cadena);
                }
            });
        },
        error: function(response) {
            alert("Resultado: " + response);
        }
    });
});




$(document).on('click', '#eliminar', function() {
    let element = $(this)[0].parentElement.parentElement;
    console.log(element);
    //<tr id_anuncio="117" localidad="Av Carlos Haya, 29010 Málaga, Málaga, Spain" id_a="usu2">
    let id_anuncio = $(element).attr('id_anuncio');
    //recuperamos el 117
    console.log(id_anuncio);

    $.ajax({
        type: 'post',
        url: 'funciones.php',
        datatype: 'text',
        data: {
            'valor': 'eliminar',
            'id_anuncio': id_anuncio
        },
        success: function(response) {
            res = JSON.parse(response);
            console.log(res);
            $('.correcto').html(res);
            mostrarAnuncios();

        },
        error: function(result) {
            alert("Resultado : " + result);
        }
    });
});


$(document).on('click', '#mapa', function() {
    limpiar();
    console.log(mapa);
    //muestra los botones de origen y destino
    $('#contenedorMapa').removeAttr('hidden');
    let element = $(this)[0].parentElement.parentElement;
    console.log(element);
    //<tr id_anuncio="117" localidad="Av Carlos Haya, 29010 Málaga, Málaga, Spain" id_a="usu2">
    let localidad = $(element).attr('localidad');
    console.log(localidad);
    //Av Carlos Haya, 29010 Málaga, Málaga, Spain
    localidadDestino(localidad);

    $('#btnCalcularRuta').on('click', function(event) {
        GetDirections();
    });

    $('#cerrarMapa').on('click', function(event) {
        event.preventDefault();
        limpiar();
        $('#listadoAnuncios').removeAttr('hidden');
    });

});



/*
 * Función que contacta con el servidor para que le devuelva el listado de 
 * anuncios  de la base de datos
 * @returns {undefined}
 */

function mostrarAnuncios() {
    $.ajax({
        type: 'post',
        url: 'funciones.php',
        data: { 'valor': 'mostrar' },
        datatype: 'text',
        success: function(respuesta) {
            let plantilla = "";
            let anuncios = JSON.parse(respuesta);
            if (anuncios === false) {
                $('#anuncios').html('<h2>Nuestra base de datos no tiene anuncios disponibles en estos momentos.</h2>');
            } else {
                //Le ponemos al tr el id_anuncio como clase para poder eliminarlo luego
                anuncios.forEach(anuncio => {
                    //recuperamos los valores con $(this)[0]
                    plantilla += `<tr id_anuncio="${anuncio.id_anuncio}" localidad="${anuncio.localidad}" id_a="${anuncio.autor}">
                    <td>${anuncio.autor}</td>
                    <td>${anuncio.moroso}</td>
                    <td>${anuncio.localidad}<img src="img/marca.png" alt="mapa" id="mapa"></td>
                    <td>${anuncio.descripcion}</td>
                    <td>${anuncio.fecha}</td>

                    <td><img src="img/eliminar.png" alt="eliminar" id="eliminar" class="imgBotones"></td>
                    <td><img src="img/modificar.png" alt="modificar" id="modificar" class="imgBotones"></td>
                </tr>`;
                });
                $('#anuncios').html(plantilla);
            }
        },
        error: function(respuesta) {
            alert("Resultado : " + respuesta);
        }
    });
}

/*
 * Función limpiar para quitar todos los div de la página principal y poder enseñar
 * el que necesite según lo que elija el usuario.
 * También limpia los formularios para que no guarden datos.
 * @returns {undefined}
 */

function limpiar() {
    $('#registrarForm').attr('hidden', true);
    $('#listadoAnuncios').attr('hidden', true);
    $('#iniciarForm').attr('hidden', true);
    $('#insertarForm').attr('hidden', true);
    $('#contenedorMapa').attr('hidden', true);
    $('.errores').html('');
    $('.correcto').html('');
    $("#insForm")[0].reset();
    $("#iniForm")[0].reset();
    $("#regForm")[0].reset();

}