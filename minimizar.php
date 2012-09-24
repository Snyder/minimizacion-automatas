<?php
if(!is_uploaded_file($_FILES['automata']['tmp_name']) && empty($_POST)){
	die("No cargue esta pagina directamente.");
}

function arreglosIguales($arreglo1, $arreglo2) {
  return !array_diff($arreglo1, $arreglo2) && !array_diff($arreglo2, $arreglo1);
}

function getSimbolos($automata) {
	$res = array();
	foreach ($automata[0] as $simbolo => $info) {
		$simbolo .= '';
		if($simbolo == 'Estado' || $simbolo == 'Final'){ 
			continue;
		}
		$res[] = $simbolo;
	}
	return $res;
}

function getEstados($automata) {
	$res = array();
	foreach ($automata as $value) {
		$res[] = $value['Estado'];
	}
	return $res;
}

function getAlcanzables($automata) {
	$nuevos = array();
	$res = array();
	$alcanzables = array();

	$estados = getEstados($automata);
	$alcanzables[] = $estados[0];

	while(!arreglosIguales($alcanzables, $nuevos)){

		$nuevos = array_values($alcanzables);
		
		foreach ($automata as $estado) {
			if(in_array($estado['Estado'], $alcanzables)){
				foreach ($estado as $key => $value) {
					$key .= '';
					if($key == 'Estado' || $key == 'Final'){ 
						continue;
					}
					
					if(!in_array($value, $alcanzables)){
						$alcanzables[] = $value;
					}
				}
			}
		}
	}

	foreach ($automata as $estado) {
		if(in_array($estado['Estado'], $alcanzables)){
			$res[] = $estado;
		}
	}

	return $res;
}

function recorreMatriz($matriz) {
	$res = '';
	foreach ($matriz as $columna) {
		foreach ($columna as $casilla) {
			$res .= $casilla;
		}
	}
	return $res;
}

function getTransiciones($estado) {
	$res = array();
	foreach ($estado as $sim => $sigEdo) {
		$sim .= '';
		if($sim == 'Estado' || $sim == 'Final') continue;
		$res[$sim] = $sigEdo;
	}
	return $res;
}

function getIndex($nombreEst, $automata){
	foreach ($automata as $index => $estado) {
		if($estado['Estado'] == $nombreEst){
			return $index;
		}
	}
}

function distinguibles($index1, $index2, $matriz, $automata) {
	$simbolos = getSimbolos($automata);
	$estados = array_flip(getEstados($automata));

	$transiciones1 = getTransiciones($automata[$index1]);
	$transiciones2 = getTransiciones($automata[$index2]);
	
	foreach ($simbolos as $simbolo) {
		$i = $estados[$transiciones1[$simbolo]];
		$j = $estados[$transiciones2[$simbolo]];

		if($i > $j){
			$temp = $i;
			$i = $j;
			$j = $temp;
		} elseif($i == $j){
			contine;
		}

		if($matriz[$i][$j] == 'd'){
			return TRUE;
		}
	}
}

function minimiza($automata){
	$automata = getAlcanzables($automata);
	$estados = getEstados($automata);
	$matriz = array(array());

	for ($i=0; $i < (count($estados) - 1); $i++) { 
		for ($j=($i+1); $j < (count($estados)); $j++) {
			$matriz[$i][$j] = 'e';
		}
	}

	foreach ($matriz as $i => $columna) {
		$esFinal = $automata[$i]['Final'];
		foreach ($automata as $j => $estado) {
			if($esFinal != $estado['Final']){
				if($i < $j){
					$matriz[$i][$j] = 'd';
				}
			}
		}
	}

	$cadDeMat = '';
	$cadDeMatN = recorreMatriz($matriz);

	while ($cadDeMat != $cadDeMatN) {
		$cadDeMat = $cadDeMatN;
		foreach ($matriz as $i => $columna) {
			foreach ($columna as $j => $casilla) {
				if(distinguibles($i, $j, $matriz, $automata)){
					$matriz[$i][$j] = 'd';
				}
			}
		}

		$cadDeMatN = recorreMatriz($matriz);
	}

	$bloques = array();

	foreach ($matriz as $i => $columna) {
		if(!in_array($i, $bloques) && !array_key_exists($i, $bloques)) {
			$bloques[$i] = $i;
			foreach ($columna as $j => $casilla) {

				if(array_key_exists($j, $bloques)) continue;

				if($matriz[$i][$j] == 'e') {
					$bloques[$j] = $i;
				}
			}
		}
	}

	$estadosPorIndice = getEstados($automata);
	$estadosPorNombre = array_flip($estadosPorIndice);

	foreach ($automata as $index => $estado) {
		foreach ($estado as $sim => $sigEdo) {
			$sim .= '';
			if($sim == 'Estado' || $sim == 'Final') continue;
			$automata[$index][$sim] = $estadosPorIndice[$bloques[$estadosPorNombre[$sigEdo]]]; 
		}
	}

	$res = array();
	$bloques = array_reverse(array_flip(array_reverse($bloques, TRUE)), TRUE);


	foreach ($bloques as $indice) {
		$res[] = $automata[$indice];
	}

	return $res;
}

