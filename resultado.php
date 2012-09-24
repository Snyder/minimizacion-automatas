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
			<?php $paso = 2; require($_SERVER['DOCUMENT_ROOT']."/minimizar/inc/menu.inc.php"); ?>
			<div id="contentarea">
				<h2>Minimización de autómatas</h2>
				<p>El objetivo de ésta página es tomar un autómata y minimizarlo mediante un 
				algoritmo que determina cuando los estados son n-distinguibles, esto es, si 
				al final de la ejecución del programa dos estados no fueron n-distinguibles, 
				entonces serán equivalentes y el autómata se minimizará.</p>
				<h4>¿Cómo insertar el autómata?</h4>
				<p>Existen tres formas de insertar el autómata:</p>
				<ul>
					<li>Formato <span style="color: #F60">CSV</span> (Comma-Separated Values).</li>
					<li>Formato <span style="color: #F60">JSON</span> (JavaScript Object Notation).</li>
					<li>Creación del autómata <span style="color: #F60">en línea</span>.</li>
		      	</ul>
			</div>

			<div id="right">
				<h2>Subir un archivo</h2>
				<p>
					<form>
						<h4>Archivo: </h4><input type="file" />
						<input type="submit" value="Subir Autómata" />
					</form>
					<p>
						<span style="color: #F60">Nota</span>: Por favor verifique que la extensión del archivo de texto 
						corresponde con el formato, esto es, si quiere subir un autómata en formato CSV el archivo debe 
						llamarse: automata1.csv
					</p>
				</p>
				<h2>Crear en línea</h2>
				<p>
					<form>
						<label>Número de Estados: </label><input size="2" type="text" name="numEst">
						<label>Número de Símbolos: </label><input size="2" type="text" name="numSim">
						<input type="submit" value="Crear Autómata" />
					</form>
				</p>
			</div>

			<div style="float:left;">
				<h2>¿Cómo usar los formatos? </h2>
		  		<p>Acontinuación se muestra como usar cada formato:</p>
				<div id="formatos">
					<dl>
						<dt>Fromato CSV</dt>
						<dd>El formato CSV se utiliza la siguiente manera:</dd>
						<dd><img src="/minimizar/imagenes/formatoCSV.png" alt="Formato CSV" title="Formato CSV" /></dd>
						<dd><span style="color: #F60">Nota</span>: si se necesita usar la coma (,) o el espacio ( ) como símbolos, deben estar entre comillas dobles.</dd>			
						<dt>Ejemplos CSV</dt>
						<dd>
						<p>
							Estado,a,b,c,Final<br />
							0,1,0,2,0<br />
							1,1,2,3,0<br />
							2,3,1,0,1<br />
							3,0,2,1,0
						</p>
						<p>
							Estado,0,1,",",x,Final<br />
							0,2,1,3,4,1<br />
							1,4,2,4,1,1<br />
							2,3,1,3,1,0<br />
							3,1,3,2,2,1<br />
							4,4,4,4,4,0
						</p>
						</dd>
					</dl>
					<dl>
						<dt>Fromato JSON</dt>
						<dd>El formato JSON se utiliza la siguiente manera:</dd>
						<dd><img src="/minimizar/imagenes/formatoJSON.png" alt="Formato JSON" title="Formato JSON" /></dd>
						<dd><span style="color: #F60">Nota</span>: Se necesita que todos los símbolos lleven comillas, así como las palabras "Estado" y "Final"</dd>			
						<dt>Ejemplos JSON</dt>
						<dd>
						<p>
							[<br />
								<span class="tab">{"Estado":0,"a":1,"b":0,"c":2,"Final":0},</span><br />
								<span class="tab">{"Estado":1,"a":1,"b":2,"c":3,"Final":0},</span><br />
								<span class="tab">{"Estado":2,"a":3,"b":1,"c":0,"Final":1},</span><br />
								<span class="tab">{"Estado":3,"a":0,"b":2,"c":1,"Final":0}</span><br />
							]
						</p>
						<p>
							[<br />
								<span class="tab">{"Estado":0,"0":2,"1":1,",":3,"x":4,"Final":1},</span><br />
								<span class="tab">{"Estado":1,"0":4,"1":2,",":4,"x":1,"Final":1},</span><br />
								<span class="tab">{"Estado":2,"0":3,"1":1,",":3,"x":1,"Final":0},</span><br />
								<span class="tab">{"Estado":3,"0":1,"1":3,",":2,"x":2,"Final":1},</span><br />
								<span class="tab">{"Estado":4,"0":4,"1":4,",":4,"x":4,"Final":0}</span><br />
							]
						</p>
						</dd>
					</dl>
					<dl>
						<dt>En línea</dt>
						<dd>Para crear el autómata en línea haga clic en Crear Autómata y siga las instrucciones.</dd>
					</dl>
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