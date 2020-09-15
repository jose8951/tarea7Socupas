<?php

require_once 'inc/DB.php';


$dbConexion = new DB();
$conexion = $dbConexion->conectar();

//Iniciamos session
session_start();


if (!isset($_SESSION['nombre'])) {
    $_SESSION['nombre'] = 'Invitado';
}


$valor = $_POST['valor'];


switch ($valor) {

    case 'mostrar':
        try {
            $sql = "SELECT * FROM anuncios ORDER BY fecha";
            $resultado = $conexion->prepare($sql);
            $resultado->execute();
            $total = $resultado->rowCount();
            $json;
            if ($total) {
                while ($registro = $resultado->fetch()) {
                    $id_anuncio = $registro['id_anuncio'];
                    $autor = $registro['autor'];
                    $moroso = $registro['moroso'];
                    $localidad = $registro['localidad'];
                    $descripcion = $registro['descripcion'];
                    $fecha = $registro['fecha'];

                    $json[] = array(
                        'id_anuncio' => $id_anuncio,
                        'autor' => $autor,
                        'moroso' => $moroso,
                        'localidad' => $localidad,
                        'descripcion' => $descripcion,
                        'fecha' => $fecha,
                        'sesion' => $_SESSION['nombre']
                    );
                }
                echo json_encode($json);
            } else {
                echo json_encode(false);
            }
        } catch (Exception $ex) {
            echo "ERROR: " . $ex->getCode() . ", " . $ex->getMessage();
        }
        break;

    case 'iniciarSesion':
        $login = filter_input(INPUT_POST, 'login');
        $password = filter_input(INPUT_POST, 'password');
        if (!empty($login) && !empty($password)) {
            try {
                $sql = "SELECT * FROM anunciantes WHERE login=:log";
                $resultado = $conexion->prepare($sql);
                //$resultado->bindValue(':log', $login);
                $resultado->bindParam(":log", $login);
                $resultado->execute();
                $total = $resultado->rowCount();
                if ($total) {
                    foreach ($resultado as $registro) {
                        //Devuelve true si son iguales //2
                        if (password_verify($password, $registro['password'])) {
                            //si entramos aqui pasamos el login a la session
                            $_SESSION['nombre'] = $login;
                            $bloquear = $registro['bloqueado'];
                            if ($bloquear == 0) {
                                echo json_encode('true');
                            } else {
                                echo json_encode('Usuario bloqueado');
                            }
                        } else {
                            echo json_encode('password incorrecto');
                        }
                    }
                } else {
                    echo json_encode('El usuario introducido no existe');
                }
            } catch (Exception $e) {
                echo "Se produjo un error. Código: " . $e->getCode() . ", " . $e->getMessage(); //Guardamos en la variable el error producido.
            }
        } else {
            echo json_encode('Datos en el formulario incompletos.');
        }
        break;

    case 'registrar':
        $login = filter_input(INPUT_POST, recogerdato('login'));
        $pass = filter_input(INPUT_POST, recogerdato('password'));
        $pass2 = filter_input(INPUT_POST, recogerdato('password2'));
        $email = filter_input(INPUT_POST, recogerdato('email'));

        if (!empty($login) && strlen($login) > 1 && strlen($login) < 20 && strlen($pass) > 1 && strlen($pass) < 20 && !empty($pass) && preg_match("/^[a-z0-9]+([_\\.-][a-z0-9]+)*@([a-z0-9]+([\.-][a-z0-9]+)*)+\\.[a-z]{2,}$/i", $email)) {
            if ($pass === $pass2) {
                try {
                    $sql = "INSERT INTO anunciantes (login, password, email, bloqueado) VALUES (:log, :pass, :email, :bloqueado)";
                    $resultado = $conexion->prepare($sql);

                    $resultado->bindValue(":log", $login);
                    $passHush = password_hash($_POST['password'], PASSWORD_DEFAULT);
                    $resultado->bindValue(":pass", $passHush);
                    $resultado->bindValue(":email", $email);
                    $resultado->bindValue(":bloqueado", 0);

                    if ($resultado->execute()) {
                        echo json_encode('true');
                    } else {
                        echo json_encode("el usuario ya existe");
                    }
                } catch (Exception $ex) {
                    echo "Error. Código: " . $ex->getCode() . ", " . $ex->getMessage();
                }
            } else {
                echo json_encode('la contraseña no coincide');
            }
        } else {
            echo json_encode('Datos en el formulario incopletos');
        }
        break;


    case 'insertar':

        //recuperamos la session y la guardamos en le $autor
        $autor = $_SESSION['nombre'];
        $moroso = filter_input(INPUT_POST, recogerdato('moroso'));
        $localidad = filter_input(INPUT_POST, recogerdato('localidad'));
        $descripcion = filter_input(INPUT_POST, recogerdato('descripcion'));
        $fecha = date('Y-m-d');

        if (
            !empty($moroso) && strlen($moroso) >= 1 && strlen($moroso) < 20 &&
            !empty($localidad) && strlen($localidad) >= 1 && strlen($localidad) < 20 &&
            !empty($descripcion) && strlen($descripcion) >= 1 && strlen($descripcion) < 500
        ) {
            try {
                $sql = "INSERT INTO anuncios (autor,moroso,localidad,descripcion,fecha) VALUES (:autor, :moroso, :localidad, :descripcion, :fecha)";
                $resultado = $conexion->prepare($sql);
                $resultado->bindValue(':autor', $autor);
                $resultado->bindValue(':moroso', $moroso);
                $resultado->bindValue(':localidad', $localidad);
                $resultado->bindValue(':descripcion', $descripcion);
                $resultado->bindValue(':fecha', $fecha);

                if ($resultado->execute()) {
                    echo json_encode('true');
                } else {
                    echo json_encode('Error al introducir el anuncio');
                }
            } catch (Exception $ex) {
                echo "Error. Código: " . $ex->getCode() . ", " . $ex->getMessage();
            }
        } else {
            echo json_encode("los datos del anuncio están incompletos o la longitudes incorrectas");
        }
        break;

    case 'eliminar':
        $id_anuncio = filter_input(INPUT_POST, recogerdato('id_anuncio'));
        $usuario = $_SESSION['nombre'];
        try {
            $sql = "SELECT id_anuncio, autor  FROM anuncios WHERE id_anuncio=:id_anuncio";
            $resultado = $conexion->prepare($sql);
            $resultado->bindValue('id_anuncio', $id_anuncio);
            $resultado->execute();
            $json;
            while ($registro = $resultado->fetch()) {
                $autor = $registro['autor'];
            }
            //echo json_encode($usuario);

            if ($autor == $usuario && $autor != 'Invitado') {
                try {
                    $sql = "DELETE FROM anuncios WHERE id_anuncio= :id_anuncio";
                    $resultado = $conexion->prepare($sql);
                    $resultado->bindValue('id_anuncio', $id_anuncio);
                    $resultado->execute();
                    echo json_encode('registro eliminado');
                } catch (Exception $ex) {
                    echo "ERROR: " . $ex->getCode() . ", " . $ex->getMessage();
                }
            } else {
                echo json_encode('no puede eliminar el anuncio de otro usuario el invitado tampoco');
            }
        } catch (Exception $ex) {
            echo "ERROR: " . $ex->getCode() . ", " . $ex->getMessage();
        }
        break;

    case 'datosModificar':
        $id_anuncio = filter_input(INPUT_POST, recogerdato('id_anuncio'));
        $usuario = $_SESSION['nombre'];

        try {
            $sql = "SELECT id_anuncio, autor, moroso, localidad, descripcion FROM anuncios WHERE id_anuncio=:id_anuncio";
            $resultado = $conexion->prepare($sql);
            $resultado->bindValue('id_anuncio', $id_anuncio);
            $resultado->execute();

            while ($registro = $resultado->fetch()) {
                $autor = $registro['autor'];
                $moroso = $registro['moroso'];
                $localidad = $registro['localidad'];
                $descripcion = $registro['descripcion'];


                $json[] = array(
                    'autor' => $autor,
                    'moroso' => $moroso,
                    'localidad' => $localidad,
                    'descripcion' => $descripcion
                );
            }

            echo json_encode($json);
        } catch (Exception $ex) {
            echo "ERROR: " . $ex->getCode() . ", " . $ex->getMessage();
        }
        break;

    case 'modificar':
        $id_anuncio = filter_input(INPUT_POST, recogerdato('id_anuncio'));
        $moroso = filter_input(INPUT_POST, recogerdato('moroso'));
        $localidad = filter_input(INPUT_POST, recogerdato('localidad'));
        $descripcion = filter_input(INPUT_POST, recogerdato('descripcion'));
        $usuario = $_SESSION['nombre'];
        $autor = '';


        if (!empty($moroso) && strlen($moroso) >= 1 && strlen($moroso) < 20 && !empty($localidad) && strlen($localidad) >= 1 && strlen($localidad) < 60 && !empty($descripcion) && strlen($descripcion) >= 1 && strlen($descripcion) < 500) {

            try {
                $sql = "SELECT autor FROM anuncios WHERE id_anuncio =:id_anuncio";
                $resultado = $conexion->prepare($sql);
                $resultado->bindValue('id_anuncio', $id_anuncio);
                $resultado->execute();

                while ($registro = $resultado->fetch()) {
                    $autor = $registro['autor'];
                }
                //echo json_encode($autor);
                //$usuario mostramos la session 
                if ($autor === $usuario && $autor !== 'Invitado') {

                    try {
                        $sql = "UPDATE anuncios SET moroso=:moroso, localidad=:localidad, descripcion=:descripcion WHERE id_anuncio=:id_anuncio";

                        $resultado = $conexion->prepare($sql);
                        $resultado->bindValue('moroso', $moroso);
                        $resultado->bindValue('localidad', $localidad);
                        $resultado->bindValue('descripcion', $descripcion);
                        $resultado->bindValue('id_anuncio', $id_anuncio);
                        $resultado->execute();
                        if ($resultado) {
                            echo json_encode('true');
                        } else {
                            echo json_encode('ERROR, no se pudo actualizar el anuncio');
                        }
                    } catch (Exception $ex) {
                        echo "ERROR: " . $ex->getCode() . ", " . $ex->getMessage();
                    }
                } else {
                    echo json_encode('No puede modificar el anuncio de otro usuario.');
                }
            } catch (Exception $ex) {
                echo "ERROR: " . $ex->getCode() . ", " . $ex->getMessage();
            }
        } else {
            echo json_encode('Los datos del anuncio están incompletos o las longuitudes incorrectas.');
        }
        break;


    case 'salir':
        session_destroy();
        echo json_encode('true');
        break;
}


function recogerdato($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
