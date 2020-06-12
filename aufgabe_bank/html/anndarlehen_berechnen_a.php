<!DOCTYPE html>
<html>
<head>
</head>
<body>
<link rel="stylesheet" href="../formate.css" />
<div class="wrapper">
	<!--Kopf der Seite-->
	<div class="head">
	<h1>SupraBank</h1>
	<h2>Annuitätendarlehen</h2>
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
	<h4>Übersicht der Annuität und der dazugehörigen Zinszahlung sowie des Tilgungsanteils<br/><br/></h4>
	</div>
<?php
	//Menu der Seite ( Weitere Einträge folgen )
	echo "<div class='menu'>";
	echo "<ul>";
	echo "<li><a href='../index.html'>Startseite</a></li>";
	echo "<li><a href='tilldarlehen.html'>Tillgunsdarlehen</a></li>";
	echo "<li><a href='anndarlehen.html'>Zurück zur <br/>Eingabe</a></li>";
	echo "</ul>";
	echo "</div>";
		echo "<div class='erg'>";
		echo "<table border='1' align='center'>";
		echo "<thead>";
		echo "<tr align='center' width=20%>";
		echo "<td><b>Datum</b></td>";
		echo "<td><b>Schuld Vormonat</b></td>";
		echo "<td><b>Zinssatz</b></td>";
		echo "<td><b>Annuitätsrate</b></td>";
		echo "<td><b>Zinszahlung</b></td>";
		echo "<td><b>Tilgungsanteil</b></td>";
		echo "<td><b>Schuld E. d. M.</b></td>";
		echo "</tr>";
		echo "</thead>";
		
		$a = $_POST["monat"] - 1;		//Monat
		$b = 0;							//Für die Anzeige der Laufzeit in Monaten
		$c = $_POST["jahr"] ;			//Jahr
		
		if($a<1)
		{
			$a = 12;
			$c = $c - 1;
		}
		else if($a>1)
		{
			$a = $a;
			$c = $c;
		}
		if($a<10)
		{
			$a = "0" . $a;
		}
		if(($_POST["betrag"])>0)
		{
			echo "<tr align='center' >";
			echo "<td>" . ($c + 1) . "/" . $a . "</td>";
			echo "<td>-</td>";
			echo "<td>-</td>";
			echo "<td>-</td>";
			echo "<td>-</td>";
			echo "<td>-</td>";
			echo "<td>" . number_format($_POST["betrag"],2,",",".") . "</td>";
			echo "</tr>";
		}
		else
			echo "";
?>

