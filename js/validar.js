var cadena = "";

function validarRegistro(log, pass, pass2, email) {
    cadena = '';
    if (validarLog(log) && validarPass(pass) && validarPass2(pass, pass2) && validarEmail(email)) {
        return true;
    } else {
        return false;
    }
}

function validarLogin(login, password) {
    cadena = "";
    if (validarLog(login) && validarPass(password)) {
        return true;
    } else {
        return false;
    }
}

function validarLog(log) {
    let pLog = /^[0-9a-zA-Z\.]{1,20}$/;
    val = false;
    if (pLog.test(log)) {
        val = true;
    } else {
        cadena += "<br>login incorrecto: </br> Debe tener entre 2 y 20 digitos,<br>";
    }
    return val;
}

function validarPass(pass) {
    val = false;
    if (pass.match(/^\w{1,20}$/)) {
        val = true;
    } else {
        cadena += "<br>password incorrecto:<br> Debe tener caracteres entre 2 y 20 alfanuméricos.<br/>";
    }
    return val;
}

function validarPass2(pass, pass2) {
    if (pass === pass2) {
        return true;
    } else {
        cadena += "<br>la segunda password no coincide con la primera<br/>";
        return false;
    }
}

function validarEmail(email) {
    let pEmail = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
    let val = false;
    if (pEmail.test(email)) {
        val = true;
    } else {
        cadena += "<br>Email incorrecto</br>";
    }
    return val;
}


function validarAnuncio(moroso, localidad, descripcion) {
    cadena = '';
    if (validarMoroso(moroso) && validarLocalidad(localidad) && validarDescripcion(descripcion)) {
        return true;
    } else {
        return false;
    }
}

function validarMoroso(moroso) {
    let val = false;
    if (moroso.length >= 1 && moroso.length < 60) {
        val = true;
    } else {
        cadena += "<br>la longitud del campo moroso es de 1 a 60</br>";
    }
    return val;
}

function validarLocalidad(localidad) {
    let val = false;
    if (localidad.length >= 1 && localidad.length < 60) {
        val = true;
    } else {
        cadena += '<br>La longitud del campo localidad es de 1 a 60</br>';
    }
    return val;
}

function validarDescripcion(descripcion) {
    let val = false;
    if (descripcion.length >= 1 && descripcion.length < 500) {
        val = true;
    } else {
        cadena += '<br>la longitud del campo descripcion es de 1 a 500</br>';
    }
    return val;
}