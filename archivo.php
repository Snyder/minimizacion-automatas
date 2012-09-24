<?php
if(is_numeric($_POST['numEst']) && is_numeric($_POST['numSim'])) {
	$automata = array();
	if($_POST['tipo'] == 'csv'){
		$header = array();
		$header[] = 'Estado';
		for ($j=0; $j < $_POST['numSim']; $j++) {
			$header[] = $_POST['sim_'.$j];
		}
		$header[] = 'Final';
		$automata['header'] = $header;
	}
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
} else {
	die("No cargue esta pagina directamente");
}

if($_POST['tipo'] == 'csv'){
	header("Content-type: text/csv");
	header("Content-Disposition: attachment; filename=automata.csv");
	header("Pragma: no-cache");
	header("Expires: 0");
	outputCSV($automata);

} elseif ($_POST['tipo'] == 'json') {
	header('Content-type: application/json');
	header("Content-Disposition: attachment; filename=automata.json");
	header("Pragma: no-cache");
	header("Expires: 0");
	echo json_encode($automata);
} else {
	die("No cargue esta pagina directamente");
}



function outputCSV($data) {
    $outstream = fopen("php://output", "w");
    function __outputCSV(&$vals, $key, $filehandler) {
        fputcsv($filehandler, $vals);
    }
    array_walk($data, "__outputCSV", $outstream);
    fclose($outstream);
}
?>