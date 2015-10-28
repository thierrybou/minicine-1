<?php

$same_genres_movies = getSimilarMovies($movie, 'genres', 5);
$same_actors_movies = getSimilarMovies($movie, 'actors', 5);
$same_directors_movies = getSimilarMovies($movie, 'directors', 5);
$same_writers_movies = getSimilarMovies($movie, 'writers', 5);

//echo debug($same_genres_movies);

?>
			<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
				<?php
				echo displayList($same_genres_movies, 'Films des mêmes genres', 'info');
				echo displayList($same_actors_movies, 'Films des mêmes acteurs', 'success');
				echo displayList($same_directors_movies, 'Films des mêmes réalisateurs', 'warning');
				echo displayList($same_writers_movies, 'Films des mêmes auteurs', 'danger');
				?>

				<!--
				<div class="panel panel-default">
					<div class="panel-heading">Films associés</div>
					<div class="panel-body">
						...
					</div>
				</div>
				-->

			</div><!-- #sidebar -->