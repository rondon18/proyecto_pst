<?php

require('clases/personas.php');
require('clases/telefonos.php');
require('clases/representantes.php');
require('clases/contactos-auxiliares.php');
require('clases/usuario.php');
require('clases/laborales-representantes.php');
require('clases/economicos-representantes.php');
require('clases/vivienda-representantes.php');
require('controladores/conexion.php');

$persona = new Personas();
$persona_auxiliar = new Personas();

$telefonoP = new Telefonos();
$telefonoS = new Telefonos();
$telefonoA = new Telefonos();
$telefonoT = new Telefonos();

$representante = new Representantes();
$contacto_aux = new ContactoAuxiliar();
$datos_laborales = new DatosLaborales();
$datos_economicos = new DatosEconomicos();
$datos_vivienda = new DatosVivienda();

$usuario = new Usuarios();


#Persona
$persona->setPrimer_Nombre('María');
$persona->setSegundo_Nombre('Gabriela');
$persona->setPrimer_Apellido('Ballestero');
$persona->setSegundo_Apellido('Rodríguez');
$persona->setCédula('28636530');
$persona->setFecha_Nacimiento('2002-05-09');
$persona->setLugar_Nacimiento('Caja Seca');
$persona->setGénero('M');
$persona->setCorreo_Electrónico('mgbrodriguez952@gmail.com');
$persona->setDirección('Caja Seca');
$persona->setEstado_Civil('S');

$persona->insertarPersona();

#Telefono principal
$telefonoP->setPrefijo('0426');
$telefonoP->setNúmero_Telefónico('8994472');
$telefonoP->setRelación_Teléfono('Principal');
$telefonoP->setCedula_Persona('28636530');



$telefonoP->insertarTelefono($telefonoP->getCedula_Persona());

#Telefono secundario
$telefonoS->setPrefijo('0412');
$telefonoS->setNúmero_Telefónico('0763135');
$telefonoS->setRelación_Teléfono('Secundario');
$telefonoS->setCedula_Persona('28636530');

$telefonoS->insertarTelefono($telefonoS->getCedula_Persona());

#Telefono auxiliar
$telefonoA->setPrefijo('0274');
$telefonoA->setNúmero_Telefónico('12349587');
$telefonoA->setRelación_Teléfono('Auxiliar');
$telefonoA->setCedula_Persona('28636530');

$telefonoA->insertarTelefono($telefonoA->getCedula_Persona());

#Telefono del trabajo
$telefonoT->setPrefijo('0274');
$telefonoT->setNúmero_Telefónico('12349587');
$telefonoT->setRelación_Teléfono('Trabajo');
$telefonoT->setCedula_Persona('28636530');

$telefonoT->insertarTelefono($telefonoA->getCedula_Persona());

#Representante
$representante->setVinculo("Madre");
$representante->setCedula_Persona("28636530");

$representante->insertarRepresentante();

#Datos laborales
$datos_laborales->setEmpleo('Directivo');
$datos_laborales->setLugar_Trabajo('Liceo....');
$datos_laborales->setRemuneración('');
$datos_laborales->setTipo_Remuneración('');

$datos_laborales->setidRepresentantes($representante->getidRepresentantes());

$datos_laborales->insertarDatosLaborales();

#Datos economicos
$datos_economicos->setBanco('Provincial');
$datos_economicos->setTipo_Cuenta('Corriente');
$datos_economicos->setCta_Bancaria('1351351351384135');
$datos_economicos->setidRepresentantes($representante->getidRepresentantes());
$datos_economicos->insertarDatosEconomicos();

#Datos vivienda
$datos_vivienda->setCondiciones_Vivienda('Buena');
$datos_vivienda->setTipo_Vivienda('Casa');
$datos_vivienda->setTenencia_Vivienda('Propia');
$datos_vivienda->setidRepresentante('3');

$datos_vivienda->insertarDatosVivienda();

#Contacto Auxiliar
#Persona
$persona_auxiliar->setPrimer_Nombre('Elber');
$persona_auxiliar->setSegundo_Nombre('Alonso');
$persona_auxiliar->setPrimer_Apellido('Rondón');
$persona_auxiliar->setSegundo_Apellido('Hernández');
$persona_auxiliar->setCédula('27919567');
$persona_auxiliar->setFecha_Nacimiento('2001-05-05');
$persona_auxiliar->setLugar_Nacimiento('Mérida');
$persona_auxiliar->setGénero('M');
$persona_auxiliar->setCorreo_Electrónico('earh_2001@outlook.com');
$persona_auxiliar->setDirección('La Pedregosa Alta');
$persona_auxiliar->setEstado_Civil('S');

$persona_auxiliar->insertarPersona();

