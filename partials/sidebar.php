<?php

$query = $db->query('SELECT id, title FROM movies ORDER BY rating DESC LIMIT 5');
$top_movies = $query->fetchAll();

$query = $db->query('SELECT id, title FROM movies ORDER BY year DESC LIMIT 5');
$last_movies = $query->fetchAll();

$query = $db->query('SELECT id, title FROM movies ORDER BY RAND() LIMIT 5');
$random_movies = $query->fetchAll();

?>
			<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
				<?php
				echo displayList($top_movies, 'Les 5 films les mieux notés', 'info');
				echo displayList($last_movies, 'Les 5 films les plus récents', 'warning');
				echo displayList($random_movies, '5 films au hasard', 'primary');
				?>

				<?php
				/*
				<div class="panel panel-primary">
					<div class="panel-heading">Les 5 films les mieux notés</div>
					<div class="list-group">
						<?php foreach($top_movies as $movie) { ?>
						<a href="movie.php?id=<?= $movie['id'] ?>" class="list-group-item"><?= $movie['title'] ?></a>
						<?php } ?>
					</div>
				</div>
				*/
				?>

				<div class="panel panel-default">
					<div class="panel-heading">Les dernières actualités</div>
					<div class="panel-body">
						...
					</div>
				</div>
			</div><!-- #sidebar -->