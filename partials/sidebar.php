<?php

$query = $db->query('SELECT id, title FROM movies ORDER BY rating DESC LIMIT 5');
$top_movies = $query->fetchAll();

$query = $db->query('SELECT id, title FROM movies ORDER BY year DESC LIMIT 5');
$last_movies = $query->fetchAll();

$query = $db->query('SELECT id, title FROM movies ORDER BY RAND() LIMIT 5');
$random_movies = $query->fetchAll();

$query = $db->query('SELECT news_id as id, news_title as title FROM news ORDER BY news_date DESC LIMIT 5');
$last_news = $query->fetchAll();
?>
			<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
				<?php
				echo displayList($top_movies, 'Les 5 films les mieux notés', 'info');
				echo displayList($last_movies, 'Les 5 films les plus récents', 'warning');
				echo displayList($random_movies, '5 films au hasard', 'primary');
				echo displayList($last_news, 'Les 5 dernières actualités', 'success', 'article.php', 'news_');
				?>
			</div><!-- #sidebar -->