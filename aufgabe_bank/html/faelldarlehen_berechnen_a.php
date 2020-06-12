<html>
<meta charset="utf-8">
<head>
<title>Fälligkeitsdarlehen</title>
</head>
<body>
<div class="wrapper">
<link rel="stylesheet" href="../formate.css" />
	<!--Kopf der Seite-->
	<div class="head">
	<h1>SupraBank</h1>
	<h2>Fälligkeitsdarlehen</h2>
	</div>
	
		<div class="logo">
			<p><img src="../img/logo1.jpg" alt="logo"></p>
		</div>
			
		<div class="print">
			<h3>Suprabank GmbH</h3>
			<p>An der Lehmgrube 11<br/>
			07751 Jena<br/>
			Vertreten durch Geschäftsführer<br/>
			Matthias Meyer<br/>
			Email: suprabank@suprabank.de<br/>
			Tel.: +49 3641-23 28 100<br/>
			Fax.: +49 3641-23 28 109<br/><br/><br/></p>
		</div>
			
		<div class="table_u">
			<h4>Übersicht der Zinsen sowie der Gesmmtbelastung nach ender der Laufzeit<br/><br/></h4>
		</div>
	
	<!--Menu der Seite ( Weitere Einträge folgen )-->
	<div class="menu">
		<ul>
			<li><a href="../index.html">Startseite</a></li>
			<li><a href="anndarlehen.html">Annuitäten-<br/>darlehen</a></li>
			<li><a href='tilldarlehen.html'>Tillguns-<br/>darlehen</a></li>
			<li><a href='faelldarlehen.html'>Zurück zur <br/>Eingabe</a></li>
		</ul>
	</div>
<?php
if(($_POST["betrag"]>0) && ($_POST["zin"]>0))
{
	$betrag = $_POST["betrag"];    	//Darlehensbetarg
	$zin = $_POST["zin"];			//Zinssatz
	$lz = $_POST["zeit"];			//Laufzeit in Jahren
	$ie = ($zin/100);				//Zinsen durch 100
	$zing = 0;						//Hilfsvariable zum ausrechnen der Gesammtzinsen
	$a = $_POST["monat"];			//Monat
	$b = 0;							//Hilfsvariable für die Anzeige der Laufzeit in Monaten
	$c = ($_POST["jahr"] + 1);		//Jahr
	$zinz = $betrag * $ie;
	echo "<div class='erg' id='faell'>";
	echo "<table border='1'>";
	echo "<tr align='center'>";
	echo "<td><b>Datum</b></td>";
	echo "<td><b>Schuld A. d. J.</b></td>";
	echo "<td><b>Zinssatz</b></td>";
	echo "<td><b>Zinsanteil</b></td>";
	echo "<td><b>Schuld E. d. J.</b></td>";
	echo "</tr>";
	
	
	for($jahre=0; $jahre<$lz; $jahre++)
	{
		$zinj = $betrag * $ie;
		
		echo "<tr align='center'>";
		echo "<td>$c / $a</td>";
		echo "<td>" . ($betrag + $zing)  . "</td>";
		
		$zing = $zing + $zinj;
		
		echo "<td>" . $zin . "</td>";
		echo "<td>" . $zinz . "</td>";
		echo "<td>" . ($betrag + $zing) . "</td>";
		echo "</tr>";
		$c = $c + 1;
	}
	echo "</table>";
}
else
{
	echo "Es fehlen Angaben zum Fälligkeitsdarlehen";
}

?>
<link rel="stylesheet" href="print.css" media="print" /> 
</div>
</body>
</html>