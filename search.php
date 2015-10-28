<?php
include_once 'partials/header.php';

// Récupérer et stocker la valeur du champ de recherche rapide dans le header
$search = '';
if (!empty($_GET['search'])) {
	$search = $_GET['search'];
}

//$search = !empty($_GET['search']) ? $_GET['search'] : '';

// On récupère les champs du formulaire de recherche avancée
$title = !empty($_GET['title']) ? $_GET['title'] : '';
$genre = !empty($_GET['genre']) ? $_GET['genre'] : '';
$year = !empty($_GET['year']) ? $_GET['year'] : '';
$actors = !empty($_GET['actors']) ? $_GET['actors'] : '';
$directors = !empty($_GET['directors']) ? $_GET['directors'] : '';


$query = $db->query('SELECT DISTINCT(year) FROM movies ORDER BY year DESC');
$results = $query->fetchAll();

$movie_years = array();
foreach($results as $result) {
	$movie_years[] = $result['year'];
}

$query = $db->query('SELECT * FROM genres ORDER BY genre_name ASC');
$movie_genres = $query->fetchAll();

//echo debug($movie_genres);

$count_results = 0;
$search_results = array();

// Si l'utilisateur a tapé quelque chose dans le champ de recherche
if (!empty($_GET)) {

	if (!empty($search)) {

		// Effectuer une requête de sélection (sur la table "movies" dans la db "minicine") qui récupère tous les articles qui contiennent le critère de recherche dans le titre, le synopsis, les acteurs, les realisateurs et les auteurs
		$query = $db->prepare('SELECT * FROM movies WHERE title LIKE :search OR synopsis LIKE :search OR actors LIKE :search OR directors LIKE :search OR writers LIKE :search');
		$query->bindValue(':search', '%'.$search.'%', PDO::PARAM_STR);
		$query->execute();

		$count_results = $query->rowCount();

		if ($count_results > 0) {
			$search_results = $query->fetchAll();
		}

	} else {

		$sql = 'SELECT * FROM movies WHERE 1 ';
		$bindings = array();

		if (!empty($title)) {
			$sql .= 'AND title LIKE :title ';
			$bindings[':title'] = '%'.$title.'%';
		}
		if (!empty($genre)) {
			$sql .= 'AND genres LIKE :genre ';
			$bindings[':genre'] = '%'.$genre.'%';
		}
		if (!empty($year)) {
			$sql .= 'AND year = :year ';
			$bindings[':year'] = $year;
		}
		if (!empty($actors)) {
			$sql .= 'AND actors LIKE :actors ';
			$bindings[':actors'] = '%'.$actors.'%';
		}
		if (!empty($directors)) {
			$sql .= 'AND directors LIKE :directors ';
			$bindings[':directors'] = '%'.$directors.'%';
		}

		$query = $db->prepare($sql);

		echo $sql;
		echo debug($bindings);

		foreach($bindings as $key => $value) {
			$type = is_numeric($value) ? PDO::PARAM_INT : PDO::PARAM_STR;
			$query->bindValue($key, $value, $type);
		}

		$query->execute();

		$count_results = $query->rowCount();

		if ($count_results > 0) {
			$search_results = $query->fetchAll();
		}
	}
}
?>

		<h1>Recherche</h1>

		<hr>

		<form class="form-inline" action="search.php" method="GET">
			<div class="form-group">
				<label for="title">Titre</label>
				<input type="text" id="title" name="title" class="form-control" placeholder="Star Wars" value="<?= $title ?>">
			</div>

			<div class="form-group">
				<label for="title">Genre</label>
				<select id="genre" name="genre" class="form-control">
					<option value="">...</option>

					<?php
					foreach($movie_genres as $movie_genre) {
						$selected = ($movie_genre['genre_label'] == $genre ? ' selected' : '');
					?>
					<option value="<?= $movie_genre['genre_label'] ?>"<?= $selected ?>><?= $movie_genre['genre_name'] ?></option>
					<?php } ?>
				</select>
			</div>

			<div class="form-group">
				<label for="title">Année</label>
				<select id="year" name="year" class="form-control">

					<option value="">...</option>
					<?php
					foreach($movie_years as $movie_year) {
						$selected = ($movie_year == $year ? ' selected' : '');
					?>
					<option value="<?= $movie_year ?>"<?= $selected ?>><?= $movie_year ?></option>
					<?php } ?>

				</select>
			</div>

			<div class="form-group">
				<label for="title">Acteur(s)</label>
				<input type="text" id="actors" name="actors" class="form-control" placeholder="Christopher Lloyd" value="<?= $actors ?>">
			</div>

			<div class="form-group">
				<label for="title">Réalisateur(s)</label>
				<input type="text" id="directors" name="directors" class="form-control" placeholder="Robert Zemeckis" value="<?= $directors ?>">
			</div>

			<div class="form-group">
				<button type="submit" class="btn btn-default">
					<span class="glyphicon glyphicon-search" aria-hidden="true"></span> Rechercher
				</button>
			</div>
		</form>

		<?php if (!empty($_GET)) { ?>
		<hr>
		<h2><?= $count_results ?> résultat(s) pour la recherche <?= !empty($search) ? '&laquo; '.$search.' &raquo;' : '' ?></h2>

		<?php foreach($search_results as $movie) { ?>

		<a href="movie.php?id=<?= $movie['id'] ?>"><?= $movie['title'] ?></a><br>

		<?php } ?>


		<?php } ?>

<?php include_once 'partials/footer.php' ?>