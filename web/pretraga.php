<?php
error_reporting( E_ALL );

require_once('funkcije.php'); 

print_r($_GET);

$xmlDom = new DOMDocument();
$xmlDom->load( 'podaci.xml' );

$xPath = new DOMXPath($xmlDom);
$xmlQuery = "/drustva/drustvo";

$filteredNodes = $xPath->query($xmlQuery);
?>

<html lang="hr">
<head>
    <meta charset="UTF-8"/>
    <title>HCK news feed</title>
    <link rel="shortcut icon" type="image/png" href="./favicon.ico"/>
    <link rel="stylesheet" href="./dizajn.css" type="text/css"/>
    <script src="https://use.fontawesome.com/3b6cd20c64.js"></script>
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
                <li><a href="index.html"><i class="fa fa-home fa-fw"></i><xsl:text>&#160;</xsl:text>POČETNA</a></li>
                <li><a href="obrazac.html"><i class="fa fa-search fa-fw"></i><xsl:text>&#160;</xsl:text>PRETRAGA</a></li>
                <li><a href="podaci.xml"><i class="fa fa-table fa-fw"></i><xsl:text>&#160;</xsl:text>PODACI</a></li>
                <li><a href="http://www.hck.hr/hr" target="_blank"><i class="fa fa-plus fa-fw"></i><xsl:text>&#160;</xsl:text>HCK WEB</a></li>
                <li><a href="http://www.fer.unizg.hr/predmet/or"><i class="fa fa-desktop fa-fw"></i><xsl:text>&#160;</xsl:text>OR @ FER</a></li>
                <li><a href="http://www.fer.unizg.hr" target="_blank"><i class="fa fa-university fa-fw"></i><xsl:text>&#160;</xsl:text>FER UNIZG</a></li>
                <li><a href="mailto:filip.floreani@fer.hr"><i class="fa fa-envelope fa-fw"></i><xsl:text>&#160;</xsl:text>E-MAIL</a></li>
            </ul>
        </nav>

        <div class="main">
            <div class="branches xml-branches">
                <h1 class="headline">Podaci o društvima</h1>
                <div class="tbl-header">
                    <table>
                        <tr>
                            <th>Naziv</th>
                            <th>Ravnatelj/ica</th>
                            <th>Radno vrijeme</th>
                            <th>Adresa</th>
                            <th style="text-align:center;">Web</th>
                            <th style="text-align:center;">Facebook</th>
                        </tr>
                    </table>
                </div>
                <div class="tbl-content" style="height:50%; margin-bottom:60px;">
                    <table>
                        <?php foreach($filteredNodes as $drustvo) { ?>
                            <tr>
                                <td> <!-- Branch title -->
                                    <?php echo getElementValue("naziv", $drustvo); ?>
                                </td>
                                <td> <!-- Branch director -->
                                    <?php echo getElementValue("ravnatelj", $drustvo); ?>
                                </td>
                                <td> <!-- Working hours -->
                                    Radni dan: <?php echo getOpenHours(true, $drustvo); ?><br/>
                                    Subota: <?php echo getOpenHours(false, $drustvo); ?>
                                </td>
                                <td> <!-- Address -->
                                    <?php echo getAddress($drustvo); ?>
                                </td>
                                <td style="text-align:center;"> <!-- Web link -->
                                    
                                </td>
                                <td style="text-align:center;"> <!-- Facebook link -->
                                    <a class="links" href=<?php echo getFacebookLink($drustvo); ?> target="_blank">
                                        <i class="fa fa-lg fa-fw fa-facebook-official"></i>
                                    </a>
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
</body>
</html>