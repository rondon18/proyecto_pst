<?php

session_start();

if (!$_SESSION['login']) {
    header('Location: ../index.php');
    exit();
}

require('../fpdf/fpdf.php');

require('../clases/estudiante.php');
require('../clases/representantes.php');
require('../clases/economicos-representantes.php');
require('../clases/laborales-representantes.php');
require('../clases/padres.php');
require('../clases/ficha-medica.php');
require('../clases/sociales-estudiantes.php');
require('../clases/tallas-estudiantes.php');
require('../clases/grado.php');
require('../clases/vivienda-representantes.php');
require('../clases/año-escolar.php');
require('../clases/Estudiantes-repitentes.php');
require('../clases/telefonos.php');

require('../controladores/conexion.php');

require('../clases/bitacora.php');

$conexion = conectarBD();

$Estudiante = new Estudiantes();
$Representante = new Representantes();
$Economicos = new DatosEconomicos();
$Laborales = new DatosLaborales();
$Padre = new Padres();
$Estudiantes_repitente = new EstudiantesRepitentes();
$Grado = new GradoAcademico();
$Año = new Año_Escolar();
$Telefonos = new Telefonos();

$datos_Medicos = new FichaMedica();
$Datos_sociales = new DatosSociales();
$Datos_Tallas = new TallasEstudiante();
$Datos_vivienda = new DatosVivienda();

#Hacer algo parecido para llamar numeros de representantes y padres
$Estudiante = $Estudiante->consultarEstudiante($_POST['cedula_Estudiante']);


$Estudiantes_repitente = $Estudiantes_repitente->consultarEstudiantesRepitentes($_POST['id_Estudiante']);
$grado = $Grado->consultarGrado($_POST['id_Estudiante']);
$telefonos_Est = $Telefonos->consultarTelefonos($_POST['cedula_Estudiante']);
$telefonos_re = $Telefonos->consultarTelefonosRepresentanteID($_POST['id_representante']);
$telefonos_pa = $Telefonos->consultarTelefonosPadreID($_POST['id_padre']);

$datos_medicos = $datos_Medicos->consultarFicha_Medica($_POST['id_Estudiante']);
$datos_sociales = $Datos_sociales->consultarDatosSociales($_POST['id_Estudiante']);
$datos_tallas = $Datos_Tallas->consultarTallasEstudiante($_POST['id_Estudiante']);
$datos_vivienda = $Datos_vivienda->consultarDatosvivienda($_POST['id_representante']);

$datos_representante = $Representante->consultarRepresentanteID($_POST['id_representante'],);
$datos_economicos = $Economicos->consultarDatosEconomicos($_POST['id_representante']);
$datos_laborales = $Laborales->consultarDatosLaborales($_POST['id_representante']);


$padre = $Padre->consultarPadres($_POST['id_padre']);
$tienemashijos = $Padre->tieneMasHijos($_POST['id_padre']);

$fecha_actual = date("Y-m-d");
$fecha_nacimiento_est = $Estudiante['Fecha_Nacimiento'];
$fecha_nacimiento_re = $datos_representante['Fecha_Nacimiento'];
$fecha_nacimiento_pa = $padre['Fecha_Nacimiento'];
$edad_diff_est = date_diff(date_create($fecha_nacimiento_est), date_create($fecha_actual));
$edad_diff_re = date_diff(date_create($fecha_nacimiento_re), date_create($fecha_actual));
$edad_diff_pa = date_diff(date_create($fecha_nacimiento_pa), date_create($fecha_actual));

#Para rellenar el campo de si tiene carnet de la patria
$carnet = "";
if (empty($datos_sociales['Codigo_Carnet_Patria']) AND empty($datos_sociales['Serial_Carnet_Patria'])) {
  $carnet = "No";
}
else {
  $carnet = "Si";
}

if (empty($datos_medicos['Institucion_Medica'])) {
    $Institucion = "No";
}
else {
    $Institucion = "Si";
}