<?php
	if(($_POST["betrag"]>0) && ($_POST["zin"]>0))
	{
		$betrag = $_POST["betrag"];    	//Darlehensbetarg
		$zin = $_POST["zin"];			//Zinssatz
		$ie = ($zin/100);
		$q = $ie + 1;
		$zing = 0;
		$a = $_POST["monat"] - 1;		//Monat
		$b = 0;							//Für die Anzeige der Laufzeit in Monaten
		$c = $_POST["jahr"] ;			//Jahr	
		
		
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
			if (isset($zr))
			{
		/* 		echo "<tr align='center'>";
				echo "<td><b>Datum</b></td>";
				echo "<td><b>Schuld Vormonat</b></td>";
				echo "<td><b>Zinssatz</b></td>";
				echo "<td><b>Annuitätsrate</b></td>";
				echo "<td><b>Zinsszahlung</b></td>";
				echo "<td><b>Tilgungsanteil</b></td>";
				echo "<td><b>Schuld E. d. M.</b></td>";
				echo "</tr>"; */
				
				$qn = $q**$zr;
				$lzm = $zr * 12;		//Laufzeit in Monaten
				$annu = (($betrag * $qn * (($ie)/($qn -1)))/12);
				$letzteru = 0;
				$monat = 0;
				/* echo "<br/><br/>" . number_format($annu,2,",",".") . "<br/><br/>";
				echo "<br/><br/>$lzm<br/><br/>"; */
				do
				{
					/* echo "<br/><br/>Annu $annu <br/><br/>"; */
					$temprest = $betrag;
					$annu = $annu + ($letzteru/$lzm);
					
/* 					if($letzteru>0)
					{
						$annu = $annu + ($letzteru/$lzm);
					}
					if($letzteru<0)
					{
						$annu = $annu + ($letzteru/$lzm);
					} */
					
					
					/* echo "<br/><br/>LetzterU $letzteru <br/><br/>"; */
					
				    for($monat=0; $monat<$lzm; $monat++)
					{
						$tempzinz = ($temprest * $ie)/12;
						$temprest = $temprest + $tempzinz - $annu;
						/* echo "$monat $temprest <br/>"; */
					}
					
					$letzteru = $temprest;
					

				}while( ($letzteru<(-0.01*$lzm)) || ($letzteru>0) );

					/* if($monat>$lzm)
					{
						$annu = $annu + ($letzteru/$lzm); 
					} */
					
				
				
					for($rests=$betrag; $rests>0; $rests=$rests+$zinz-$annu)
					{
						echo "<tr align='center'>";
						$zinz = ($rests * $ie)/12;
						$til = $annu - $zinz;
						$b = $b + 1;
						$a = $a + 1;
						/* echo "<br/><br/>" . number_format($annu,2,",",".") . "<br/><br/>"; */
						if($a>12)
						{
							$a = 1;
							$c = $c + 1;
						}
						if($a<10)
						{
							$a = "0" . $a;
						}
						echo "<td>" . ($c + 1) . "/" . $a . "</td>";
						echo "<td>" .  number_format($rests,2,",",".") . "&euro;</td>";
						echo "<td>" . number_format($zin,2,",",".") . "%</td>";
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
					echo "</table>";
					echo "<div class='drucken'>";
					echo "<button onclick='window.print()'>Drucken</button>";
					echo "</div>";
					echo "<p>Gesammtschuld nach " . number_format($b/12,2,",",".") . " Jahr(en): " . number_format($zing + $betrag,2,",",".") . "&euro;</p>";
			}
		
			//*************************************************************************** Wenn die Monatliche Rate gegeben ist wird folgendes Ausgeführt ***************************************************************************
			if(isset($mr) && ($mr > 0))
			{
				/* echo "<tr align='center' width=210>";
				echo "<td><b>Datum</b></td>";
				echo "<td><b>Schuld Vormonat</b></td>";
				echo "<td><b>Zinssatz</b></td>";
				echo "<td><b>Annuitätsrate</b></td>";
				echo "<td><b>Zinszahlung</b></td>";
				echo "<td><b>Tilgungsanteil</b></td>";
				echo "<td><b>Schuld E. d. M.</b></td>";
				echo "</tr>"; */
				
				$ez = ($betrag * $ie)/12;			//erste Zinszahlung
				$etil = ($mr - $ez);				//erste Tilgunsrate
				$erests = $betrag - $etil;			//erste Restschuld
			
					if($etil>0)
					{
						$a = $a + 1;
						$b= 1;
						$zinz = ($erests * $ie)/12;
						
						if($a<10)
							$a = "0" . $a;
						
						echo "<tr align='center' >";
						echo "<td>" . ($c + 1) . "/" . $a . "</td>";
						echo "<td>" . number_format($betrag,2,",",".") . "&euro;</td>";
						echo "<td>" . number_format($zin,2,",",".") . "%</td>";
						echo "<td>" . number_format($mr,2,",",".") . "&euro;</td>";
						echo "<td>" . number_format($ez,2,",",".") . "&euro;</td>";
						echo "<td>" . number_format($etil,2,",",".") . "&euro;</td>";
						echo "<td>" . number_format($erests,2,",",".") ."&euro;</td>";
					
							for($rests=$erests; $rests>0; $rests=$rests+$zinz-$mr)
							{
								$a = $a+1;
								$b = $b+1;
								
								if($a>12)
								{
									$a = 1;
									$c = $c + 1;
								}
								
								if($a<10)
									$a = "0" . $a;
								
								$zinz = ($rests * $ie)/12;
								$til = $mr - $zinz;
								
								echo "<tr align='center'>";
								echo "<td>" . ($c + 1) . "/" . $a . "</td>";
								echo "<td>" .  number_format($rests,2,",",".") . "&euro;</td>";
								echo "<td>" . number_format($zin,2,",",".") . "%</td>";
								
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
						echo "</table>";
						echo "<div class='drucken'>";
						echo "<button onclick='window.print()'>Drucken</button>";
						echo "</div>";
						echo "<p>Gesammtschuld nach " . number_format($b/12,2,",",".") . " Jahr(en): " . number_format($betrag + $ez + $zing,2,",",".") . "&euro;</p>";
					}
				else
				{
					echo "<p>Die Monatliche Rate ist zu Klein</p>";
					echo "<p><a href='anndarlehen.html'>Zurück</a></p>";
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
		echo "<p>Keine Darlehenssumme oder Zinssatz angegeben!</p>";
		echo "<p><a href='anndarlehen.html'>Zurück</a></p>";
	}
	echo "</div>";
?>
<link rel="stylesheet" media="print" href="print.css">
</div>
</body>
</html>
