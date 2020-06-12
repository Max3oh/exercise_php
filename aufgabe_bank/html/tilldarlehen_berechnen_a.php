<html>
<meta charset="utf-8">
<head>
<title>Tillgungsdarlehen</title>
</head>
<body>
<div class="wrapper">
<link rel="stylesheet" href="../formate.css" />
	<!--Kopf der Seite-->
	<div class="head">
	<h1>SupraBank</h1>
	<h2>Tillgungsdarlehen</h2>
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
			<h4>Übersicht der monatlichen Rate, der Zinsen sowie des Tilgungsanteils<br/><br/></h4>
		</div>
	
	<!--Menu der Seite ( Weitere Einträge folgen )-->
	<div class="menu">
		<ul>
			<li><a href="../index.html">Startseite</a></li><br/>
			<li><a href="anndarlehen.html">Annuitäten-<br/>darlehen</a></li>
			<li><a href="faelldarlehen.html">Fälligkeits-<br/>darlehen</a></li>
			<li><a href='tilldarlehen.html'>Zurück zur <br/>Eingabe</a></li>
		</ul>
	</div>
<?php
	if(($_POST["betrag"]>0) && ($_POST["zin"]>0))
	{
		$betrag = $_POST["betrag"];    	//Darlehensbetarg
		$zin = $_POST["zin"];			//Zinssatz
		$ie = ($zin/100);				//Zinsen durch 100
		$zing = 0;						//Hilfsvariable zum ausrechnen der Gesammtzinsen
		$a = $_POST["monat"];			//Monat
		$b = 0;							//Hilfsvariable für die Anzeige der Laufzeit in Monaten
		$c = ($_POST["jahr"] + 1);		//Jahr
		$mrga = 0;						//Hilfsvariable für gesammtsumme aller monatlichen Raten
		$mrta = 0;						//Hilfsvariable für gesammtsumme aller monatlichen Tillgungsraten
		$restVM = $betrag;
		
		if(isset($_POST["wie"]))
		{	
			if($_POST["wie"]=="zeit")
			{
			$zr = $_POST["zr"];			//Zeitraum bis Ende der Tilgung (monatliche Annuität muss berechnet werden)
			}
			else if($_POST["wie"]=="mrate")
			{
			$mr = $_POST["mr"];			//Monatliche Rate -> Muss größer gleich erster Zinssatzzahlung sein (Zeit bis Abbezahlt muss berechnet werden)
			}
			
			echo "<div class='erg' id='till'>";
			echo "<table border='1'>";
			echo "<thead>";
			echo "<tr align='center' width=20%>";
			echo "<td><b>Datum</b></td>";
			echo "<td><b>Schuld Vormonat</b></td>";
			echo "<td><b>Zinssatz</b></td>";
			echo "<td><b>Rate</b></td>";
			echo "<td><b>Zinsanteil</b></td>";
			echo "<td><b>Tilgungsanteil</b></td>";
			echo "<td><b>Schuld E. d. M.</b></td>";
			echo "</tr>";
			echo "</thead>";
			
			//******************************************************************************* Wenn der Zeitraum gegeben ist wird folgendes Ausgeführt *****************************************************************************
			if(isset($zr))
			{				
				$mrt = ($betrag / $zr)/12;
				$lzm = ($zr * 12) ;
				
				echo "<tr align='center'>";
				echo "<td>$c / $a</td>";
				echo "<td>-</td>";
				echo "<td>-</td>";
				echo "<td>-</td>";
				echo "<td>-</td>";
				echo "<td>-</td>";
				echo "<td>" . number_format($betrag,2,",",".") . "&euro;</td>";
				echo "</tr>";
				
				for($rests=$betrag; $rests>0.0001; $rests=$rests-$mrt)
				{
					$b = $b+1;
					$zinz = ($rests * $ie)/12;
					$mrg = $mrt + $zinz;
					$zing = $zing + $zinz;
					
					$a = $a + 1;
					
					if($a>12)
					{
						$a = 1;
						$c = $c + 1;
					}
					if($a<10)
						$a = "0" . $a;
					
					echo "<tr align='center'>";
					echo "<td>$c / $a</td>";
					echo "<td>" . number_format($rests,2,",",".") . "&euro;</td>";
					echo "<td>" . number_format($zin,2,",",".") . "%</td>";
					echo "<td>" . number_format($mrg,2,",",".") . "&euro;</td>";
					echo "<td>" . number_format($zinz,2,",",".") . "&euro;</td>";
					echo "<td>" . number_format($mrt,2,",",".") . "&euro;</td>";
					echo "<td>" . number_format(($rests - $mrt),2,",",".") . "&euro;</td>";
					echo "</tr>";
					
					$mrta = $mrta + $mrt;
					$mrga = $mrga + $mrg;
				}
				echo "<tr align='center'>";
				echo "<td>SUMMEN:</td>";
				echo "<td>" . number_format($betrag,2,",",".") . "&euro;</td>";
				echo "<td>" . number_format($zin,2,",",".") . "%</td>";
				echo "<td>" . number_format($mrga,2,",",".") . "&euro;</td>";
				echo "<td>" . number_format($zing,2,",",".") . "&euro;</td>";
				echo "<td>" . number_format($mrta,2,",",".") . "&euro;</td>";
				echo "<td>" . number_format($rests,2,",",".") . "&euro;</td>";
				echo "</tr>";
				echo "</table>";
			}
			else if( (!isset($zr)) && (!isset($mr)) )
			{
				echo "Es Fehlen Angaben zum Tillgungsdarlehen!";
				echo "<br/><a href='tilldarlehen.html' >Zurück</a>";
			}
			//*************************************************************************** Wenn die Monatliche Rate gegeben ist wird folgendes Ausgeführt ***************************************************************************
			if(isset($mr))
			{
				$zr = $betrag/$mr;
				$rests = $betrag;
				

				echo "<tr align='center'>";
				echo "<td>$c / $a</td>";
				echo "<td>-</td>";
				echo "<td>-</td>";
				echo "<td>-</td>";
				echo "<td>-</td>";
				echo "<td>-</td>";
				echo "<td>" . number_format($betrag,2,",",".") . "&euro;</td>";
				echo "</tr>";
			
				for($dauer=0; $dauer<$zr; $dauer++)
				{
					$restVM = $rests;
					$zinz = ($rests * $ie)/12;
					$rests = $rests - $mr ;
					$zing = $zing + $zinz;
						
					if($mr>$restVM)
					{
						$mr = $restVM;
						$rests = $restVM - $mr;
					}
					
					$mrg = $mr + $zinz;
					$mrga = $mrga + $mrg;
					$mrta = $mrta + $mr;
					$a = $a + 1;
					
					if($a>12)
					{
						$a = 1;
						$c = $c + 1;
					}
					
					if($a<10)
						$a = "0" . $a;
					
					echo "<tr align='center'>";
					echo "<td>$c / $a</td>";
					echo "<td>" . number_format($restVM,2,",",".") . "&euro;</td>";
					echo "<td>" . number_format($zin,2,",",".") . "%</td>";
					echo "<td>" . number_format($mrg,2,",",".") . "&euro;</td>";
					echo "<td>" . number_format($zinz,2,",",".") . "&euro;</td>";
					echo "<td>" . number_format($mr,2,",",".") . "&euro;</td>";
					echo "<td>" . number_format(($rests),2,",",".") . "&euro;</td>";
					echo "</tr>";
				}
				echo "<tr align='center'>";
				echo "<td>SUMMEN:</td>";
				echo "<td>-</td>";
				echo "<td>-</td>";
				echo "<td>" . number_format(($mrga),2,",",".") . "&euro;</td>";
				echo "<td>" . number_format($zing,2,",",".") . "&euro;</td>";
				echo "<td>" . number_format($mrta,2,",",".") . "&euro;</td>";
				echo "<td>-</td>";
				echo "</tr>";
				echo "</table>";
			}
			else if( (!isset($zr)) && (!isset($mr)) )
			{
				echo "Es fehlen angaben zum Tillgungsdarlehen!";
				echo "<br/><a href='tilldarlehen.html' >Zurück</a>";
			}
		}
		else if (!isset($_POST["wie"]))
		{
			echo "Es fehlen angaben zum Tillgungsdarlehen!";
			echo "<br/><a href='tilldarlehen.html'>Zurück</a>";
		}
		echo "</div>";
		
	}
	else
	{
		echo "Es fehlen angaben zum Tillgungsdarlehen!";
		echo "<br/><a href='tilldarlehen.html'>Zurück</a>";
	}
	
?>
	<link rel="stylesheet" href="print.css" media="print" />
</div>
</body>
</html>