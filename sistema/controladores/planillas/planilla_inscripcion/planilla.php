<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>


<body class="m-0 p-0">

	<style type="text/css">

		<?php

			$content = file_get_contents('../../css/bootstrap.css');
			echo $content;

		?>

		/*

			Medidas

			Con el ancho usable de una hoja con margenes
			apa se cuenta horizontalmente con:

			8.5 x 11 pulgadas	ó	468 píxeles / 6 = 78 píxeles

			se trabaja con 6 columnas

		*/
		table.area-firma tr td  {
			border-top: none !important;
			border-bottom: none !important;
			border-left: none !important;
			border-right: none !important;
		}

		table.tabla-datos tr td,
		table.tabla-datos tr th {
			min-width: 78px !important;
			max-width: 78px !important;
			border: solid black 1px;
		}


		table.tabla-datos > tr > th {
			font-size: .70rem !important;
		}

		table.tabla-datos {
			font-size: .65rem;
		}

		/* Para el estudiante */
		.bg-info {
			background-color: #bdd6ee !important;
		}

		/* Para el padre */
		.bg-danger {
			background-color: #f8d7da !important;
		}

		/* Para el padre */
		.bg-warning {
			background-color: #fff3cd !important;
		}

		/* Para el representante */
		.bg-success {
			background-color: #d1e7dd !important;
		}

		/* Para el representante */
		.bg-secondary {
			background-color: #e2e3e5 !important;
		}

	</style>

	<?php

		// Orden de los componentes de la planilla

		// 1. Año escolar
		// 2. años cursados y foto
		// 3. datos del estudiante
		// 4. datos del representante
		// 5. datos del padre
		// 6. datos de la madre
		// 6. observaciones
		// 6. recaudos

	?>
		<?php include 'tablas/header.php'; ?>
	<table class="table table-sm text-uppercase tabla-datos">
		<?php include 'tablas/estudiantes.php'; ?>
		<?php include 'tablas/padre.php'; ?>
		<?php include 'tablas/madre.php'; ?>
		<?php include 'tablas/representante.php'; ?>
		<?php include 'tablas/hijos_en_plantel.php'; ?>
		<?php include 'tablas/datos_adicionales.php'; ?>
		<?php include 'tablas/observaciones.php'; ?>
		<?php include 'tablas/recaudos.php'; ?>
	</table>

	<?php

		$fecha_actual = date("d-m-Y");

		date_default_timezone_set("America/Caracas");
		setlocale(LC_ALL, 'es_VE.UTF-8','esp');
		/* Convertimos la fecha a marca de tiempo */
		$marca = strtotime($fecha_actual);

		$fecha_expedicion = ucfirst(utf8_encode(strftime('%A'))). ", " .strftime('%e de %B de %Y', $marca);

	?>
	
	<p class="mt-4" style="font-size: .85rem;">
		Planilla expedida el día viernes, <?php echo $fecha_expedicion; ?>
	</p>

</body>
</html>