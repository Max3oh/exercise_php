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
		$ie = ($zin/100);
		$zing = 0;
		$a = $_POST["monat"];			//Monat
		$b = 1;							//Für die Anzeige der Laufzeit in Monaten
		$c = $_POST["jahr"];			//Jahr

		echo "<div class='erg'>";
		echo "<table border='1'>";
		echo "<thead>";
		echo "<tr align='center' width=20%>";
		echo "<td><b>Datum</b></td>";
		echo "<td><b>Schuld Vormonat</b></td>";
		echo "<td><b>Zinssatz</b></td>";
		echo "<td><b>Rate</b></td>";
		echo "<td><b>Zinszahlung</b></td>";
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
				echo "<tr align='center'>";
				echo "<td>$b</td>";
				echo "<td>-</td>";
				echo "<td>-</td>";
				echo "<td>-</td>";
				echo "<td>-</td>";
				echo "<td>-</td>";
				echo "<td>" . number_format($betrag,2,",",".") . "</td>";
				echo "</tr>";
				
				$mr = $betrag / ($zr*12);
				$zinz1 = ($betrag * $ie)/12;
				$b = $b+1;
				$lzm = ($zr * 12) + 1;
				$rests1 = $betrag + $zinz1 - $mr;
				$rate = $mr + $zinz1;
				echo "<tr align='center'>";
				echo "<td>$b</td>";
				echo "<td>" . number_format($betrag+$zinz1,2,",",".") . "</td>";
				echo "<td>" . number_format($zin,2,",",".") . "</td>";
				echo "<td>" . number_format($rate,2,",",".") . "</td>";
				echo "<td>" . number_format($zinz1,2,",",".") . "</td>";
				echo "<td>" . number_format($mr,2,",",".") ."</td>";
				echo "<td>" . number_format(($rests1-$zinz1),2,",",".") . "</td>";
				echo "</tr>";
				
				for($rests=$rests1; $rests>=0; $rests=$rests-$mr+$zinz)
				{
					$zinz = ($rests * $ie)/12;
					$b = $b + 1;
					$zing = $zing + $zinz;
					$rate = $mr + $zinz;
					$restse = $rests - $rate;
					
					/* echo "<br/><br/>$b mr $mr<br/><br/>";
					echo "<br/><br/> $b zinz $zinz<br/><br/>";
					echo "<br/><br/>$b rests $rests<br/><br/>"; */
					echo "<tr align='center'>";
					
					/* if( $lzm>=$b )
					{
						echo "<td>$b</td>";
					}
					else if( $lzm<$b )
					{
						echo "</tr>";
					} */
					echo "<td>$b</td>";
					if( $lzm>=$b )
					{
						echo "<td>" . number_format(($rests+$zinz),2,",",".") . "</td>";
						echo "<td>" . number_format($zin,2,",",".") . "</td>";
						echo "<td>" . number_format($rate,2,",",".") . "</td>";
						echo "<td>" . number_format($zinz,2,",",".") . "</td>";
						echo "<td>" . number_format($mr,2,",",".") . "</td>";
						echo "<td>" . number_format(($restse),2,",",".") . "</td>";
						echo "</tr>";
					}
					else if( $lzm<$b )
					{
						$rests = $rests + $rate;
						echo "<td>" . number_format(($rests+$zinz),2,",",".") . "</td>";
						echo "<td>" . number_format($zin,2,",",".") . "</td>";
						echo "<td>" . number_format($rate,2,",",".") . "</td>";
						echo "<td>" . number_format($zinz,2,",",".") . "</td>";
						echo "<td>" . number_format($mr,2,",",".") . "</td>";
						echo "<td>" . number_format(($restse),2,",",".") . "</td>";
						echo "</tr>";
					}
				}
				echo "</table>";
				echo "Zinszahlung = " . number_format(($zing + $zinz1),2,",",".");
			}
			else
			{
				echo "";
			}
			//*************************************************************************** Wenn die Monatliche Rate gegeben ist wird folgendes Ausgeführt ***************************************************************************
			if(isset($mr))
			{
				$zr = floor($betrag/$mr);
				echo $zr;
				$b = 0;
				for($lzm=1; $lzm<=$zr; $lzm++)
				{
					
					$zinz = ($betrag * $ie)/12;
					$betrag = $betrag - $mr + $zinz;
					$b = $b + 1;
					echo "<br/><br/>Zinszahlung " . $zinz . "<br/><br/>";
					echo "<br/><br/>Monatliche Rate " . $mr . "<br/><br/>";
					echo "<br/><br/>Laufzeit in monaten " . $lzm . "<br/><br/>";
					echo "<br/><br/>Restbetrag " . $betrag . "<br/><br/>";
					/* echo "<tr align='center'>";
					echo "<td>$b</td>";
					
					if($mr<=($betrag))
					{
						echo "<td>" . number_format($betrag + $zinz,2,",",".") . "</td>";
						echo "<td>" . number_format($zin,2,",",".") . "</td>";
						echo "<td>" . number_format($zinz,2,",",".") . "</td>";
						echo "<td>" . number_format($mr,2,",",".") ."</td>";
						echo "<td>" . number_format(($betrag - $mr + $zinz),2,",",".") . "</td>";
						echo "</tr>";
					}
					else if($mr>($betrag))
					{
						$mr = $betrag;
						echo "<td>" . number_format($betrag,2,",",".") . "</td>";
						echo "<td>" . number_format($zin,2,",",".") . "</td>";
						echo "<td>" . number_format($zinz,2,",",".") . "</td>";
						echo "<td>" . number_format($mr,2,",",".") ."</td>";
						echo "<td>" . number_format(($betrag - $mr),2,",",".") . "</td>";
						echo "</tr>";
					} */
				}
			}
			
		}
		
		
	}
	
?>
</div>
</body>
</html>