if (empty($datos_medicos['Carnet_Discapacidad'])) {
    $carnet_dis = "No";
}
else {
    $carnet_dis = "Si";
}

if (empty($datos_laborales['Empleo']) || $datos_laborales['Empleo']=="Desempleado") {
    $tiene_empleo = "No";
}
else {
    $tiene_empleo = "Si";
}

$Año_actual = date("Y");
$Inicio_Año_Escolar = $Año_actual;
$Fin_Año_Escolar = $Año_actual+1;

class PDF extends FPDF
{

function Header()
{
    $Año_actual = date("Y");
    $Inicio_Año_Escolar = $Año_actual;
    $Fin_Año_Escolar = $Año_actual+1;
    $this->SetFont('Arial','',18);
    $this->Image('../img/logo.jpg',30,5,150,20);
    $this->Ln(15);
    $this->Cell(0,6,utf8_decode('INSCRIPCIÓN AÑO ESCOLAR ' . $Inicio_Año_Escolar . '-' . $Fin_Año_Escolar),0,1,'C');
    parent::Header();
}
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',14);

#PARTE DEL ESTUDIANTE

$pdf->Image('../img/foto.jpg',165,40,23,0);
$pdf->Cell(0,20,utf8_decode('PLANILLA DEL ESTUDIANTE'),0,1,'C');
$pdf->SetFont('Arial','',8);
$pdf->SetXY(50.1,44);
$pdf->Cell(22,12,utf8_decode('1er año fecha'),1,0);
$pdf->Cell(22,12,utf8_decode('2do año fecha'),1,0);
$pdf->Cell(22,12,utf8_decode('3er año fecha'),1,0);
$pdf->Cell(22,12,utf8_decode('4to año fecha'),1,0);
$pdf->Cell(22,12,utf8_decode('5to año fecha'),1,1);
$pdf->Multicell(40,6,utf8_decode("INDIQUE CON UNA X\nEL AÑO DE ESTUDIO"),1,0); 
$pdf->SetXY(50.1,56);
$pdf->Cell(22,12,utf8_decode(' '),1,0);
$pdf->Cell(22,12,utf8_decode(' '),1,0);
$pdf->Cell(22,12,utf8_decode(' '),1,0);
$pdf->Cell(22,12,utf8_decode(' '),1,0);
$pdf->Cell(22,12,utf8_decode(' '),1,1);
$pdf->Multicell(40,6,utf8_decode("SECCIÓN\n(DEJAR EN BLANCO)"),1,0);
$pdf->SetXY(50.1,68);
$pdf->Cell(22,12,utf8_decode(' '),1,0);
$pdf->Cell(22,12,utf8_decode(' '),1,0);
$pdf->Cell(22,12,utf8_decode(' '),1,0);
$pdf->Cell(22,12,utf8_decode(' '),1,0);
$pdf->Cell(22,12,utf8_decode(' '),1,1);
$pdf->Ln(6);
$pdf->SetFillColor(189,214,238);
$pdf->SetFont('Arial','',14);
$pdf->Cell(0,6,utf8_decode('DATOS PERSONALES'),1,1,'C',1);
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,6,utf8_decode('NOMBRES Y APELLIDOS DEL Estudiantes: ' . $Estudiante['Primer_Nombre'] . ' ' . $Estudiante['Segundo_Nombre'] . ' ' . $Estudiante['Primer_Apellido'] . ' ' . $Estudiante['Segundo_Apellido']),1,1);
$pdf->Cell(54,6,utf8_decode('CÉDULA DE IDENTIDAD: ' . $Estudiante['Cédula']),1,0);
$pdf->Cell(17,6,utf8_decode('EDAD: ' . $edad_diff_est->format('%y')),1,0);
#                                                         OJO: LA CANTIDAD DEL ARREGLO VARIA
$pdf->Cell(0,6,utf8_decode('TELÉFONOS, MÓVIL Y CASA: ' . $telefonos_Est[0]['Prefijo'] . "-" . $telefonos_Est[0]['Número_Telefónico'] . '   ' . $telefonos_Est[1]['Prefijo'] . "-" . $telefonos_Est[1]['Número_Telefónico']),1,1);
$pdf->Cell(57,6,utf8_decode('FECHA DE NACIMIENTO: ' .  $Estudiante['Fecha_Nacimiento']),1,0);
$pdf->SetFont('Arial','',7);
$pdf->Cell(60,6,utf8_decode('LUGAR DE NACIMIENTO: ' . $Estudiante['Lugar_Nacimiento']),1,0);
$pdf->Cell(0,6,utf8_decode('CORREO ELECTRÓNICO: ' . $Estudiante['Correo_Electrónico']),1,1,);
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,6,utf8_decode('PLANTEL DE PROCEDENCIA: ' . $Estudiante['Plantel_Procedencia']),1,1,);
$pdf->Ln(6);

