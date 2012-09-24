<?php
	$paso = empty($paso) ? 0 : $paso;
?>

<div id="menu">
	<ul>
		<li <?= ($paso == 0) ? 'class="selected"' : '' ?> ><span>Inicio</span></li>
		<li <?= ($paso == 1) ? 'class="selected"' : '' ?> ><span>Definición del autómata</span></li>
		<li <?= ($paso == 2) ? 'class="selected"' : '' ?> ><span>Resultado y Descarga</span></li>
	</ul>
</div>