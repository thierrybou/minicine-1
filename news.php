<?php
include_once 'partials/header.php';

$date = !empty($_GET['date']) ? $_GET['date'] : date('Y-m'); // 2015-10

$query = $db->prepare('SELECT * FROM news WHERE DATE_FORMAT(news_date, "%Y-%m") = :date');
$query->bindValue(':date', $date, PDO::PARAM_STR);
$query->execute();
$news = $query->fetchAll();

//echo debug($news);
?>

		<div class="news-container">

			<div class="news-header">
				<h1>Actualités</h1>
				<p>Découvrez toute l'actualité du cinéma</p>
			</div>

			<div class="row">
				<div class="col-xs-12 col-sm-9">

					<?php
					foreach($news as $article) {

						// Formattage de la date : Lundi 15 janvier 2015
						$news_date = news_getFormatDate($article['news_date']);
					?>
					<div class="news-post">
						<h2><a href="article.php?id=<?= $article['news_id'] ?>"><?= $article['news_title'] ?></a></h2>

						<p><?= $news_date ?> par <a href="#"><?= $article['news_author'] ?></a></p>

						<hr>
						<blockquote>
							<p>
								<?= cutString($article['news_text'], 200, ' [...]') ?>
							</p>
						</blockquote>

						<a href="article.php?id=<?= $article['news_id'] ?>" class="btn btn-default">Lire la suite</a>
					</div>
					<?php } ?>

				</div>

				<?php include_once 'partials/sidebar-news.php' ?>

			</div>
		</div>

<?php include_once 'partials/footer.php' ?>