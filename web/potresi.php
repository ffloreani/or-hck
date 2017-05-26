<?php
error_reporting( E_ALL );

require_once( 'funkcije.php' );

$url = "https://earthquake.usgs.gov/fdsnws/event/1/query?format=geojson&starttime=2017-06-01&latitude=44&longitude=16&maxradiuskm=10000";
  
$data = file_get_contents($url);
$json = json_decode($data, true);

$quakes = $json['features'];
?>

<html lang="hr">
<head>
    <meta charset="UTF-8"/>
    <title>Earthquakes</title>
    <link rel="shortcut icon" type="image/png" href="./favicon.ico"/>
	<link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" integrity="sha512-07I2e+7D8p6he1SIM+1twR5TIrhUQn9+I6yjqD53JQjFiMf8EtC93ty0/5vJTZGF8aAocvHYNEDJajGdNx1IsQ==" crossorigin=""/>
    <link rel="stylesheet" href="./dizajn.css" type="text/css"/>
</head>
<body>
    <div id="wrapper">
        <header class="masthead">
            <div class="logo">
                <a href="index.html"><img src="res/hck_logo.gif" alt="Logo HCK"/></a>
            </div>
            <span class="masthead-search">
                <a href="obrazac.html"><i class="fa fa-search fa-2x fa-flip-horizontal"></i></a>
            </span>
        </header>

        <nav class="sidebar">
            <ul class="side">
                <li><a href="index.html"><i class="fa fa-home fa-fw"></i>&nbsp;POČETNA</a></li>
                <li><a href="obrazac.html"><i class="fa fa-search fa-fw"></i>&nbsp;PRETRAGA</a></li>
                <li><a href="podaci.xml"><i class="fa fa-table fa-fw"></i>&nbsp;PODACI</a></li>
                <li><a href="http://www.hck.hr/hr" target="_blank"><i class="fa fa-plus fa-fw"></i>&nbsp;HCK WEB</a></li>
                <li><a href="http://www.fer.unizg.hr/predmet/or"><i class="fa fa-desktop fa-fw"></i>&nbsp;OR @ FER</a></li>
                <li><a href="http://www.fer.unizg.hr" target="_blank"><i class="fa fa-university fa-fw"></i>&nbsp;FER UNIZG</a></li>
                <li><a href="mailto:filip.floreani@fer.hr"><i class="fa fa-envelope fa-fw"></i>&nbsp;E-MAIL</a></li>
				<li><a href="potresi.php"><i class="fa fa-globe fa-fw"></i>&nbsp;POTRESI</a></li>
            </ul>
        </nav>

        <div class="main">
            <div class="branches">
                <h1 class="headline">Potresi</h1>
                <div class="tbl-header">
                    <table>
						<tr>
							<th>Magnituda</th>
							<th>Lokacija</th>
							<th>Vrijeme</th>
						</tr>
                    </table>
                </div>
                <div class="tbl-content" style="max-height:50%; margin-bottom:60px;">
                    <table>
                        <?php foreach($quakes as $quake) { 
							$location = getLocation($quake);
							$mag = getMagnitude($quake);
							$time = getTime($quake);
						?>
                            <tr>
                                <td> <!-- Magnitude -->
                                    <?php echo "R " . $mag; ?>
                                </td>
								<td> <!-- Location -->
									<?php echo $location; ?>
								</td>
                             	<td> <!-- Time -->
									<?php echo $time; ?>
								</td>
                            </tr>
                        <?php } ?>
                    </table>
                </div>
			</div>
        </div>

        <footer class="main-footer" style="position: fixed; bottom:0; right:0; left: 0;">
            <p>&#169; Filip Floreani (Otvoreno računarstvo) 2017.</p>
        </footer>
    </div>
		
	<script src="https://use.fontawesome.com/3b6cd20c64.js"></script>
</body>
</html>