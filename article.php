<?php
require_once 'partials/header.php';

//echo '$_GET = '. debug($_GET);

$id = 0;
// Si on a bien un paramètre id défini dans l'url (Ex: article.php?id=42)
if (!empty($_GET['id'])) {
	// On force le paramètre id en nombre
	$id = intval($_GET['id']);
}

// Equivalent du test ci-dessus en version ternaire
// $id = !empty($_GET['id']) ? intval($_GET['id']) : 0;

// Si le paramètre id est vide ou non défini
if (empty($id)) {
	exit('Undefined article id');
}

//$query = $db->query('SELECT * FROM news WHERE id = '.$id);
$query = $db->prepare('SELECT * FROM news WHERE news_id = :id');
$query->bindValue(':id', $id, PDO::PARAM_INT);
$query->execute();

if ($query->rowCount() == 0) {
	//header('Location: 404.php'); // Redirection vers 404.php
	exit('Undefined article');
}

$article = $query->fetch();

//echo debug($article);

$back_link = 'index.php';
if (!empty($_SERVER['HTTP_REFERER'])) {
	$back_link = $_SERVER['HTTP_REFERER'];
}
?>
		<br>
		<a href="<?= $back_link ?>" class="btn btn-default">Retour</a>

		<div class="row">

			<div class="col-xs-12 col-sm-9">

				<div class="blog-header">
					<h1 class="blog-title"><?= ucfirst($article['news_title']) ?></h1>
					<p class="lead blog-description">
						<?= news_getFormatDate($article['news_date']) ?> par <a href="#"><?= ucfirst($article['news_author']) ?></a>
					</p>
				</div>

				<div class="blog-post">

					<blockquote>
						<?= nl2br($article['news_text']) ?>
					</blockquote>

				</div><!-- /.blog-post -->

			</div><!-- /.blog-main -->

			<?php require_once 'partials/sidebar-news.php' ?>

		</div><!-- /.row -->

<?php require_once 'partials/footer.php' ?>