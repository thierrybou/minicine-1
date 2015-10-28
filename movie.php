<?php
include_once 'partials/header.php';

//echo debug($_GET);

$id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

if (empty($id)) {
	exit('Undefined movie id');
}

$query = $db->prepare('SELECT * FROM movies WHERE id = :id');
$query->bindValue(':id', $id, PDO::PARAM_INT);
$query->execute();

if ($query->rowCount() == 0) {
	//header('Location: 404.php');
	exit('Undefined movie');
}

$movie = $query->fetch();

$back_link = 'index.php';
if (!empty($_SERVER['HTTP_REFERER'])) {
	$back_link = $_SERVER['HTTP_REFERER'];
}
//$back_link = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER']  : 'index.php';
?>
		<a href="<?= $back_link ?>" class="btn btn-default" role="button">&laquo; Retour</a>

		<hr>

		<div class="row movie-container">
			<div class="col-xs-12 col-sm-9">

				<img src="<?= getCover($movie['id']) ?>" align="left">

				<h2><?= getTitle($movie['title']) ?></h2>

				<hr>

				<p><strong>Année de sortie :</strong> <?= $movie['year'] ?> (<?= getDuration($movie['runtime']) ?>)</p>
				<p><strong>Genres :</strong> <?= $movie['genres'] ?></p>
				<p><strong>Acteurs :</strong> <?= $movie['actors'] ?></p>
				<p><strong>Réalisateurs :</strong> <?= $movie['directors'] ?></p>
				<hr>
				<blockquote>
					<p>
						<?= getSynopsis($movie['synopsis']) ?>
					</p>
				</blockquote>

			</div>

			<?php include_once 'partials/sidebar-movie.php' ?>

		</div>

<?php include_once 'partials/footer.php' ?>