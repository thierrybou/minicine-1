<?php
include_once 'partials/header.php';

$query = $db->query('SELECT * FROM movies ORDER BY RAND() LIMIT 3');
$random_movies = $query->fetchAll();

//echo debug($random_movies);

$query = $db->query('SELECT * FROM movies ORDER BY year DESC LIMIT 8');
$last_movies = $query->fetchAll();

?>
		<div class="row">

			<div class="col-xs-12 col-sm-9">
				<div class="jumbotron">
					<h1>Bienvenue sur Movies !</h1>
					<p>Le site n°1 du cinéma.<br />
						Découvrez notre <a href="search.php">recherche</a> de films et des <a href="news.php">actualités</a> sur le cinéma.
					</p>
				</div>

				<div class="row marketing">

					<?php foreach($random_movies as $movie) { ?>
					<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
						<img class="movie-thumbnail" src="<?= getCover($movie['id']) ?>" />
						<div class="caption">
							<h2><?= getTitle($movie['title']) ?></h2>
							<p>
								<?= getSynopsis($movie['synopsis'], 50, ' [...]') ?>
							</p>
							<p><a class="btn btn-default" href="movie.php?id=<?= $movie['id'] ?>" role="button">Voir la fiche du film &raquo;</a></p>
						</div>
					</div><!-- .col-xs-12 .col-sm-6 .col-md-4 .col-lg-4 -->
					<?php } ?>

				</div><!-- .row.marketing -->

				<hr>

				<div id="top-movies" class="row">

					<?php foreach($last_movies as $movie) { ?>
					<div class="top-movie col-xs-12 col-sm-6 col-md-4 col-lg-3">
						<div class="thumbnail">
							<img src="<?= getCover($movie['id']) ?>" />
							<div class="caption">
								<h2><?= getTitle($movie['title']) ?></h2>
								<p>
									<?= getSynopsis($movie['synopsis'], 50, ' [...]') ?>
								</p>
								<p><a class="btn btn-default" href="movie.php?id=<?= $movie['id'] ?>" role="button">Voir la fiche du film &raquo;</a></p>
							</div>
						</div>
					</div>
					<?php } ?>

				</div><!-- #top-movies -->

			</div><!-- .col-xs-12 col-sm-9 -->

			<?php include_once 'partials/sidebar.php' ?>

		</div><!-- .row -->

<?php include_once 'partials/footer.php' ?>