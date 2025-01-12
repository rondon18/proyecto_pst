<?php
include("../editar_registro/funciones.php");

session_start();
if (!$_SESSION['login']) {
	header('Location: ../index.php');
	exit();
}

else {
	// El formulario redirecciona a sí mismo, luego al paso 2 una vez se asignan las variables de sesión
	// Verificación al momento de enviar el formulario
	if (isset($_POST['paso_3'])) {
		// Check de que el paso fue completado
		$_SESSION['orden'] = "editar";
		$_SESSION['paso_3'] = $_POST['paso_3'];
		

		// Se almacenan los datos del formulario en un arreglo
		$datos_estudiante = [];
		foreach ($_POST as $indice => $valor) {
			$datos_estudiante[$indice]= $valor;
		}

		// Se anexan como arreglo de arreglos en una variable de sesión
		$_SESSION['datos_inscripcion']['datos_estudiante'] = $datos_estudiante;

		// Redirecciona al paso 2
		header('Location: ../../controladores/registros/control_registros.php');
	}
}

function estado_vacuna($n_vacuna) {

	switch ($n_vacuna) {
		
		case 'vph':
			$i = 0;
			break;
		
		case 'tdap':
			$i = 1;
			break;
		
		case 'menacwy':
			$i = 2;
			break;
		
		case 'hep_a':
			$i = 3;
			break;
		
		case 'hep_b':
			$i = 4;
			break;
		
		case 'ipv':
			$i = 5;
			break;
		
		case 'mmr':
			$i = 6;
			break;
		
		case 'varicela':
			$i = 7;
			break;
		
		case 'antiamarilica':
			$i = 8;
			break;
		
		case 'antigripal':
			$i = 9;
			break;
		
		default:
			// code...
			break;
	}

	if ($_SESSION['vacunas_estudiante'][$i]['estado_vacuna'] == "Aplicada") {
		echo "checked";
	}
}

