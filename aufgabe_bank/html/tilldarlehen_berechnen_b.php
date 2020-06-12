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
	
	<!--Menu der Seite ( Weitere Einträge folgen )-->
	<div class="menu">
		<ul>
			<li><a href="../index.html">Startseite</a></li>
			<li><a href="anndarlehen.html">Annuitäten-<br/>darlehen</a></li>
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
		$c = ($_POST["jahr"] + 1);			//Jahr
		$mrga = 0;						//Hilfsvariable für gesammtsumme aller monatlichen Raten
		$mrta = 0;						//Hilfsvariable für gesammtsumme aller monatlichen Tillgungsraten
		$restVM = $betrag;
		

		echo "<div class='erg'>";
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
				echo "<td>" . number_format($betrag,2,",",".") . "</td>";
				echo "</tr>";
				
				for($rests=$betrag; $rests>=0; $rests=$rests-$mrt)
				{
					$b = $b+1;
					$zinz = ($rests * $ie)/12;
					$mrg = $mrt + $zinz;
					$zing = $zing + $zinz;
					
					/* echo "<br/>$b<br/>";
					echo "<br/>Rests $rests<br/>";
					echo "<br/>$zin<br/>";
					echo "<br/>Zinz $zinz<br/>";
					echo "<br/>TillRate $mrt<br/>";
					echo "<br/>GesamtRate $mrg<br/>";
					echo "<br/><br/><br/><br/>"; */
					
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
					echo "<td>" . number_format($rests,2,",",".") . "</td>";
					echo "<td>" . number_format($zin,2,",",".") . "</td>";
					echo "<td>" . number_format($mrg,2,",",".") . "</td>";
					echo "<td>" . number_format($zinz,2,",",".") . "</td>";
					echo "<td>" . number_format($mrt,2,",",".") . "</td>";
					echo "<td>" . number_format(($rests - $mrt),2,",",".") . "</td>";
					echo "</tr>";
					
					$mrta = $mrta + $mrt;
					$mrga = $mrga + $mrg;
				}
				echo "<tfoot>";
				echo "<tr align='center'>";
				echo "<td>SUMMEN:</td>";
				echo "<td>" . number_format($betrag,2,",",".") . "</td>";
				echo "<td>" . number_format($zin,2,",",".") . "</td>";
				echo "<td>" . number_format($mrga,2,",",".") . "</td>";
				echo "<td>" . number_format($zing,2,",",".") . "</td>";
				echo "<td>" . number_format($mrta,2,",",".") . "</td>";
				echo "<td>" . number_format($rests,2,",",".") . "</td>";
				echo "</tr>";
				echo "</tfoot>";
				echo "</table>";
				echo "Zinszahlung = " . number_format($zing,2,",",".");
			}
			else
			{
				echo "";
			}
			//*************************************************************************** Wenn die Monatliche Rate gegeben ist wird folgendes Ausgeführt ***************************************************************************
			if(isset($mr))
			{
				$zr = $betrag/$mr;
				$rests = $betrag;
				$zinz1 = ($rests * $ie)/12;
				$mrg = $mr + $zinz1;
				/* echo $zr; */
				echo "<tr align='center'>";
				echo "<td>$c / $a</td>";
				echo "<td>-</td>";
				echo "<td>-</td>";
				echo "<td>-</td>";
				echo "<td>-</td>";
				echo "<td>-</td>";
				echo "<td>" . number_format($betrag,2,",",".") . "</td>";
				echo "</tr>";
				
				/* echo "<br/>$b<br/>";
				echo "<br/>Rests" . $rests . "<br/>";
				echo "<br/>$zin<br/>";
				echo "<br/>Zinz $zinz<br/>";
				echo "<br/>TillRate $mr<br/>";
				echo "<br/>GesamtRate $mrg<br/>";
				echo "<br/><br/><br/><br/>"; */
				
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
				echo "<td>" . number_format($rests,2,",",".") . "</td>";
				echo "<td>" . number_format($zin,2,",",".") . "</td>";
				echo "<td>" . number_format($mrg ,2,",",".") . "</td>";
				echo "<td>" . number_format($zinz1,2,",",".") . "</td>";
				echo "<td>" . number_format($mr,2,",",".") . "</td>";
				echo "<td>" . number_format(($rests - $mr),2,",",".") . "</td>";
				echo "</tr>";
				
				for($dauer=1; $dauer<$zr; $dauer++)
				{
					
					$rests = $rests - $mr;
					$zinz = ($rests * $ie)/12;
					$b = $b+1;
					$mrg = $mr + $zinz;
					$mrga = $mrga + $mrg;
					$mrta = $mrta + $mr;
					
					if($mr>$rests)
					{
						$mr = $rests;
						$zinz = ($rests * $ie)/12;
						$mrg = $rests + $zinz;
					}
					
					/* echo "<br/>$b<br/>";
					echo "<br/>Rests" . $rests . "<br/>";
					echo "<br/>$zin<br/>";
					echo "<br/>Zinz $zinz<br/>";
					echo "<br/>TillRate $mr<br/>";
					echo "<br/>GesamtRate $mrg<br/>";
					echo "<br/><br/><br/><br/>"; */ 
					
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
					echo "<td>" . number_format($rests,2,",",".") . "</td>";
					echo "<td>" . number_format($zin,2,",",".") . "</td>";
					echo "<td>" . number_format($mrg,2,",",".") . "</td>";
					echo "<td>" . number_format($zinz,2,",",".") . "</td>";
					echo "<td>" . number_format($mr,2,",",".") . "</td>";
					echo "<td>" . number_format(($rests - $mr),2,",",".") . "</td>";
					echo "</tr>";
				}
				echo "<tfoot>";
				echo "<tr align='center'>";
				echo "<td>SUMMEN:</td>";
				echo "<td>" . number_format($betrag,2,",",".") . "</td>";
				echo "<td>" . number_format($zin,2,",",".") . "</td>";
				echo "<td>" . number_format(($mrga + $zinz1),2,",",".") . "</td>";
				echo "<td>" . number_format($zing,2,",",".") . "</td>";
				echo "<td>" . number_format($mrta,2,",",".") . "</td>";
				echo "<td>" . number_format($rests,2,",",".") . "</td>";
				echo "</tr>";
				echo "</tfoot>";
				echo "</table>";
				echo "Zinszahlung = " . number_format($zing,2,",",".");
			}
			
		}
		
		
	}
	
?>
	<link rel="stylesheet" href="print.css" media="print" />
</div>
</body>
</html>