<?php
setlocale(LC_TIME, 'fr_FR.UTF8', 'fra');

$current_page = basename($_SERVER['PHP_SELF']);

$pages = array(
	'index.php' => 'Accueil',
	'news.php' => 'Actualités',
	'search.php' => 'Recherche',
	'contact.php' => 'Contact',
);