?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Editar estudiante</title>
		<link rel="stylesheet" type="text/css" href="../../css/bootstrap.min.css"/>
		<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
		<link rel="stylesheet" type="text/css" href="../../css/all.min.css"/>
		<link rel="icon" type="img/png" href="../../img/icono.png">
	</head>
	<body>
		<main class="d-flex flex-column justify-content-between vh-100">
			<?php include('../../header.php'); ?>
			<div class="container-md">	
				<div class="card">
					<!-- Titulo del contenedor -->
					<div class="card-header text-center">
						<b class="fs-5">FORMULARIO DE EDICIÓN - ESTUDIANTE</b>
					</div>
					<div class="card-body">
						<div class="row">
							
							<!-- Selector de sección -->
							<div class="col-12 col-lg-3">
								<ul class="nav flex-lg-column nav-pills nav-fill mb-4 gap-2">
									<li class="nav-item">
										<span id="link1" class="nav-link active">Datos personales</span>
									</li>
									<li class="nav-item">
										<span id="link2" class="nav-link">Datos de contacto</span>
									</li>
									<li class="nav-item">
										<span id="link3" class="nav-link">Datos sociales</span>
									</li>
									<li class="nav-item">
										<span id="link4" class="nav-link">Datos académicos</span>
									</li>
									<li class="nav-item">
										<span id="link5" class="nav-link">Datos de salud</span>
									</li>
									<li class="nav-item">
										<span id="link6" class="nav-link">Observaciones</span>
									</li>
								</ul>
							</div>
							
							<!-- Contenedor del formulario -->
							<div class="col-12 col-lg-9 py-0" style="max-height: 60vh; overflow-y: auto;">
								<form id="formulario_estudiantes" action="editar_estudiante.php" method="POST">
									
									<!-- Datos personales -->
									<section id="seccion1" class="row my-2">

										<div class="row mb-4">
											<div class="col-12">
												<span class="h5 mb-3">
													<i class="fas fa-address-card fa-xl me-2"></i>
													Datos personales.
												</span>
											</div>
										</div>

										<!-- Nombres -->
										<div class="row mb-4">
											<div class="col-12 col-lg-2">
												<label class="form-label requerido">Nombres:</label>
											</div>
											<!-- Primer nombre -->
											<div class="col-12 col-lg-5">
												<input 
													id="primer_nombre_est" 
													class="form-control" 
													type="text" 
													name="primer_nombre_est" 
													placeholder="Primer nombre" 
													required
													value="<?php echo dato_input("p_nombre","de");?>"
												>
											</div>
											<!-- Segundo nombre -->
											<div class="col-12 col-lg-5">
												<input 
													id="segundo_nombre_est" 
													class="form-control" 
													type="text" 
													name="segundo_nombre_est"
													placeholder="Segundo nombre" 
													value="<?php echo dato_input("s_nombre","de");?>"
												>
											</div>
										</div>


										<!-- Apellidos -->
										<div class="row mb-4">
											<div class="col-12 col-lg-2">
												<label class="form-label requerido">Apellidos:</label>
											</div>
											<!-- Primer apellido -->
											<div class="col-12 col-lg-5">
												<input 
													id="primer_apellido_est" 
													class="form-control" 
													type="text" 
													name="primer_apellido_est"
													placeholder="Primer apellido"
													required 
													value="<?php echo dato_input("p_apellido","de");?>"
												>
											</div>
											<!-- Segundo apellido -->
											<div class="col-12 col-lg-5">
												<input 
													class="form-control" 
													type="text" 
													name="segundo_apellido_est"
													id="segundo_apellido_est" 
													placeholder="Segundo apellido"
													value="<?php echo dato_input("s_apellido","de");?>"
												>
											</div>
										</div>
										

										<div class="row mb-4">
											<div class="col-12 col-lg-12">
												<span class="form-text">Solo son obligatorios primer nombre y primer apellido.</span>
											</div>
										</div>

										<!-- Cédula -->
										<div class="row mb-4">
											<div class="col-12 col-lg-2">
												<label class="form-label requerido">Cédula:</label>
											</div>
											
											<fieldset id="cedula_estudiante" class="row p-0 col-lg-10">
												
												<?php 
													$nac = trim(dato_input("cedula","de"),"0123456789");
													$nro_c = trim(dato_input("cedula","de"),"VE");
												?>

												<div class="col-12 col-lg-4">
														<!-- NacionalIdad -->
														<select 
															id="nacionalidad_r" 
															class="form-select" 
															name="nacionalidad_est" 
															required
														>
															<option selected value="">Nacionalidad</option>
															<option value="V" <?php if ($nac == "V") {echo "selected";}?>>V</option>
															<option value="E" <?php if ($nac == "E") {echo "selected";}?>>E</option>
														</select>
												</div>
												<div class="col-12 col-lg-8">
														<!-- Número de cédula -->
														<input 
															id="cedula_est"
															class="form-control" 
															type="text" 
															name="cedula_est" 
															maxlength="8" 
															minlength="7"
															placeholder="Número de cedula" 
															required
															value="<?php echo $nro_c;?>"
														>
												</div>

											</fieldset>

											<div class="col-12 col-lg-12 mt-2 mb-2">
												<span class="form-text">
													La cédula consta de una nacionalidad y de un número con alrededor de al menos 7 a 8 dígitos. En caso de no contar con
													una cédula propia sino escolar,
													<a id="boton_c_escolar" data-bs-toggle="modal" data-bs-target="#ayuda_c_escolar" href="#">Haga click aquí</a>
													para mostrar ayuda respecto a esta.
												</span>
											</div>
																					<div class="modal fade" id="ayuda_c_escolar" tabindex="-1" aria-labelledby="label_c_escolar" aria-hidden="true">
											<div class="modal-dialog modal-dialog-scrollable">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="label_c_escolar">
															<i class="fa-solid fa-xl me-2 fa-circle-question"></i>
															Acerca de la cédula escolar.
														</h5>
														<button
															type="button"
															class="btn-close"
															data-bs-dismiss="modal"
															aria-label="Close"
														></button>
													</div>
													<div class="modal-body">
														<span>
															La cédula escolar está formada por doce caracteres:
														</span>
														<ul>
															<li>
																El primero corresponde a la nacionalidad:
																<ul>
																	<li>
																		V si nació en Venezuela o si uno de los padres es venezolano,
																		aunque el niño haya nacido en el exterior.
																	</li>
																	<li>
																		E extranjero si es el caso.
																	</li>
																</ul>
															</li>
															<li>
																El segundo es un dígito que indica
																<ol>
																	<li>parto sencillo</li>
																	<li>morochos o gemelos: Nº 1 primer niño, Nº 2 segundo niño</li>
																	<li>trillizos...</li>
																</ol>
															</li>
															<li>
																El tercero y cuarto dígito corresponden a las dos últimas cifras del
																año de nacimiento del niño.
															</li>
															<li>
																Los ocho dígitos restantes, corresponden al número de cédula de la madre,
																en caso de no existir, usar la del padre.
															</li>
															<li>
																Si el número de la cédula tiene siete dígitos, debe anteponer un cero
																antes del primer dígito.
															</li>
														</ul>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Volver</button>
													</div>
												</div>
											</div>
										</div>
										</div>


										<!-- Genero -->
										<div class="row mb-4">
											<div class="col-12 col-lg-2">
												<label class="form-label requerido">Genero:</label>
											</div>
											<div class="col-12 col-lg-10">
												<!-- Femenino -->
												<div class="form-check form-check-inline">
													<input 
														id="genero_est_f" 
														class="form-check-input" 
														type="radio"
														name="genero_est" 
														value="F" 
														required
														<?php dato_option("F","genero","rc","de");?>
													>
													<label for="genero_est_f" class="form-label">Femenino</label>
												</div>
												<!-- Masculino -->
												<div class="form-check form-check-inline">
													<input 
														id="genero_est_m" 
														class="form-check-input" 
														type="radio"
														name="genero_est" 
														value="M" 
														required
														<?php dato_option("M","genero","rc","de");?>
													>
													<label for="genero_est_m" class="form-label">Masculino</label>
												</div>
												<label id="genero_est-error" class="error w-100" style="display:none;" for="genero_est"></label>
											</div>
										</div>


										<!-- Fecha y lugar de nacimiento -->
										<div class="row mb-4">
											<div class="col-12 col-lg-4">
												<label for="fecha_nacimiento_est" class="form-label requerido">Fecha de nacimiento:</label>
												<input 
													id="fecha_nacimiento_est" 
													class="form-control" 
													type="date" name="fecha_nacimiento_est"
													min="<?php echo date('Y')-19 .'-01-01'?>"
													max="<?php echo date('Y')-10 .'-01-01'?>" 
													required
													value="<?php echo dato_input("fecha_nacimiento","de");?>"
												>
											</div>
											<div class="col-12 col-lg-8">
												<label for="lugar_nacimiento_est" class="form-label requerido">Lugar de nacimiento:</label>
												<input 
													id="lugar_nacimiento_est" 
													class="form-control" 
													name="lugar_nacimiento_est"
													type="text" 
													placeholder="Estado, ciudad." 
													required
													value="<?php echo dato_input("lugar_nacimiento","de");?>"
												>
											</div>
										</div>
									</section>

									<!-- Datos de contacto -->
									<section id="seccion2" class="row my-2" style="display:none;">
										<div class="row mb-4">
											<div class="col-12">
												<span class="h5 mb-3">
													<i class="fas fa-school fa-xl me-2"></i>
													Datos de contacto.
												</span>
											</div>
										</div>


										<!-- Correo electrónico -->
										<div class="row mb-4">
											<div class="col-12 col-lg-3">
												<label for="correo_electronico_est" class="form-label">Correo electrónico:</label>
											</div>
											<div class="col-12 col-lg-9">
												<input 
													id="correo_electronico_est" 
													class="form-control" 
													type="email" 
													name="correo_electronico_est"
													placeholder="correo_ejemplo@dominio.com" 
													value="<?php echo dato_input("email","de");?>"
												>
											</div>
										</div>

										<!-- Teléfonos -->
										<div class="row mb-2">
											<div class="col-12 col-lg-12">
												<label class="form-label mb-3">Números de teléfono:</label>
											</div>
											<!-- Teléfono principal -->
											<div class="col-12 col-lg-2 mb-3">
												<label class="form-label">Principal:</label>
											</div>
											<!--Teléfono principal-->
											<div class="col-12 col-lg-3 mb-3">
												<!--Prefijo-->
												<input 
													id="prefijo_principal_est" 
													class="form-control form-control-sm" 
													type="text" 
													name="prefijo_principal_est"
													list="prefijos_estudiante" 
													minlength="4"
													maxlength="4" 
													placeholder="Prefijo"
													value="<?php echo $_SESSION['tlfs_estudiante'][0]["prefijo"] ?? NULL;?>"
												>
											</div>
											<div class="col-12 col-lg-7 mb-3">
												<!--Número-->
												<input 
													id="telefono_principal_est" 
													class="form-control form-control-sm" 
													type="tel" 
													name="telefono_principal_est"
													minlength="7" 
													maxlength="7"
													placeholder="Número telefonico" 
													value="<?php echo $_SESSION['tlfs_estudiante'][0]["numero"] ?? NULL;?>"
												>
											</div>
											<!-- Teléfono secundario -->
											<div class="col-12 col-lg-2 mb-3">
												<label class="form-label">Secundario:</label>
											</div>
											<div class="col-12 col-lg-3 mb-3">
												<!--Prefijo-->
												<input 
													id="prefijo_secundario_est" 
													class="form-control form-control-sm" 
													type="text" 
													name="prefijo_secundario_est"
													list="prefijos_estudiante" 
													minlength="4"
													maxlength="4" 
													placeholder="Prefijo"
													value="<?php echo $_SESSION['tlfs_estudiante'][1]["prefijo"] ?? NULL;?>"
												>
											</div>
											<div class="col-12 col-lg-7 mb-3">
												<!--Número-->
												<input 
													id="telefono_secundario_est" 
													class="form-control form-control-sm" 
													type="tel" 
													name="telefono_secundario_est"
													minlength="7" 
													maxlength="7"
													placeholder="Número telefonico"
													value="<?php echo $_SESSION['tlfs_estudiante'][1]["numero"] ?? NULL;?>"
												>
											</div>
										</div>


										<div class="row mb-4">
											<div class="col-12 col-lg-12 mt-2">
												<span class="form-text">No es obligatorio que el estudiante posea un correo electrónico y/o número propio de teléfono, sin embargo este resulta de utilidad.</span>
											</div>
										</div>
									</section>

									<!-- Datos sociales -->
									<section id="seccion3" class="row my-2" style="display:none;">
										
										<!--Datos sociales-->
										<div class="row mb-4">
											<div class="col-12">
												<span class="h5 mb-3">
													<i class="fa-solid fa-users fa-xl me-2"></i>
													Datos sociales.
												</span>
											</div>
										</div>
										
										
										<?php

											$direccion_estudiante = direccion_completa($_SESSION["datos_estudiante"]);

											/*
												Verifica si la direccion donde vive el estudiante es igual a la marcada por el representante, o
												si se especifico que vive con padre o madre.
												Para poder hacer funcionar el checkbox
											*/

											switch ($direccion_estudiante) {

												case direccion_completa($_SESSION["datos_representante"]):
													$check_direccion_estudiante = "representante";
													break;

												case direccion_completa($_SESSION["datos_padre"]):
													$check_direccion_estudiante = "padre";
													break;

												case direccion_completa($_SESSION["datos_madre"]):
													$check_direccion_estudiante = "madre";
													break;

												default:
													$check_direccion_estudiante = "otro";
													break;
											}

										?>

										<!-- Domicilio -->
										<div class="row mb-4">
											<div class="col-12 col-lg-3">
												<label class="form-label requerido">¿Con quién vive?:</label>
											</div>
											<div class="col-12 col-lg-9">
												<div class="form-check form-check-inline">
													<input
														id="domicilio_representante" 
														class="form-check-input" 
														type="radio" 
														name="domicilio" 
														value="representante"
														<?php if ($check_direccion_estudiante == "representante") { echo "checked";} ?>
														required
													>
													<label for="domicilio_representante" class="form-label">Representante </label>
												</div>

												<div class="form-check form-check-inline">
													<input
														id="domicilio_padre" 
														class="form-check-input" 
														type="radio" 
														name="domicilio" 
														value="padre"
														<?php if ($check_direccion_estudiante == "padre") { echo "checked";} ?>
														required
													>
													<label for="domicilio_padre" class="form-label">Padre </label>
												</div>

												<div class="form-check form-check-inline">
													<input
														id="domicilio_madre" 
														class="form-check-input" 
														type="radio" 
														name="domicilio" 
														value="madre"
														<?php if ($check_direccion_estudiante == "madre") { echo "checked";} ?>
														required
													>
													<label for="domicilio_madre" class="form-label">Madre </label>
												</div>

												<div class="form-check form-check-inline">
													<input
														id="domicilio_otro" 
														class="form-check-input" 
														type="radio" 
														name="domicilio" 
														value="otro"
														<?php if ($check_direccion_estudiante == "otro") { echo "checked";} ?>
														required
													>
													<label for="domicilio_otro" class="form-label">Otro </label>
												</div>
												<label id="domicilio-error" class="error w-100" style="display:none;" for="domicilio"></label>
											</div>
											<span class="form-text">En caso de seleccionar representante, madre o padre, se asumirá la que la dirección que vive el estudiante es esta, en dado caso de ser otra, seleccione otro y especifique.</span>
										</div>
										<div class="row mb-4">
											<div class="col-12 col-lg-4">
												<label for="direccion_est" class="form-label requerido">Lugar de domicilio:</label>
											</div>
		
											<div class="col-12 col-lg-8">
												<input 
													id="direccion_est"
													class="form-control" 
													name="direccion_est" 
													required
													value="<?php echo $direccion_estudiante; ?>"
													<?php if ($check_direccion_estudiante != "otro") { echo "disabled";} ?>
													disabled 
												>
											</div>
										</div>


										<!-- Con quien vive -->
										<div class="row mb-4">
											<div class="col-12 col-lg-6">
												<label for="con_quien_vive" class="form-label requerido">¿Con quienes hace vida en su hogar?:</label>
											</div>
											<div class="col-12 col-lg-6">
												<input 
													id="con_quien_vive"
													class="form-control" 
													type="text" 
													name="con_quien_vive" 
													required
													value="<?php echo dato_input("con_quien_vive","de");?>" 
												>
											</div>
										</div>


										<!-- Tiene Canaima -->
										<div class="row mb-4">
											<div class="col-12 col-lg-3">
												<label class="form-label requerido">¿Tiene Canaima?:</label>
											</div>
											<div class="col-12 col-lg-9">

												<div class="form-check form-check-inline">
													<input 
														id="tiene_canaima_si" 
														class="form-check-input" 
														type="radio" 
														name="tiene_canaima" 
														value="Si"
														required
														<?php dato_option("Si","tiene_canaima","rc","de");?>
													>
													<label for="tiene_canaima_si" class="form-label">Si </label>
												</div>

												<div class="form-check form-check-inline">
													<input 
														id="tiene_canaima_no" 
														class="form-check-input" 
														type="radio" 
														name="tiene_canaima" 
														value="No"
														required
														<?php dato_option("No","tiene_canaima","rc","de");?>
													>
													<label for="tiene_canaima_no" class="form-label">No </label>
												</div>
												<label id="tiene_canaima-error" class="error w-100" style="display:none;" for="tiene_canaima"></label>
											</div>
										</div>


										<!-- Condiciones de la Canaima -->
										<div class="row mb-4">
											<div class="col-12 col-lg-5">
												<label for="condiciones_canaima" class="form-label requerido">¿En que condiciones?:</label>
											</div>
											<div class="col-12 col-lg-7">
												<select 
													id="condiciones_canaima" 
													class="form-select mb-2" 
													name="condiciones_canaima" 
													required 
													<?php if (dato_input("tiene_canaima","de") != "Si"){echo 'disabled';};?>
												>
														<option selected value="">Seleccione una opción</option>
														<option <?php dato_option("Muy buenas Condiciones","condicion_canaima","s","de");?> value="Muy buenas Condiciones">Muy buenas Condiciones</option>
														<option <?php dato_option("Buenas Condiciones","condicion_canaima","s","de");?> value="Buenas Condiciones">Buenas Condiciones</option>
														<option <?php dato_option("Malas Condiciones","condicion_canaima","s","de");?> value="Malas Condiciones">Malas Condiciones</option>
														<option <?php dato_option("Muy malas Condiciones","condicion_canaima","s","de");?> value="Muy malas Condiciones">Muy malas Condiciones</option>
													</select>
											</div>
										</div>


										<!-- Carnet de la patria -->
										<div class="row mb-4">
											<div class="col-12 col-lg-4">
												<span class="form-label">Carnet de la patria:</span>
											</div>
											<!-- Código de carnet de la patria -->
											<div class="col-12 col-lg-4">
												<input 
													id="codigo_carnet_patria_est" 
													class="form-control" 
													type="text" 
													name="codigo_carnet_patria_est"
													placeholder="Codigo" 
													minlength="10" 
													maxlength="10"
													value="<?php echo dato_input("codigo_carnet","de");?>" 
												>
											</div>
											<!-- Serial del carnet de la patria -->
											<div class="col-12 col-lg-4">
												<input 
													id="serial_carnet_patria_est" 
													class="form-control" 
													type="text" 
													name="serial_carnet_patria_est"
													placeholder="Serial" 
													minlength="10" 
													maxlength="10"
													value="<?php echo dato_input("serial_carnet","de");?>" 
												>
											</div>
											<div class="col-12 col-lg-12">
												<span class="form-text">En caso de no tener, dejar vacío.</span>
											</div>
										</div>


										<!-- Acceso a internet -->
										<div class="row mb-4">
											<div class="col-12 col-lg-4">
												<label class="form-label requerido">¿Tiene acceso a internet?:</label>
											</div>
											<div class="col-12 col-lg-8">
												<div class="form-check form-check-inline">
													<input 
														id="internet_vivienda_si" 
														class="form-check-input" 
														type="radio" 
														name="internet_vivienda" 
														value="Si"
														required
														<?php dato_option("Si","acceso_internet","rc","de");?>
													>
													<label for="internet_vivienda_si" class="form-label">Si </label>
												</div>
												<div class="form-check form-check-inline">
													<input 
														id="internet_vivienda_no" 
														class="form-check-input" 
														type="radio" 
														name="internet_vivienda" 
														value="No"
														required
														<?php dato_option("No","acceso_internet","rc","de");?>
													>
													<label for="internet_vivienda_no" class="form-label">No </label>
												</div>
												<label id="internet_vivienda-error" class="error w-100" style="display:none;" for="internet_vivienda"></label>
											</div>
										</div>	
									</section>

									<!-- Datos académicos -->
									<section id="seccion4" class="row my-2" style="display:none;">

										<div class="row mb-4">
											<div class="col-12">
												<span class="h5 mb-3">
													<i class="fas fa-school fa-xl me-2"></i>
													Datos académicos.
												</span>
											</div>
										</div>

										<!-- Año a cursar -->
										<div class="row mb-4">
											<div class="col-12 col-lg-4">
												<label for="grado_a_cursar" class="form-label requerido">¿Que año va a cursar?:</label>
											</div>
											<div class="col-12 col-lg-8">
												<select class="form-select mb-2" name="grado_a_cursar" required>
													<option selected value="">Seleccione una opción</option>
													<option <?php dato_option("Primer año","grado_a_cursar","s","de");?> value="Primer año">Primer año</option>
													<option <?php dato_option("Segundo año","grado_a_cursar","s","de");?> value="Segundo año">Segundo año</option>
													<option <?php dato_option("Tercer año","grado_a_cursar","s","de");?> value="Tercer año">Tercer año</option>
													<option <?php dato_option("Cuarto año","grado_a_cursar","s","de");?> value="Cuarto año">Cuarto año</option>
													<option <?php dato_option("Quinto año","grado_a_cursar","s","de");?> value="Quinto año">Quinto año</option>
												</select>
											</div>
										</div>

										<!-- Año a cursar -->
										<div class="row mb-4">
											<div class="col-12 col-lg-4">
												<label for="seccion_a_cursar" class="form-label requerido">¿Que sección va a cursar?:</label>
											</div>
											<div class="col-12 col-lg-8">
												<select class="form-select mb-2" name="seccion_a_cursar" required>
													<option selected value="">Seleccione una opción</option>
													<option <?php dato_option("A","seccion","s","de");?> value="A">Sección "A"</option>
													<option <?php dato_option("B","seccion","s","de");?> value="B">Sección "B"</option>
													<option <?php dato_option("C","seccion","s","de");?> value="C">Sección "C"</option>
													<option <?php dato_option("D","seccion","s","de");?> value="D">Sección "D"</option>
												</select>
											</div>
										</div>

										<!-- Plantel de procedencia -->
										<div class="row mb-4">
											<div class="col-12 col-lg-4">
												<label for="plantel_procedencia" class="form-label requerido">Plantel de procedencia:</label>
											</div>
											<div class="col-12 col-lg-8">
												<input 
													id="plantel_procedencia"
													class="form-control mb-2"
													type="text" 
													minlength="10"
													maxlength="180" 
													name="plantel_procedencia" 
													placeholder="Institucion en que cursó primaria" 
													required
													value="<?php echo dato_input("plantel_proced","de");?>"
												>
											</div>
										</div>
										<div class="row mb-4">
											<!-- Materias pendientes -->
											<div class="col-12 col-lg-4">
												<label for="materias_pendientes" class="form-label">Materias pendientes:</label>
											</div>
											<div class="col-12 col-lg-8">
												<input
													id="materias_pendientes"
													class="form-control"
													type="text"
													name="materias_pendientes"
													placeholder="¿Cuáles materias tiene pendientes?"
													value="<?php echo dato_input("materias_pendientes","de");?>"
												>
											</div>
										</div>
										<!-- Estudiante repitente -->
										<div class="row mb-3">
											<!-- ¿El estudiante es repitente? -->
											<div class="col-12 col-lg-5">
												<label class="form-label requerido mb-3">¿El estudiante es repitente?:</label>
											</div>
											<div class="col-12 col-lg-7">
												<!-- Femenino -->
												<div class="form-check form-check-inline">
													<input 
														id="repitente_si" 
														class="form-check-input" 
														type="radio"
														name="repitente" 
														value="Si" 
														required
														<?php if (!empty(dato_input("a_repetido"))) {echo "checked";}?>
													>
													<label for="repitente_si" class="form-label">Si</label>
												</div>
												<!-- Femenino -->
												<div class="form-check form-check-inline">
													<input 
														id="repitente_no" 
														class="form-check-input" 
														type="radio"
														name="repitente" 
														value="No" 
														required
														<?php if (empty(dato_input("a_repetido"))) {echo "checked";}?>
													>
													<label for="repitente_no" class="form-label">No</label>
												</div>
												<label id="repitente-error" class="error w-100" style="display:none;" for="repitente"></label>
											</div>
										</div>

										<fieldset id="estudiante_repitente" class="row m-0 p-0"  disabled>
											<div class="row mb-4">
												<!-- ¿Que año repite? -->
												<div class="col-12 col-lg-4">
													<label for="a_repetido" class="form-label requerido">¿Que año repite?:</label>
												</div>
												<div class="col-12 col-lg-8">
													<select
														id="a_repetido" 
														class="form-select" 
														type="text" 
														name="a_repetido"
														list="grados" 
														placeholder="¿Que año repite?"
														required 
													>
														<option value="">Año repetido</option>
														<option <?php dato_option("Primer año","a_repetido","s","de");?> value="Primer año">Primer año</option>
														<option <?php dato_option("Segundo año","a_repetido","s","de");?> value="Segundo año">Segundo año</option>
														<option <?php dato_option("Tercer año","a_repetido","s","de");?> value="Tercer año">Tercer año</option>
														<option <?php dato_option("Cuarto año","a_repetido","s","de");?> value="Cuarto año">Cuarto año</option>
														<option <?php dato_option("Quinto año","a_repetido","s","de");?> value="Quinto año">Quinto año</option>
													</select>
												</div>
											</div>

											<div class="row mb-4">
												<!-- ¿Que materias? -->
												<div class="col-12 col-lg-4">
													<label for="materias_repitente" class="form-label">¿Que materias?:</label>
												</div>
												<div class="col-12 col-lg-8">
													<input 
														id="materias_repitente" 
														class="form-control" 
														type="text" 
														name="materias_repitente"
														placeholder="¿Cuáles materias repite?"
														value="<?php echo dato_input("materias_repetidas","de");?>"
													>
												</div>
											</div>

											<span class="form-text">En el caso de materias con que repite o tiene pendientes, si no sabe cuales son o no las recuerda. Dejar vacíos esos campos</span>
										</fieldset>
									</section>

									<!-- Ficha Medica -->
									<section id="seccion5" class="row my-2" style="display:none;">
										
										<!--Datos de salud-->
										<div class="row mb-4">
											<div class="col-12">
												<span class="h5 mb-3">
													<i class="fas fa-plus-square fa-xl me-2"></i>
													Datos de salud.
												</span>
											</div>
										</div>


										<!-- Medidas antropometricas -->
										<div class="row mb-3">
											<div class="col-12 col-lg-12">
												<label class="form-label mb-3">Medidas antropometricas:</label>
											</div>
										</div>
										<div class="row mb-4">
											<!-- Talla (Estatura) -->
											<div class="col-12 col-lg-6 mb-3">
												<label for="talla" class="form-label">Talla (Estatura):</label>
												<input 
													id="talla"
													class="form-control" 
													type="number" 
													name="talla" 
													placeholder="Talla(cm)" 
													maxlength="5"
													min="60"
													max="300"
													step="1" 
													value="<?php echo dato_input("estatura","de");?>"
												>
											</div>
											<!-- Peso -->
											<div class="col-12 col-lg-6 mb-3">
												<label for="peso" class="form-label">Peso:</label>
												<input 
													id="peso"
													class="form-control" 
													type="number" 
													name="peso" 
													placeholder="Peso(kg)" 
													maxlength="5"
													min="20"
													max="180"
													step="0.5" 
													value="<?php echo dato_input("peso","de");?>"
												>
											</div>

											<!-- Índice de masa corporal -->
											<div class="col-12 col-lg-6 mb-3">
												<label for="indice" class="form-label">Índice de masa corporal:</label>
												<input 
													id="indice"
													class="form-control" 
													type="number" 
													name="indice" 
													placeholder="Índice" 
													maxlength="5"
													min="0"
													max="100" 
													value="<?php echo dato_input("indice_m_c","de");?>"
												>
											</div>

											<!-- Circunferencia braquial -->
											<div class="col-12 col-lg-6 mb-3">
												<label for="c_braquial" class="form-label">Circunferencia braquial:</label>
												<input 
													id="c_braquial"
													class="form-control" 
													type="number" 
													name="c_braquial" 
													placeholder="Circ. del brazo" 
													maxlength="5" 
													max="30"
													min="8"
													value="<?php echo dato_input("circ_braquial","de");?>"
												>
											</div>

											<span class="form-text">
												-El índice(IMC) se calcula automáticamente al ingresar talla y peso, y puede ser editado si no es lo suficientemente preciso.
												<br>
												-En el caso de no conocer la talla, peso, índice(IMC), circunferencia braquial del estudiante. Dejar vacíos esos campos.
											</span>
										</div>
										
										<div class="row mb-4">
											<div class="col-12 col-lg-12">
												<span class="form-label mb-3">
													Tallas:
												</span>
											</div>
										</div>
										<div class="row mb-4">
											<!-- Talla de pantalón -->
											<div class="col-12 col-lg-4">
												<label for="talla_pantalon" class="form-label">Talla de pantalón:</label>
												<input 
													id="talla_pantalon" 
													class="form-control" 
													type="text" 
													name="talla_pantalon"
													placeholder="Pantalon" 
													maxlength="5" 
													value="<?php echo dato_input("pantalon","de");?>"
												>
											</div>
											<!-- Talla de camisa -->
											<div class="col-12 col-lg-4">
												<label for="talla_camisa" class="form-label">Talla de camisa:</label>
												<input 
													id="talla_camisa"
													class="form-control" 
													type="text" 
													name="talla_camisa" 
													placeholder="Camisa" 
													maxlength="5" 
													value="<?php echo dato_input("camisa","de");?>"
												>
											</div>
											<!-- Talla de zapatos -->
											<div class="col-12 col-lg-4">
												<label for="talla_zapatos" class="form-label">Talla de zapatos:</label>
												<input 
													id="talla_zapatos"
													class="form-control" 
													type="text" 
													name="talla_zapatos" 
													placeholder="Zapatos" 
													maxlength="5" 
													value="<?php echo dato_input("calzado","de");?>"
												>
											</div>
										</div>
										

										<!-- Enfermedad -->
										<div class="row mb-4">
											<div class="col-12 col-lg-5">
												<label for="enfermedad" class="form-label">¿Padece alguna enfermedad?:</label>
											</div>
											<div class="col-12 col-lg-7">
												<input 
													id="enfermedad" 
													class="form-control" 
													type="text" 
													name="enfermedad"
													placeholder="Enfermedad que padece"
													minlength="3"
													maxlength="50" 
													value="<?php echo dato_input("padecimiento","de");?>"
												>
											</div>
											<div class="col-12 col-lg-12">
												<span class="form-text">En caso de no padecer ninguna, dejar vacío.</span>
											</div>
										</div>

										<!-- Impedimento físico -->
										<div class="row mb-4">
											<div class="col-12 col-lg-5">
												<label for="enfermedad" class="form-label">¿Tiene algun impedimento físico?:</label>
											</div>
											<div class="col-12 col-lg-7">
												<input 
													id="impedimento" 
													class="form-control" 
													type="text" 
													name="impedimento"
													placeholder="impedimento que padece"
													minlength="3"
													maxlength="50" 
													value="<?php echo dato_input("impedimento_fisico","de");?>"
												>
											</div>
											<div class="col-12 col-lg-12">
												<span class="form-text">En caso de no padecer ninguno, dejar vacío.</span>
											</div>
										</div>
										

										<!-- Tipo de sangre -->
										<div class="row mb-4">
											<div class="col-12 col-lg-4">
												<label class="form-label requerido">Tipo de sangre:</label>
											</div>

											<?php 

												$grupo_s = trim(dato_input("tipo_sangre","de"),"+-");
												$fact_rhesus = substr(dato_input("tipo_sangre","de"),-1);

											?>

											<div class="col-12 col-lg-4">
												<select class="form-select" name="grupo_sanguineo" required>
													<option selected value="">Grupo sanguíneo</option>
													<option <?php if ($grupo_s == "O") {echo "selected";}?> value="O">O</option>
													<option <?php if ($grupo_s == "A") {echo "selected";}?> value="A">A</option>
													<option <?php if ($grupo_s == "B") {echo "selected";}?> value="B">B</option>
													<option <?php if ($grupo_s == "AB") {echo "selected";}?> value="AB">AB</option>
													<option <?php if ($grupo_s == "NC") {echo "selected";}?> value="NC">No conocido</option>
												</select>
											</div>
											<div class="col-12 col-lg-4">
												<select class="form-select" name="factor_rhesus" required>
													<option selected value="">Factor Rhesus</option>
													<option <?php if ($fact_rhesus == "+") {echo "selected";}?> value="+">+</option>
													<option <?php if ($fact_rhesus == "-") {echo "selected";}?> value="-">-</option>
													<option <?php if ($fact_rhesus == "N") {echo "selected";}?> value="N">No conocido</option>
												</select>
											</div>
										</div>
										

										<!-- Lateralidad -->
										<div class="row mb-4">
											<div class="col-12 col-lg-5">
												<label class="form-label requerido">Lateralidad:</label>
											</div>
											<div class="col-12 col-lg-7">
												<div class="form-check form-check-inline">
													<input 
														id="lateralidad_a" 
														class="form-check-input" 
														type="radio" 
														name="lateralidad"
														value="Ambidextro" 
														required
														<?php dato_option("Ambidextro","lateralidad","rc","de");?>
													>
													<label for="lateralidad_a" class="form-label">Ambidextro</label>
												</div>
												
												<div class="form-check form-check-inline">
													<input 
														id="lateralidad_d" 
														class="form-check-input" 
														type="radio" 
														name="lateralidad" 
														value="Diestro"
														required
														<?php dato_option("Diestro","lateralidad","rc","de");?>
													>
													<label for="lateralidad_d" class="form-label">Diestro</label>
												</div>
												
												<div class="form-check form-check-inline">
													<input 
														id="lateralidad_z" 
														class="form-check-input" 
														type="radio" 
														name="lateralidad" 
														value="Zurdo"
														required
														<?php dato_option("Zurdo","lateralidad","rc","de");?>
													>
													<label for="lateralidad_z" class="form-label">Zurdo</label>
												</div>
												<label id="lateralidad-error" class="error w-100" style="display:none;" for="lateralidad"></label>
											</div>
										</div>


										<!-- Condición de la dentadura -->
										<div class="row mb-4">
											<div class="col-12 col-lg-5">
												<label class="form-label requerido">Condición de la dentadura:</label>
											</div>
											<div class="col-12 col-lg-7">
												<div class="form-check form-check-inline">
													<input 
														id="dentadura_b" 
														class="form-check-input" 
														type="radio" 
														name="dentadura"
														value="Buena"
														required
														<?php dato_option("Buena","condicion_dental","rc","de");?>
													>
													<label for="dentadura_b" class="form-label">Buena </label>
												</div>
												<div class="form-check form-check-inline">
													<input 
														id="dentadura_r" 
														class="form-check-input" 
														type="radio" 
														name="dentadura"
														value="Regular"
														required
														<?php dato_option("Regular","condicion_dental","rc","de");?>
													>
													<label for="dentadura_r" class="form-label">Regular </label>
												</div>
												<div class="form-check form-check-inline">
													<input 
														id="dentadura_m" 
														class="form-check-input" 
														type="radio" 
														name="dentadura"
														value="Mala"
														required
														<?php dato_option("Mala","condicion_dental","rc","de");?>
													>
													<label for="dentadura_m" class="form-label">Mala </label>
												</div>
												<label id="dentadura-error" class="error w-100" style="display:none;" for="dentadura"></label>									
											</div>
										</div>
										

										<!-- Condición de la vista -->
										<div class="row mb-4">
											<div class="col-12 col-lg-5">
												<label class="form-label requerido">Condición de la vista:</label>
											</div>
											<div class="col-12 col-lg-7">
												<div class="form-check form-check-inline">
													<input
														id="vista_b" 
														class="form-check-input" 
														type="radio" 
														name="vista"
														value="Buena" 
														required
														<?php dato_option("Buena","condicion_vista","rc","de");?>
													>
													<label for="vista_b" class="form-label">Buena </label>
												</div>
												<div class="form-check form-check-inline">
													<input
														id="vista_r" 
														class="form-check-input" 
														type="radio" 
														name="vista"
														value="Regular" 
														required
														<?php dato_option("Regular","condicion_vista","rc","de");?>
													>
													<label for="vista_r" class="form-label">Regular </label>
												</div>
												<div class="form-check form-check-inline">
													<input
														id="vista_m" 
														class="form-check-input" 
														type="radio" 
														name="vista"
														value="Mala" 
														required
														<?php dato_option("Mala","condicion_vista","rc","de");?>
													>
													<label for="vista_m" class="form-label">Mala </label>
												</div>
												<label id="vista-error" class="error w-100" style="display:none;" for="vista"></label>								
											</div>
										</div>
										
										<!-- Condiciones de salud / discapacidades -->
										<div class="row mb-4">
											<div class="col-12 col-lg-12">
												<label class="form-label mb-3">¿Presenta alguna de estas condiciones?:</label>
											</div>

											<div class="row row-cols-1 row-cols-lg-4 px-5 justify-content-between">
												<div class="col form-check form-check-inline">
													<input 
														id="cond_visual" 
														class="form-check-input" 
														type="checkbox" 
														name="cond_visual"
														value="Visual"
														<?php dato_option("V","visual","rc","de");?>
													>
													<label for="cond_visual" class="form-label">Visual </label>
												</div>
												<div class="col form-check form-check-inline">
													<input 
														id="cond_motora" 
														class="form-check-input" 
														type="checkbox" 
														name="cond_motora"
														value="Motora"
														<?php dato_option("M","motora","rc","de");?>
													>
													<label for="cond_motora" class="form-label">Motora </label>
												</div>
												<div class="col form-check form-check-inline">
													<input 
														id="cond_auditiva" 
														class="form-check-input" 
														type="checkbox" 
														name="cond_auditiva"
														value="Auditiva"
														<?php dato_option("A","auditiva","rc","de");?>
													>
													<label for="cond_auditiva" class="form-label">Auditiva </label>
												</div>
												<div class="col form-check form-check-inline">
													<input 
														id="cond_escritura" 
														class="form-check-input" 
														type="checkbox" 
														name="cond_escritura"
														value="Escritura"
														<?php dato_option("E","escritura","rc","de");?>
													>
													<label for="cond_escritura" class="form-label">Escritura </label>
												</div>
												<div class="col form-check form-check-inline">
													<input 
														id="cond_lectura" 
														class="form-check-input" 
														type="checkbox" 
														name="cond_lectura"
														value="Lectura"
														<?php dato_option("L","lectura","rc","de");?>
													>
													<label for="cond_lectura" class="form-label">Lectura </label>
												</div>
												<div class="col form-check form-check-inline">
													<input 
														id="cond_lenguaje" 
														class="form-check-input" 
														type="checkbox" 
														name="cond_lenguaje"
														value="Lenguaje"
														<?php dato_option("L","lenguaje","rc","de");?>
													>
													<label for="cond_lenguaje" class="form-label">Lenguaje </label>
												</div>
												<div class="col form-check form-check-inline">
													<input 
														id="cond_embarazo" 
														class="form-check-input" 
														type="checkbox" 
														name="cond_embarazo"
														value="Embarazo"
														<?php dato_option("E","embarazo","rc","de");?>
													>
													<label for="cond_embarazo" class="form-label">Embarazo </label>
												</div>
											</div>
										</div>
										

										<!-- Necesidad educativa especial -->
										<div class="row mb-4">
											<div class="col-12 col-lg-12">
												<label for="necesidad_educativa" class="form-label mb-3">¿Presenta alguna necesidad educativa especial?:</label>
											</div>
											<div class="col-12 col-lg-12">
												<input 
													id="necesidad_educativa" 
													class="form-control" 
													type="text" 
													name="necesidad_educativa"
													placeholder="¿Cuál necesidad educativa?"
													minlength="3"
													maxlength="180" 
													value="<?php echo dato_input("necesidad_educativa","de");?>"
												>
											</div>
										</div>
										

										<!-- Es atendido por otra institución  -->
										<div class="row mb-4">
											<div class="col-12 col-lg-5">
												<label for="institucion_medica" class="form-label">¿Es atendido por otra institución?:</label>
											</div>
											<div class="col-12 col-lg-7">
												<input 
													id="institucion_medica" 
													class="form-control" 
													type="text" 
													name="institucion_medica"
													placeholder="¿Cuál institucion?"
													minlength="3"
													maxlength="180"
													value="<?php echo dato_input("institucion_medica","de");?>"
												>
											</div>
										</div>


										<!--Datos de salud-->
										<div class="row my-4">
											<div class="col-12">
												<span class="h5 mb-3">
													<i class="fas fa-syringe fa-xl me-2"></i>
													Datos de vacunación.
												</span>
											</div>
										</div>							

										<!-- Vacunación -->
										<div class="row mb-4">
											<div class="col-12 col-lg-12">
												<span class="form-label">¿Cuales de estas vacunas ha recibido el estudiante?</span>
											</div>
										</div>
										<div class="row mb-4">
											<div class="col-12 col-lg-12">

												<div class="form-check mb-2 mx-md-4">
													<input 
														id="vph"
														class="form-check-input" 
														name="vph" 
														type="checkbox" 
														value="vph"
														<?php estado_vacuna("vph"); ?>
													>
													<label class="form-check-label" for="vph">
														Vacuna contra Virus del papiloma humano, VPH
													</label>
												</div>
												<div class="form-check mb-2 mx-md-4">
													<input 
														id="tdap"
														class="form-check-input" 
														name="tdap" 
														type="checkbox" 
														value="tdap" 
														<?php estado_vacuna("tdap"); ?>
													>
													<label class="form-check-label" for="tdap">
														Vacuna contra Tétanos, difteria y tos ferina o pertussis (Tdap)
													</label>
												</div>
												<div class="form-check mb-2 mx-md-4">
													<input 
														id="menacwy"
														class="form-check-input" 
														name="menacwy" 
														type="checkbox" 
														value="menacwy" 
														<?php estado_vacuna("menacwy"); ?>
													>
													<label class="form-check-label" for="menacwy">
														Vacuna contra Enfermedad meningococica (MenACWY)
													</label>
												</div>
												<div class="form-check mb-2 mx-md-4">
													<input 
														id="hep_a"
														class="form-check-input" 
														name="hep_a" 
														type="checkbox" 
														value="hep_a" 
														<?php estado_vacuna("hep_a"); ?>
													>
													<label class="form-check-label" for="hep_a">
														Vacuna contra Hepatitis A (HepA)
													</label>
												</div>
												<div class="form-check mb-2 mx-md-4">
													<input 
														id="hep_b"
														class="form-check-input" 
														name="hep_b" 
														type="checkbox" 
														value="hep_b" 
														<?php estado_vacuna("hep_b"); ?>
													>
													<label class="form-check-label" for="hep_b">
														Vacuna contra Hepatitis B (HepB)
													</label>
												</div>
												<div class="form-check mb-2 mx-md-4">
													<input 
														id="ipv"
														class="form-check-input" 
														name="ipv" 
														type="checkbox" 
														value="ipv" 
														<?php estado_vacuna("ipv"); ?>
													>
													<label class="form-check-label" for="ipv">
														Vacuna contra Poliomielitis (IPV)
													</label>
												</div>
												<div class="form-check mb-2 mx-md-4">
													<input 
														id="mmr"
														class="form-check-input" 
														name="mmr" 
														type="checkbox" 
														value="mmr" 
														<?php estado_vacuna("mmr"); ?>
													>
													<label class="form-check-label" for="mmr">
														Vacuna contra Sarampión, paperas, rubéola (MMR)
													</label>
												</div>
												<div class="form-check mb-2 mx-md-4">
													<input 
														id="varicela"
														class="form-check-input" 
														name="varicela" 
														type="checkbox" 
														value="varicela" 
														<?php estado_vacuna("varicela"); ?>
													>
													<label class="form-check-label" for="varicela">
														Vacuna contra Varicela
													</label>
												</div>
												<div class="form-check mb-2 mx-md-4">
													<input 
														id="antiamarilica"
														class="form-check-input" 
														name="antiamarilica" 
														type="checkbox" 
														value="antiamarilica" 
														<?php estado_vacuna("antiamarilica"); ?>
													>
													<label class="form-check-label" for="antiamarilica">
														Vacuna Antiamarílica
													</label>
												</div>
												<div class="form-check mb-2 mx-md-4">
													<input 
														id="antigripal"
														class="form-check-input" 
														name="antigripal" 
														type="checkbox" 
														value="antigripal" 
														<?php estado_vacuna("antigripal"); ?>
													>
													<label class="form-check-label" for="antigripal">
														Vacuna Antigripal
													</label>
												</div>
											</div>
										</div>
										

										<!-- Vacunación COVID-19 -->
										<div class="row mb-4">
											<div class="col-12 col-lg-12">
												<i class="fa-solid fa-virus-covid-slash fa-lg me-1"></i>
												<label class="form-label mb-3 h5">Vacunación contra la COVID-19:</label>
											</div> 
										</div>
										<div class="row mb-4">
											<div class="col-12 col-lg-3">
												<!-- Vacuna aplicada -->
												<label for="vacuna" class="form-label">Vacuna aplicada:</label>
											</div>
											<div class="col-12 col-lg-5">

												<?php 

													$vacunas_e = [
														"NV",
														"Pfizer/BioNTech",
														"Moderna",
														"AztraZeneca",
														"Janssen",
														"Sinopharm",
														"Sinovac",
														"Bharat",
														"CanSinoBIO",
														"Valneva",
														"Novavax",
													];


													if (in_array(dato_input("vac_aplicada","de"), $vacunas_e)) {
														$vac_otra = true;
													}
													else{
														$vac_otra = false;
													}

												?>


												<select 
													id="vacuna"
													class="form-select" 
													name="vacuna" 
												>
													<option class="small" value="" selected>Vacuna contra covid19 aplicada</option>
													<option <?php dato_option("NV","vac_aplicada","s","de");?> class="small" value="NV">No vacunado</option>
													<option <?php dato_option("Pfizer/BioNTech","vac_aplicada","s","de");?> class="small" value="Pfizer/BioNTech">Pfizer/BioNTech</option>
													<option <?php dato_option("Moderna","vac_aplicada","s","de");?> class="small" value="Moderna">Moderna</option>
													<option <?php dato_option("AztraZeneca","vac_aplicada","s","de");?> class="small" value="AztraZeneca">AztraZeneca</option>
													<option <?php dato_option("Janssen","vac_aplicada","s","de");?> class="small" value="Janssen">Janssen</option>
													<option <?php dato_option("Sinopharm","vac_aplicada","s","de");?> class="small" value="Sinopharm">Sinopharm</option>
													<option <?php dato_option("Sinovac","vac_aplicada","s","de");?> class="small" value="Sinovac">Sinovac</option>
													<option <?php dato_option("Bharat","vac_aplicada","s","de");?> class="small" value="Bharat">Bharat</option>
													<option <?php dato_option("CanSinoBIO","vac_aplicada","s","de");?> class="small" value="CanSinoBIO">CanSinoBIO</option>
													<option <?php dato_option("Valneva","vac_aplicada","s","de");?> class="small" value="Valneva">Valneva</option>
													<option <?php dato_option("Novavax","vac_aplicada","s","de");?> class="small" value="Novavax">Novavax</option>
													<option <?php if (!$vac_otra) { echo "selected";}?> class="small" value="Otra">Otra</option>
												</select>
											</div>
											
											<div class="col-12 col-lg-4">
												<!-- Otra vacuna no listada -->
												<input 
													id="vacuna_otra"
													class="form-control" 
													type="text" 
													name="vacuna_otra" 
													placeholder="Otra vacuna" 
													maxlength="15"
													required 
													<?php if (!$vac_otra): ?>
													value="<?php echo dato_input("vacuna_otra","de");?>"
													<?php else: ?>
													disabled
													<?php endif ?>
												>
											</div>
										</div>

										<div class="row mb-4">

											<!-- Dosis -->
											<div class="col-12 col-lg-6">
												<label for="dosis" class="form-label">Dosis aplicadas:</label>
												<input 
													id="dosis"
													class="form-control" 
													type="number" 
													name="dosis" 
													placeholder="Número de dosis aplicadas" 
													min="0" 
													max="10" 
													step="1"
													<?php if (dato_input("vacuna","de") == "NV" or empty(dato_input("vacuna","de"))){echo 'disabled';};?>
													value="<?php echo dato_input("dosis","de");?>"
												>
											</div>
											<!-- Lote -->
											<div class="col-12 col-lg-6">
												<label for="lote" class="form-label">Lote de vacuna (Última):</label>
												<input 
													id="lote"
													class="form-control" 
													type="text" 
													name="lote" 
													placeholder="Código de lote de vacuna" 
													minlength="15"
													maxlength="15"
													<?php if (dato_input("vacuna","de") == "NV" or empty(dato_input("vacuna","de"))){echo 'disabled';};?>
													value="<?php echo dato_input("lote","de");?>"
												>
											</div>
										</div>

										<div class="row mb-4">
											<!-- Información adicional -->
											<div class="col-12 col-lg-12">
												<span class="form-text mt-3">En caso de no estar vacunado, seleccionar no vacunado en la lista de opciones. De no recordar dosis o número de lote, dejar en blanco.</span>
											</div>
										</div>
										
										<!-- Dieta especial -->
										<div class="row mb-4">
											<div class="col-12 col-lg-5">
												<label for="dieta_especial" class="form-label">¿Tiene alguna dieta especial?:</label>
											</div>
											<div class="col-12 col-lg-7">
												<input 
													id="dieta_especial" 
													class="form-control" 
													type="text" 
													name="dieta_especial"
													placeholder="¿Que dieta?"
													minlength="3"
													maxlength="180"
													value="<?php echo dato_input("dieta_especial","de");?>"
												>
											</div>
										</div>
										
										<!-- Dieta especial -->
										<div class="row mb-4">
											<div class="col-12 col-lg-5">
												<label for="medicacion" class="form-label">¿Recibe alguna medicación?:</label>
											</div>
											<div class="col-12 col-lg-7">
												<input 
													id="medicacion" 
													class="form-control" 
													type="text" 
													name="medicacion"
													placeholder="¿Cuál?"
													minlength="3"
													maxlength="180"
													value="<?php echo dato_input("medicacion","de");?>"
												>
											</div>
										</div>
										
										<!-- Carnet de discapacidad -->
										<div class="row mb-4">
											<div class="col-12 col-lg-5">
												<label for="nro_carnet_discapacidad" class="form-label">¿Posee carnet de discapacidad?:</label>
											</div>
											<div class="col-12 col-lg-7">
												<input 
													id="nro_carnet_discapacidad" 
													class="form-control" 
													type="text" 
													name="nro_carnet_discapacidad"
													placeholder="Número de carnet" 
													maxlength="25"
													value="<?php echo dato_input("carnet_discapacidad","de");?>"
												>
											</div>
										</div>
									</section>

									<!-- Observaciones -->
									<section id="seccion6" class="row my-2" style="display:none;">
										
										<div class="row mb-4">
											<div class="col-12">
												<span class="h5 mb-3">
													<i class="fa-solid fa-eye fa-xl me-2"></i>
													Observaciones.
												</span>
											</div>
										</div>
										

										<!-- Informacion de la sección -->
										<div class="row mb-4">
											<div class="col-12 col-lg-12">
												<label class="form-label text-muted">
													<small>
														Realice una descripción general de su representado, mencionando características en el
														aspecto social, físico, personal, familiar y académico que a usted le gustaría dar a
														conocer a los docentes de la institución. La misma no debe exceder los 150 caracteres
													</small>
												</label>
											</div>
										</div>


										<!-- Social -->
										<div class="row mb-4">
											<div class="col-12 col-lg-2">
												<label for="observaciones_social" class="form-label">Social:</label>
											</div>
											<div class="col-12 col-lg-10">
												<textarea 
													id="observaciones_social" 
													class="form-control" 
													name="observaciones_social" 
													cols="30" 
													rows="2"
													maxlength="150"
												><?php echo dato_input("social","de");?></textarea>
											</div>
										</div>


										<!-- Físico -->
										<div class="row mb-4">
											<div class="col-12 col-lg-2">
												<label for="observaciones_fisico" class="form-label">Físico:</label>
											</div>
											<div class="col-12 col-lg-10">
												<textarea 
													id="observaciones_fisico" 
													class="form-control" 
													name="observaciones_fisico" 
													cols="30" 
													rows="2"
													maxlength="150"
												><?php echo dato_input("fisico","de");?></textarea>
											</div>
										</div>


										<!-- Personal -->
										<div class="row mb-4">
											<div class="col-12 col-lg-2">
												<label for="observaciones_personal" class="form-label">Personal:</label>
											</div>
											<div class="col-12 col-lg-10">
												<textarea 
													id="observaciones_personal" 
													class="form-control" 
													name="observaciones_personal" 
													cols="30" 
													rows="2"
													maxlength="150"
												><?php echo dato_input("personal","de");?></textarea>
											</div>
										</div>


										<!-- Familiar -->
										<div class="row mb-4">
											<div class="col-12 col-lg-2">
												<label for="observaciones_familiar" class="form-label">Familiar:</label>
											</div>
											<div class="col-12 col-lg-10">
												<textarea 
													id="observaciones_familiar" 
													class="form-control" 
													name="observaciones_familiar" 
													cols="30" 
													rows="2"
													maxlength="150"
												><?php echo dato_input("familiar","de");?></textarea>
											</div>
										</div>


										<!-- Académico -->
										<div class="row mb-4">
											<div class="col-12 col-lg-2">
												<label for="observaciones_academico" class="form-label">Académico:</label>
											</div>
											<div class="col-12 col-lg-10">
												<textarea 
													id="observaciones_academico" 
													class="form-control" 
													name="observaciones_academico" 
													cols="30" 
													rows="2"
													maxlength="150"
												><?php echo dato_input("academico","de");?></textarea>
											</div>
										</div>


										<!-- Otra -->
										<div class="row mb-4">
											<div class="col-12 col-lg-2">
												<label for="observaciones_otra" class="form-label">Otra:</label>
											</div>
											<div class="col-12 col-lg-10">
												<textarea 
													id="observaciones_otra" 
													class="form-control" 
													name="observaciones_otra" 
													cols="30" 
													rows="2"
													maxlength="150"
												><?php echo dato_input("otra","de");?></textarea>
											</div>
										</div>								
									</section>
									<input type="hidden" name="paso_3" value="paso_3">
								</form>
							</div>
						</div>
					</div>
					<div class="card-footer nav justify-content-md-between">
						<a class="btn btn-primary" href="../consultar/index.php?sec=est">
							<i class="fa-solid fa-lg me-2 fa-home"></i>
							Volver al inicio
						</a>
						<div class="ms-auto">
							<button id="boton_anterior" class="btn btn-primary" type="button">
								<i class="fa-solid fa-lg me-2 fa-backward"></i>
								Anterior
							</button>
							<button id="boton_siguiente" class="btn btn-primary" type="button">
								Siguiente
								<i class="fa-solid fa-lg ms-2 fa-forward"></i>
							</button>
							<button id="boton_guardar" class="btn btn-primary" type="button" style="display: none;">
								Guardar y continuar
								<i class="fa-solid fa-lg ms-2 fa-floppy-disk"></i>
							</button>
						</div>
					</div>
				</div>
				
			</div>
			<?php include('../../footer.php'); ?>
			<?php include('../../ayuda.php'); ?>
		</main>
		<script type="text/javascript" src="../../js/sweetalert2.js"></script>
		<script type="text/javascript" src="../../js/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="../../js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="../../js/validaciones/additional-methods.min.js"></script>
		<script type="text/javascript" src="../../js/messages_es.min.js"></script>
		<script type="text/javascript" src="../../js/validaciones/validaciones_estudiante.js"></script>
		<script type="text/javascript" src="../../js/bootstrap.bundle.min.js"></script>
		<script type="text/javascript" src="../../js/logout_inactividad.js"></script>
	</body>
</html>