$pdf->SetFont('Arial','',14);
$pdf->Cell(0,6,utf8_decode('DATOS SOCIALES'),1,1,'C',1);
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,6,utf8_decode('LUGAR DE DOMICILIO: ' . $Estudiante['Dirección']),1,1,);
$pdf->Cell(65,6,utf8_decode('CON QUIÉN VIVE: ' . $datos_sociales['Con_Quien_Vive']),1,0);
$pdf->Cell(35,6,utf8_decode('TIENE CANAIMA: ' . $datos_sociales['Posee_Canaima']),1,0,);
$pdf->Cell(0,6,utf8_decode('CONDICIÓN DE LA CANAIMA: ' . $datos_sociales['Condicion_Canaima']),1,1,);
$pdf->Cell(55,6,utf8_decode('POSEE CARNET DE LA PATRIA: ' . $carnet),1,0,);
$pdf->SetFont('Arial','',7);
$pdf->Cell(66,6,utf8_decode('CODIGO CARNET DE LA PATRIA: ' . $datos_sociales['Codigo_Carnet_Patria']),1,0,);
$pdf->Cell(0,6,utf8_decode('SERIAL CARNET DE LA PATRIA: ' . $datos_sociales['Serial_Carnet_Patria']),1,1,);
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,6,utf8_decode('CUENTA CON ACCESO A INTERNET: ' . $datos_sociales['Acceso_Internet']),1,1,);
$pdf->Ln(6);

$pdf->SetFont('Arial','',14);
$pdf->Cell(0,6,utf8_decode('DATOS DE SALUD'),1,1,'C',1);
$pdf->SetFont('Arial','',9);
$pdf->Cell(35,6,utf8_decode('ANTROPOMÉTRICOS'),1,0);
$pdf->Cell(22,6,utf8_decode('ÍNDICE: ' . $datos_medicos['Indice']),1,0,);
$pdf->Cell(22,6,utf8_decode('TALLA: ' . $datos_medicos['Estatura']),1,0,);
$pdf->Cell(20,6,utf8_decode('PESO: ' . $datos_medicos['Peso']),1,0,);
$pdf->Cell(24,6,utf8_decode('C.BRAZO: ' . $datos_medicos['Circ_Braquial']),1,0,);
$pdf->Cell(25,6,utf8_decode('PANTALÓN: ' . $datos_tallas['Talla_Pantalón']),1,0,);
$pdf->Cell(21,6,utf8_decode('CAMISA: ' . $datos_tallas['Talla_Camisa']),1,0,);
$pdf->Cell(0,6,utf8_decode('ZAPATO: ' . $datos_tallas['Talla_Zapatos']),1,1,);
$pdf->Cell(38,6,utf8_decode('TIPO DE SANGRE: ' . $datos_medicos['Tipo_Sangre']),1,0,);
$pdf->Cell(0,6,utf8_decode('LATERALIDAD: ' . $datos_medicos['Lateralidad']),1,1,);
$pdf->Cell(68,6,utf8_decode('CONDICIÓN DE LA DENTADURA: ' . $datos_medicos['Cond_Dental']),1,0,);
$pdf->Cell(0,6,utf8_decode('CONDICIÓN OFTALMOLÓGICA: ' . $datos_medicos['Cond_Vista']),1,1,);
$pdf->Cell(0,6,utf8_decode('PRESENTA ALGUNA DE ESTAS CONDICIONES: ' . $datos_medicos['Impedimento_Físico'] ),1,1,);
$pdf->Cell(70,6,utf8_decode('ES ATENDIDO POR OTRA INSTITUCIÓN: ' . $Institucion ),1,0,);
$pdf->Cell(0,6,utf8_decode('CUÁL INSTITUCIÓN: ' . $datos_medicos['Institucion_Medica']),1,1,);
$pdf->Cell(65,6,utf8_decode('POSEE CARNET DE DISCAPACIDAD: ' . $carnet_dis ),1,0,);
$pdf->Cell(0,6,utf8_decode('NÚMERO DE CARNET: ' . $datos_medicos['Carnet_Discapacidad']),1,1,);