#Telefono principal
$telefonoP->setPrefijo('0416');
$telefonoP->setNúmero_Telefónico('12345678');
$telefonoP->setRelación_Teléfono('Principal');
$telefonoP->setCedula_Persona('27919567');

$telefonoP->insertarTelefono($telefonoP->getCedula_Persona());

#Telefono secundario
$telefonoS->setPrefijo('0412');
$telefonoS->setNúmero_Telefónico('87654321');
$telefonoS->setRelación_Teléfono('Secundario');
$telefonoS->setCedula_Persona('27919567');

$telefonoS->insertarTelefono($telefonoS->getCedula_Persona());

#Telefono auxiliar
$telefonoA->setPrefijo('0274');
$telefonoA->setNúmero_Telefónico('12349587');
$telefonoA->setRelación_Teléfono('Auxiliar');
$telefonoA->setCedula_Persona('27919567');

$telefonoA->insertarTelefono($telefonoA->getCedula_Persona());


#datos auxiliar
$contacto_aux->setRelación('Vecino');
$contacto_aux->setCédula_Persona($persona_auxiliar->getCédula());

$contacto_aux->insertarContactoAuxiliar($representante->getidRepresentantes());

#Usuario
$usuario->setClave("12345");
$usuario->setPrivilegios("1");
$usuario->setCedula_Persona("28636530");

$usuario->insertarUsuario();

//INSERCIONES




	#Se crea
	$_SESSION['registro'] = [];


	#cuando entra al lobby
	$_SESSION['registro'][] = "visita menú principal";

	#cuando entra al lobby
	$_SESSION['registro'][] = "visita su perfil";

	#cuando entra al lobby
	$_SESSION['registro'][] = "edita su perfil";

	#.............

	#Cierra sesión
	$_SESSION['registro'][] = "Cierra sesión";

	$registro_usuario = "Usuario: Elber. Acciones realizadas: ";
	foreach ($_SESSION['registro'] as $registro) {
		if ($registro == "Cierra sesión") {
			$registro_usuario .= $registro.".";
		}
		else {
			$registro_usuario .= $registro.", ";
		}

	}
	echo $registro_usuario;





?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Test</title>
</head>
<body>
	<table border="1" cellpadding="8">
		<tr>
			<td colspan="14">Personas</td>
		</tr>
		<tr>
			<td>Dato 1</td>
			<td>Dato 2</td>
			<td>Dato 3</td>
			<td>Dato 4</td>
			<td>Dato 5</td>
			<td>Dato 6</td>
			<td>Dato 7</td>
			<td>Dato 8</td>
			<td>Dato 9</td>
			<td>Dato 10</td>
			<td>Dato 11</td>
			<td>Dato 12</td>
			<td>Dato 13</td>
			<td>Dato 14</td>
		</tr>
		<tr>
			<td><?php echo $persona->getPrimer_Nombre(); ?></td>
			<td><?php echo $persona->getSegundo_Nombre(); ?></td>
			<td><?php echo $persona->getPrimer_Apellido(); ?></td>
			<td><?php echo $persona->getSegundo_Apellido(); ?></td>
			<td><?php echo $persona->getCédula(); ?></td>
			<td><?php echo $persona->getFecha_Nacimiento(); ?></td>
			<td><?php echo $persona->getLugar_Nacimiento(); ?></td>
			<td><?php echo $persona->getGénero(); ?></td>
			<td><?php echo $persona->getCorreo_Electrónico(); ?></td>
			<td><?php echo $persona->getDirección(); ?></td>
			<td><?php echo $persona->getEstado_Civil(); ?></td>
			<td><?php echo $telefonoP->getPrefijo()."-".$telefonoP->getNúmero_Telefónico();?></td>
			<td><?php echo $telefonoS->getPrefijo()."-".$telefonoS->getNúmero_Telefónico();?></td>
			<td><?php echo $telefonoA->getPrefijo()."-".$telefonoA->getNúmero_Telefónico();?></td>
		</tr>
	</table>
 <form>
 	<label class="form-label">Número de cuenta:</label>
 	<input type="text" class="form-control mb-2" name="Nro_Cuenta" pattern="[0-9]{20}" title="Una cuenta bancaria consta de 20 digitos" placeholder="XXXX-XXXXXXXXXXXXXX" required>
	<input type="submit" name="" value="">
</form>



 <input type="text" name="" list="prefijos">
 <input type="text" name="" list="prefijos">
 <input type="text" name="" list="prefijos">
 <datalist id="prefijos">
 	<option value="1">
 	<option value="2">
 	<option value="3">
 	<option value="4">
 	<option value="5">
 	<option value="6">
 	<option value="7">
 	<option value="8">
 	<option value="9">
 	<option value="10">
 	<option value="11">
 	<option value="12">
 </datalist>

</body>
</html>