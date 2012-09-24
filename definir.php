<?php 

if(!is_numeric($_POST['numEst']) || !is_numeric($_POST['numSim'])) {
	die("No cargue esta pagina directamente");
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title>Minimización de autómatas</title>
		<link href="/minimizar/css/stylizr.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
		<?php require($_SERVER['DOCUMENT_ROOT']."/minimizar/inc/header.inc.php"); ?>
		<div id="content">
			<?php $paso = 1; require($_SERVER['DOCUMENT_ROOT']."/minimizar/inc/menu.inc.php"); ?>
			<div id="contentarea" style="width: auto;">
				<h2>Definición del autómata</h2>
				<p>Acontinuación ingrese los símbolos en la tabla y las transiciones de los estados, así
				como si los estados son finales o no.</p>
				<div id="formatos">
					<dl>
						<dt>Ejemplo de llenado de tabla</dt>
						<dd>El llenado de la tabla es como se muestra a continuación:</dd>
						<dd>
							<table id="ejemplo">
							<thead>
								<tr>
									<th>Estado</th>
									<th><input type="text" size="1" value="a"></th>
									<th><input type="text" size="1" value="b"></th>
									<th><input type="text" size="1" value="c"></th>
									<th>Final</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td><input type="text" size="1" value="0"></td>
									<td><input type="text" size="1" value="2"></td>
									<td><input type="text" size="1" value="0"></td>
									<td><input type="text" size="1" value="1"></td>
									<td><input type="text" size="1" value="0"></td>
								</tr>
								<tr>
									<td><input type="text" size="1" value="1"></td>
									<td><input type="text" size="1" value="1"></td>
									<td><input type="text" size="1" value="2"></td>
									<td><input type="text" size="1" value="0"></td>
									<td><input type="text" size="1" value="1"></td>
								</tr>
								<tr>
									<td><input type="text" size="1" value="2"></td>
									<td><input type="text" size="1" value="2"></td>
									<td><input type="text" size="1" value="2"></td>
									<td><input type="text" size="1" value="2"></td>
									<td><input type="text" size="1" value="0"></td>
								</tr>
							</tbody>
						</table>
						</dd>
						<dd>Esto, para un autómata con la siguiente tabla de transiciones:</dd>
						<dd><img src="/minimizar/imagenes/formatoOnline.png" alt="Formato en línea" title="Formato en línea" /></dd>
					</dl>
				</div>
				<div style="margint-left auto; margin-right: auto;">
					<form method="POST" action="/minimizar/minimizar.php">
						<input type="hidden" name="numEst" value="<?= $_POST['numEst'] ?>" />
						<input type="hidden" name="numSim" value="<?= $_POST['numSim'] ?>" />
						<table>
							<thead>
								<tr>
									<th>Estado</th>
									<?php for ($i=0; $i < $_POST['numSim']; $i++) { ?>
										<th><input type="text" size="1" name="sim_<?= $i ?>"></th>
									<?php } ?>
									<th>Final</th>
								</tr>
							</thead>
							<tbody>
								<?php for ($i=0; $i < $_POST['numEst']; $i++) { ?>
									<tr>
										<td><input type="text" size="1" name="nombreEst_<?= $i ?>"></td>
											<?php for ($j=0; $j < $_POST['numSim']; $j++) { ?>
												<td><input type="text" size="1" name="transEdo_<?= $i ?>Sim_<?= $j ?>"></td>
											<?php } ?>
										<td><input type="text" size="1" name="finalEst_<?= $i ?>"></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
						<br />
						<input type="submit" value="Minimizar Autómata" />
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
		</script>
	</body>
</html>