$pdf->AddPage();
$pdf->SetFont('Arial','',14);
$pdf->SetFillColor(226,239,217);
$pdf->Cell(0,20,utf8_decode('PLANILLA DEL REPRESENTANTE'),0,1,'C');
$pdf->Cell(0,6,utf8_decode('DATOS DEL REPRESENTANTE'),1,1,'C',1);
$pdf->SetFont('Arial','',9);

#PARTE DEL REPRESENTANTE

$pdf->Cell(0,6,utf8_decode('NOMBRES Y APELLIDOS DEL REPRESENTANTE: ' . $datos_representante['Primer_Nombre'] . ' ' . $datos_representante['Segundo_Nombre']. ' ' . $datos_representante['Primer_Apellido'] . ' ' . $datos_representante['Segundo_Apellido']),1,1,);
$pdf->Cell(56,6,utf8_decode('CÉDULA DE IDENTIDAD: ' . $datos_representante['Cédula']),1,0);
$pdf->Cell(17,6,utf8_decode('EDAD: ' . $edad_diff_re->format('%y')),1,1);
#CAMBIAR VARIABLE PARA LOS REPRESENTANTES
$pdf->Cell(0,6,utf8_decode('TELÉFONOS (Indique al menos tres números de tlf): ' . $telefonos_re[0]['Prefijo'] . '-' . $telefonos_re[0]['Número_Telefónico'] . '  ' . $telefonos_re[1]['Prefijo'] . '-' . $telefonos_re[1]['Número_Telefónico'] . '  ' . $telefonos_re[2]['Prefijo'] . '-' . $telefonos_re[2]['Número_Telefónico']),1,1);
$pdf->Cell(57,6,utf8_decode('FECHA DE NACIMIENTO: ' .  $datos_representante['Fecha_Nacimiento']),1,0);
$pdf->SetFont('Arial','',7);
$pdf->Cell(60,6,utf8_decode('LUGAR DE NACIMIENTO: ' . $datos_representante['Lugar_Nacimiento']),1,0);
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,6,utf8_decode('ESTADO CIVIL: ' . $datos_representante['Estado_Civil']),1,1,);
$pdf->SetFont('Arial','',7);
$pdf->Cell(100,6,utf8_decode('CORREO ELECTRÓNICO: ' . $datos_representante['Correo_Electrónico']),1,0,);
$pdf->Cell(0,6,utf8_decode('DIRECCIÓN: ' . $datos_representante['Dirección']),1,1,);
$pdf->Cell(50,6,utf8_decode('BANCO: ' . $datos_economicos['Banco']),1,0,);
$pdf->Cell(40,6,utf8_decode('TIPO DE CUENTA: ' . $datos_economicos['Tipo_Cuenta']),1,0,);
$pdf->Cell(0,6,utf8_decode('NÚMERO DE CUENTA BANCARIA: ' . $datos_economicos['Cta_Bancaria']),1,1,);