if(is_numeric($_POST['numEst']) && is_numeric($_POST['numSim'])) {
	$numEst = $_POST['numEst'];
	$numSim = $_POST['numSim'];

	for ($i=0; $i < $numEst; $i++) {
		$automata[$i] = array();
		$automata[$i]['Estado'] = $_POST['nombreEst_'.$i];
		for ($j=0; $j < $numSim; $j++) {
			$automata[$i][$_POST['sim_'.$j]] = $_POST['transEdo_'.$i.'Sim_'.$j];
		}
		$automata[$i]['Final'] = $_POST['finalEst_'.$i];
	}
} elseif (is_uploaded_file($_FILES['automata']['tmp_name'])) {
	$ext = strtolower(end(explode('.', $_FILES['automata']['name'])));
	$contenido = file_get_contents($_FILES['automata']['tmp_name']);
	if($ext == 'csv') {
		$header = null; 
	    $automata = array(); 
	    $datosCSV = str_getcsv($contenido, "\n"); 
	    foreach($datosCSV as $lineaCSV) {
	        if(is_null($header)){
	        	$header = explode(',', $lineaCSV);
	     	} else {	            
	            $items = explode(',', $lineaCSV); 
	            for($i = 0; $i < count($header); $i++){
	                $actual[$header[$i]] = $items[$i];
	            } 
	            
	            $automata[] = $actual; 
	        } 
	    }
	    $numEst = count($automata);
	    $numSim = count($automata[0]) - 2;
	} elseif ($ext == 'json') {
		$automata = json_decode($contenido, TRUE);
		$numEst = count($automata);
	    $numSim = count($automata[0]) - 2;
	} else {
		header('Location: http://3nyder.com/minimizacion/index.php?error=archivo');
		exit;
	}
} else {
	die("Ocurrió un error, inténtelo de nuevo.");
}


function escupe($automata){
	echo '<pre style="margin-top: 100px;float: left;width: 400px;">';
	print_r($automata);
	echo '</pre>';
}

$simbolos = getSimbolos($automata);
$automataMin = minimiza($automata);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Minimización de autómatas</title>
		<link href="/minimizar/css/stylizr.css" rel="stylesheet" type="text/css" />
		<style type="text/css">
		table th, td{
			width: 55px;
			text-align: center;
		}
		</style>
	</head>
	<body>
		<?php require($_SERVER['DOCUMENT_ROOT']."/minimizar/inc/header.inc.php"); ?>
		<div id="content">
			<?php $paso = 2; require($_SERVER['DOCUMENT_ROOT']."/minimizar/inc/menu.inc.php"); ?>
			<div id="contentarea" style="width: auto;">
				<h2>Resultado de la minimización</h2>
				<p>Si lo desea también puede descargar el archivo en formato <a id="downCSV" href="#">CSV</a> o <a id="downJSON" href="#">JSON</a>.</p>

				<div style="margint-left auto; margin-right: auto;">
					<form id="automata" method="POST" action="/minimizar/archivo.php">
						<input type="hidden" name="numEst" value="<?= count(getEstados($automataMin)) ?>" />
						<input type="hidden" name="numSim" value="<?= $_POST['numSim'] ?>" />
						<input type="hidden" name="tipo" /> 
						<table>
							<thead>
								<tr>
									<th>Estado</th>
									<?php $i = 0; 
									foreach ($simbolos as $simbolo) { ?>
										<th><input type="hidden" name="sim_<?= $i ?>" value="<?= $simbolo ?>"><?= $simbolo ?></th>
									<?php $i++; } ?>
									<th>Final</th>
								</tr>
							</thead>
							<tbody>
								<?php $i = 0;
								foreach ($automataMin as $estado) { ?>
									<tr>
										<td><input type="hidden" name="nombreEst_<?= $i ?>" value="<?= $estado['Estado'] ?>"><?= $estado['Estado'] ?></td>
											<?php $j = 0;
											foreach ($estado as $sim => $sigEdo) {
												$sim .= '';
												if($sim == 'Estado' || $sim == 'Final') continue; ?>
												<td><input type="hidden" name="transEdo_<?= $i ?>Sim_<?= $j ?>" value="<?= $sigEdo ?>"><?= $sigEdo ?></td>
											<?php $j++; } ?>
										<td><input type="hidden" name="finalEst_<?= $i ?>" value="<?= $estado['Final'] ?>"><?= $estado['Final'] ?></td>
									</tr>
								<?php $i++; } ?>
							</tbody>
						</table>
						<br />
					</form>
				</div>

			</div>
			  
		</div><!-- content -->

		<?php require($_SERVER['DOCUMENT_ROOT']."/minimizar/inc/footer.inc.php"); ?>
		<script type="text/javascript" src="/minimizar/js/jquery-1.8.2.min.js"></script>
		<script type="text/javascript">
			$('dt').click(function(e){
			    $(this).nextUntil('dt').toggle();
			});

			$('dd').hide();

			$('#downCSV').click(function(){
				$('input[name="tipo"]').val('csv');
				document.forms["automata"].submit();
			});

			$('#downJSON').click(function(){
				$('input[name="tipo"]').val('json');
				document.forms["automata"].submit();

			});
		</script>
	</body>
</html>