<?php
function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}


?>
<html>
<head>
	<title>Hello world!</title>
	<link href='//fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
	<meta http-equiv="refresh" content="5">
	<style>
	body {
		background-color: #<?=random_color();?>;
		text-align: center;
		padding: 50px;
		font-family: "Open Sans","Helvetica Neue",Helvetica,Arial,sans-serif;
	}

	#logo {
		margin-bottom: 40px;
	}
	</style>
</head>
<body>
	<img id="logo" src="logo.png" />
	<h1><?php echo "Hello ".($_ENV["NAME"]?$_ENV["NAME"]:"world")."!"; ?></h1>
	<?php if($_ENV["HOSTNAME"]) {?><h3>My hostname is <?php echo $_ENV["HOSTNAME"]; ?></h3><?php } ?>
	<?php
	$links = [];
	foreach($_ENV as $key => $value) {
		if(preg_match("/^(.*)_PORT_([0-9]*)_(TCP|UDP)$/", $key, $matches)) {
			$links[] = [
				"name" => $matches[1],
				"port" => $matches[2],
				"proto" => $matches[3],
				"value" => $value
			];
		}
	}
	if($links) {
	?>
		<h3>Links found</h3>
		<?php
		foreach($links as $link) {
			?>
			<b><?php echo $link["name"]; ?></b> listening in <?php echo $link["port"]+"/"+$link["proto"]; ?> available at <?php echo $link["value"]; ?><br />
			<?php
		}
		?>
	<?php
	}

	if($_ENV["DOCKERCLOUD_AUTH"]) {
		?>
		<h3>I have Docker Cloud API powers!</h3>
		<?php
	}
	?>
</body>
</html>