$pdf->SetFont('Arial','',14);
$pdf->Cell(0,6,utf8_decode('DATOS DEL PADRE O LA MADRE'),1,1,'C',1);
$pdf->SetFont('Arial','',9);

#DATOS DE MADRE O PADRE

$pdf->Cell(0,6,utf8_decode('NOMBRES Y APELLIDOS: ' . $padre['Primer_Nombre'] . ' ' . $padre['Segundo_Nombre'] . ' ' . $padre['Primer_Apellido'] . ' ' . $padre['Segundo_Apellido']),1,1,);
$pdf->Cell(0,6,utf8_decode('VÍNCULO CON EL ESTUDIANTE: ' . $padre['Parentezco']),1,1,);
$pdf->Cell(56,6,utf8_decode('CÉDULA DE IDENTIDAD: ' . $padre['Cédula']),1,0);
$pdf->Cell(17,6,utf8_decode('EDAD: ' . $edad_diff_pa->format('%y')),1,0);
#CAMBIAR VARIABLE PARA LOS PADRES
$pdf->SetFont('Arial','',8);
$pdf->Cell(58,6,utf8_decode('TELÉFONO PRINCIPAL: ' . $telefonos_Est[0]['Prefijo'] . '-' . $telefonos_Est[0]['Número_Telefónico']),1,0);
$pdf->Cell(0,6,utf8_decode('TELÉFONO AUXILIAR: ' . $telefonos_Est[1]['Prefijo'] . '-' . $telefonos_Est[1]['Número_Telefónico']),1,1);
$pdf->Cell(51,6,utf8_decode('FECHA DE NACIMIENTO: ' .  $padre['Fecha_Nacimiento']),1,0);
$pdf->SetFont('Arial','',7);
$pdf->Cell(60,6,utf8_decode('LUGAR DE NACIMIENTO: ' . $padre['Lugar_Nacimiento']),1,0);
$pdf->Cell(35,6,utf8_decode('ESTADO CIVIL: ' . $padre['Estado_Civil']),1,0,);
$pdf->Cell(0,6,utf8_decode('CORREO ELECTRÓNICO: ' . $padre['Correo_Electrónico']),1,1,);
$pdf->SetFont('Arial','',9);
$pdf->Cell(0,6,utf8_decode('DIRECCIÓN: ' . $padre['Dirección']),1,1,);

$pdf->SetFont('Arial','',14);
$pdf->Cell(0,6,utf8_decode('DATOS ECONÓMICOS'),1,1,'C',1);
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,6,utf8_decode('TRABAJA: ' . $tiene_empleo),1,0,);
$pdf->Cell(0,6,utf8_decode('EN QUÉ SE DESEMPEÑA: ' . $datos_laborales['Empleo']),1,1,);
$pdf->Cell(58,6,utf8_decode('TELÉFONO TRABAJO: ' . $telefonos_pa[1]['Prefijo'] . '-' . $telefonos_pa[1]['Número_Telefónico']),1,0,);
$pdf->Cell(0,6,utf8_decode('LUGAR TRABAJO: ' . $datos_laborales['Lugar_Trabajo']),1,1,);
$pdf->Cell(63,6,utf8_decode('GRADO DE INSTRUCCIÓN: ' . $datos_representante['Grado_Academico']),1,0,);
#AJUSTAR INDICE DEL TELEFONO Y VARIABLE PARA EL REPRESENTANTE
$pdf->Cell(62,6,utf8_decode('REMUNERACIÓN (Sueldos mínimos): ' . $datos_laborales['Remuneración']),1,0,);
$pdf->Cell(0,6,utf8_decode('TIPO DE REMUNERACIÓN: ' . $datos_laborales['Tipo_Remuneración']),1,1,);
$pdf->Cell(0,6,utf8_decode('TIPO DE COLABORACIÓN QUE ESTA ENTREGANDO A LA INSTITUCIÓN (Dejar en blanco):'),'L,T,R',1,'C');
$pdf->SetFont('Arial','',8);
$pdf->Multicell(0,6,utf8_decode("DESINFECTANTE: SI____ LITRO NO_____ , CLORO: SI____ LITRO NO_____, CERA: SI____ LITRO NO_____, JABÓN SI____ LITRO NO____\nLAVAPLATOS: SI____ LITRO NO_____, DESENGRASANTE SI____ LITRO  NO_____, OTRO: ____________________________________\nARTÍCULOS DE OFICINA: LÁPIZ SI____ NO_____, LAPICERO SI____ NO_____, MARCADOR SI____ NO_____ OTRO__________________\nHOJAS BLANCAS: SI_______CANT APROX NO_____, HOJAS DE RECICLAJE: SI_______CANT APROX NO ______ \nDONARÁ UTENSILIOS PARA EL COMEDOR: CUCHARILLA: SI____  NO____ LO TRAERÁ DIARIO____, TENEDOR:  SI____  NO____ LO TRAERÁ DIARIO____"),'L,R,B',0); 

