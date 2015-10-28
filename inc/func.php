<?php

// UTILS
function debug($array) {
	return '<pre>'.print_r($array, true).'</pre>';
}

/*
	Coupe une chaine à la longueur $max_length en préservant les mots
*/
function cutString($text, $max_length, $end = '...') {
	// On défini une chaine qu'on va intercaller tous les X caractères en préservant les mots
	$sep = '[@]';

	// Si $max_length est positif et que la chaine $text est plus longue que $max_length
	if ($max_length > 0 && strlen($text) > $max_length) {
		// On intercalle la chaine $sep tous les X caractères
		$text = wordwrap($text, $max_length, $sep, true);
		// On découpe la chaine en plusieurs bouts dans un tableau
		$text = explode($sep, $text);
		// On retourne la première valeur du tableau et on concatène avec la chaine $end
		return $text[0].$end;
	}
	// On retourne la chaine telle qu'on l'a reçu
	return $text;
}

// MOVIES
function getTitle($title) {
	if (empty($title)) {
		return 'N/A';
	}
	return ucfirst($title);
}

function getSynopsis($synopsis, $max_length = 0) {
	if ($max_length <= 0) {
		return nl2br($synopsis);
	}
	return cutString($synopsis, $max_length, ' [...]');
}

function getCover($movie_id = 0) {
	$picture = 'img/cover.png';
	if (!empty($movie_id)) {
		$picture_path = 'img/covers/'.$movie_id.'.jpg';
		if (file_exists($picture_path)) {
			return $picture_path;
		}
	}
	return $picture;
}

function getDuration($runtime) {
	$runtime = intval($runtime);
	if (empty($runtime)) {
		return 'N/A';
	}
	if ($runtime < 60) {
		return $runtime.'min';
	}
	$hours = floor($runtime / 60);
	$minutes = sprintf('%1$02d', $runtime % 60);
	return $hours.'h'.$minutes.'min';
}

/*
	Retourne un bloc HTML "panel" avec une liste, un titre, une class css et une url variables
*/
function displayList($list, $title, $class = 'default', $url = 'movie.php') {

	// Si le tableau $list est vide
	if (empty($list)) {
		// On retourne une chaine vide
		return '';
	}

	// On remplit une variable avec du html
	$html  = '<div class="panel panel-'.$class.'">
				<div class="panel-heading">'.$title.'</div>
				<div class="list-group">';
				// Pour chacun des éléments de la liste
				foreach($list as $key => $item) {
				// On ajoute un lien à la variable html
				$html .= '<a href="'.$url.'?id='.$item['id'].'" class="list-group-item">'.($key + 1).'. '.$item['title'].'</a>';
				}
	// On fini de remplir la variable html avec les fermetures de balise
	$html .= '	</div>
			</div>';

	// On retourne le bloc html au complet
	return $html;
}

function getSimilarMovies($movie, $type, $limit = 0) {

	// On rapatrie la connexion à la bdd
	global $db;

	// On défini la liste des types autorisés
	static $types = array('actors', 'genres', 'directors', 'writers');

	// Si $type ne fait pas partie de la liste autorisée, ou qu'il n'est pas défini dans $movie
	if (!in_array($type, $types) || empty($movie[$type])) {
		// On retourne un résultat vide
		return array();
	}

	// On répartit la chaine du critère dans un tableau en coupant sur virgule + espace
	$items = explode(', ', $movie[$type]);
	//echo debug($items);

	// Pour chacun des critètres
	$filters = array();
	foreach($items as $item) {
		// On récupère un critère et on le transforme en clause WHERE
		$filters[] = $type.' LIKE "%'.$item.'%"';
	}
	//echo debug($filters);

	// On construit une requête SQL
	$sql  = 'SELECT * FROM movies WHERE 1 ';
	// On recolle les morceaux du tableau $filters sous forme de chaine en intercallant la chaine OR entre chaque morceau
	$sql .= 'AND ('.implode(' OR ', $filters).') ';
	// On exclue l'id du film sur lequel on se trouve actuellement
	$sql .= 'AND id != :id ';
	// On mélange
	$sql .= 'ORDER BY RAND() ';
	// On en garde X
	if ($limit > 0) {
		$sql .= 'LIMIT '.$limit;
	}
	//echo debug($sql);

	$query = $db->prepare($sql);
	$query->bindValue(':id', $movie['id'], PDO::PARAM_INT);
	$query->execute();

	$result = $query->fetchAll();

	//echo debug($result);

	return $result;
}