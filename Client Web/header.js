document.write('<title>Seen | '+page+'</title>');
document.write('<!-- La feuille de styles "base.css" doit être appelée en premier. -->');
document.write('<link rel="stylesheet" type="text/css" href="css/base.css" media="all" />');
document.write('<link rel="stylesheet" type="text/css" href="css/modele04.css" media="screen" />');


document.write('<script type="text/javascript" src="jquery.min.js"></script>');
document.write('<script type="text/javascript">');
document.write("/**Animation de la fusée avec Javascript**/");
document.write('jQuery(document).ready(function($){');
document.write("rocket = $('#navigation');"); // Stockage des références des différents éléments dans des variables
document.write("fixedLimit = rocket.offset().top - parseFloat(rocket.css('marginTop').replace(/auto/,0));");// Calcul de la marge entre le haut du document et #navigation
document.write("$(window).trigger('scroll');");// On déclenche un événement scroll pour mettre à jour le positionnement au chargement de la page 
document.write('$(window).scroll(function(event){');        
document.write('windowScroll = $(window).scrollTop();');// Valeur de défilement lors du chargement de la page
document.write("if( windowScroll >= fixedLimit ){rocket.addClass('fixed');}else{rocket.removeClass('fixed');}");// Mise à jour du positionnement en fonction du scroll
document.write('});});');
document.write('</script>');

document.write('</head>');
document.write('<body>');

document.write('<div id="global">');
document.write('<div id="entete">');
document.write('<h1>Seen</h1>');

document.write('<p class="sous-titre">Pour toujours garder un <strong>oeil</strong> sur ses <strong>films</strong> et <strong>s&eacute;ries</strong> pr&eacute;f&eacute;r&eacute;s ...</p>');

document.write('</div><!-- #entete -->');
document.write('<div id="navigation">');
document.write('<ul>');
document.write('<li><a href="index.html">Acceuil</a></li>');
document.write('<li><a href="recherche.html">Recherche</a></li>');
document.write('<li><a href="films.html">Mes films</a></li>');
document.write('<li><a href="series.html">Mes s&eacute;ries</a></li>');
document.write('<li><a href="compte.html">Mon compte</a></li>');
document.write('</ul>');
document.write('</div>');