$pdf->SetFont('Arial','',14);
$pdf->Cell(0,6,utf8_decode('DATOS SOCIALES'),1,1,'C',1);
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,6,utf8_decode('CONDICIONES DE LA VIVIENDA: ' . $datos_vivienda['Condiciones_Vivienda']),1,0,);
$pdf->Cell(65,6,utf8_decode('TIPO DE VIVIENDA: ' . $datos_vivienda['Tipo_Vivienda']),1,0,);
$pdf->Cell(0,6,utf8_decode('TENENCIA DE LA VIVIENDA: ' . $datos_vivienda['Tenencia_Vivienda']),1,1,);
$pdf->Cell(0,6,utf8_decode('TIENE MÁS HIJOS ESTUDIANDO DENTRO DEL PLANTEL: ' . $tienemashijos),1,1,);
$pdf->Cell(0,6,utf8_decode('ESTÁ DISPUESTO A PARTICIPAR EN EL CONSEJO EDUCATIVO DEL AÑO ' . $Inicio_Año_Escolar . '-' . $Fin_Año_Escolar . '                          SI______ NO_______'),1,1,);
$pdf->Cell(0,6,utf8_decode('ESTÁ DISPUESTO A PARTICIPAR EN EL MOVIMIENTO BOLIVARIANO DE FAMILIA                               SI______ NO_______'),1,1,);
$pdf->Cell(0,6,utf8_decode('SE COMPROMETE A PARTICIPAR EN TODAS LAS CONVOCATORIAS DEL PLANTEL                            SI______ NO_______'),1,1,);
$pdf->MultiCell(0,12,utf8_decode("QUIÉN REALIZÓ LA INSCRIPCIÓN: (solo para personal de la institución)__________________________________\nFIRMA DEL REPRESENTANTE: _____________________________________"),1,1,);

$pdf->AddPage();
$pdf->SetFont('Arial','',14);
$pdf->Ln(6);
$pdf->Cell(0,6,utf8_decode('OBSERVACIONES'),1,1,'C',1);
$pdf->SetFont('Arial','',9);
$pdf->Multicell(0,6,utf8_decode("Realice una descripción general de su representado, mencionando características en el aspecto social, físico, personal, familiar y académico que a usted le gustaria dar a  conocer a los docentes de la institución. \nSocial:\n\n\n\n\n\nFísico:\n\n\n\n\n\nPersonal:\n\n\n\n\n\nFamiliar:\n\n\n\n\n\nAcadémico:\n\n\n\n\n\n"),1,0);
$pdf->MultiCell(0,23,utf8_decode("OTRA OBSERVACIÓN:"),1,1,);



$pdf->Output();

desconectarBD($conexion);

?>