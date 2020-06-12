<!DOCTYPE html>
<html>
<head>
<style>
.menu{
	font-size: 1.5em;
	width: 210px;
	height: 100vh;  
	border-width: thin;
	border-style: solid;
	background-color: orangered;
	border-color: red;
	padding-right: 1em;
	float: left;
	margin-right: 1em;
	}
.erg{
	background-color: lightgrey;
}
</style>
</head>
<body>
<link rel="stylesheet" href="../formate.css">
<div class="wrapper">
	<!--Kopf der Seite-->
	<div class="head">
	<h1>SupraBank</h1>
	<h2>Annuitätendarlehn</h2>
	</div>
	
	
<?php
	echo "<div class='menu'>";
	//Menu der Seite ( Weitere Einträge folgen )
	echo "<ul>";
	echo "<li><a href='../index.html'>Startseite</a></li>";
	echo "</ul>";
	echo "</div>";
	if($_POST["betrag"]>0)
	{
		echo "<div class='erg'>";
		echo "<table border='1'>";
		$betrag = $_POST["betrag"];    	//Darlehensbetarg
		$zin = $_POST["zin"];			//Zinssatz
		$ie = ($zin/100);
		$q = $ie +1;
		$a = 0;
		$b = 0;
		$zing = 0;
		echo $_POST["date"] . "<br/>";
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

		
			//Wenn der Zeitraum gegeben ist wird folgendes Ausgeführt
			if (isset($zr))
			{
				echo "<tr align='center'>";
				echo "<td>Monat</td>";
				echo "<td>Schuld Vormonat</td>";
				echo "<td>Zinssatz</td>";
				echo "<td>Annuitätsrate</td>";
				echo "<td>Zinsszahlung</td>";
				echo "<td>Tilgungsanteil</td>";
				echo "<td>Schuld E. d. M.</td>";
				echo "</tr>";
				$qn = $q**$zr;
				$lzm = $zr * 12;		//Laufzeit in Monaten
				
				
				
				
				
				$annu = ($betrag * $qn * ($ie)/($qn -1))/12;
					for($rests=$betrag; $rests>0; $rests=$rests+$zinz-$annu)
					{
						echo "<tr align='center'>";
						$zinz = ($rests * $ie)/12;
						$til = $annu - $zinz;
						$a = $a + 1;
						if($a>12)
							$a = 1;
						echo "<td>" . $a . "</td>";
						echo "<td>" .  number_format($rests,2,",",".") . "&euro;</td>";
						echo "<td>" . $zin . "%</td>";
						$zing = $zing + $zinz; 
						
							if($til<$rests)
							{
								echo "<td>" . number_format($annu,2,",",".") . "&euro;</td>";
								echo "<td>" . number_format($zinz,2,",",".") . "&euro;</td>";
								echo "<td>" . number_format($til,2,",",".") . "&euro;</td>";
								echo "<td>" . number_format($rests - $til,2,",",".") . "&euro;</td></tr>";
							}
							else if($til>$rests)
							{
								$til = $rests;
								$annu = $rests + $zinz;
								echo "<td>" . number_format($annu,2,",",".") . "&euro;</td>";
								echo "<td>" . number_format($zinz,2,",",".") . "&euro;</td>";
								echo "<td>" . number_format($til,2,",",".") . "&euro;</td>";
								echo "<td>" . number_format($rests - $til,2,",",".") . "&euro;</td></tr>";
							}
					
					}
				echo "Gesammtschuld nach " . $zr . " Jahr(en): " . number_format($zing + $betrag,2,",",".") . "&euro;<br/>";
			}
		
			//Wenn die Monatliche Rate gegeben ist wird folgendes Ausgeführt
			if(isset($mr) && ($mr > 0))
			{
				echo "<tr align='center'>";
				echo "<td>Monat</td>";
				echo "<td>Schuld Vormonat</td>";
				echo "<td>Zinssatz</td>";
				echo "<td>Annuitätsrate</td>";
				echo "<td>Zinsszahlung</td>";
				echo "<td>Tilgungsanteil</td>";
				echo "<td>Schuld E. d. M.</td>";
				echo "</tr>";
				$ez = ($betrag * $ie)/12;			//erste Zinsszahlung
				$etil = ($mr - $ez);				//erste Tilgunsrate
				$erests = $betrag - $etil;			//erste Restschuld
			
					if($etil>0)
					{
						$a = 1;
						$b= 1;
						$zinz = ($erests * $ie)/12;
						echo "<tr align='center'>";
						echo "<td>" . $a . "</td>";
						echo "<td>" . number_format($betrag,2,",",".") . "&euro;</td>";
						echo "<td>" . $zin . "%</td>";
						echo "<td>" . number_format($mr,2,",",".") . "&euro;</td>";
						echo "<td>" . number_format($ez,2,",",".") . "&euro;</td>";
						echo "<td>" . number_format($etil,2,",",".") . "&euro;</td>";
						echo "<td>" . number_format($erests,2,",",".") ."&euro;</td>";
					
							for($rests=$erests; $rests>0; $rests=$rests+$zinz-$mr)
							{
								$a = $a+1;
								$b = $b+1;
								if($a>12)
									$a = 1;
								$zinz = ($rests * $ie)/12;
								$til = $mr - $zinz;
								echo "<tr align='center'>";
								echo "<td>" . $a . "</td>";
								echo "<td>" .  number_format($rests,2,",",".") . "&euro;</td>";
								echo "<td>" . $zin . "%</td>";
								$zing = $zing + $zinz;
							
									if($til<$rests)
									{
										echo "<td>" . number_format($mr,2,",",".") . "&euro;</td>";
										echo "<td>" . number_format($zinz,2,",",".") . "&euro;</td>";
										echo "<td>" . number_format($til,2,",",".") . "&euro;</td>";
										echo "<td>" . number_format($rests - $til,2,",",".") . "&euro;</td></tr>";
									}
									else if($til>$rests)
									{
										$til = $rests;
										$mr = $rests + $zinz;
										echo "<td>" . number_format($mr,2,",",".") . "&euro;</td>";
										echo "<td>" . number_format($zinz,2,",",".") . "&euro;</td>";
										echo "<td>" . number_format($til,2,",",".") . "&euro;</td>";
										echo "<td>" . number_format($rests - $til,2,",",".") . "&euro;</td></tr>";
									}
							}
						echo "Gesammtschuld nach " . number_format($b/12,2,",",".") . " Jahr(en): " . number_format($betrag + $ez + $zing,2,",",".") . "&euro;";
						echo "</table>";
						echo "</div>";
					}
				else
				{
					echo "Die Monatliche Rate ist zu Klein";
				}
			}
		}
		else
		{
		echo "<p>Es fehlen Angaben zum Darlehen!</p>";
		echo "<p><a href='anndarlehen.html'>Zurück</a></p>";
		
		}
	}
	else
	{
		echo "<p>Keine Darlehenssumme angegeben!</p>";
		echo "<p><a href='anndarlehen.html'>Zurück</a></p>";
	}
	echo "</div>";
?>
</div>
</body>
</html>