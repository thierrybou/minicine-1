
		<hr>

		<footer>
			<p>&copy; Minicine <?= date('Y') ?></p>
		</footer>

	</div><!-- .container -->

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>

	<script>
		$(document).ready(function() {
			if ($('#top-movies').length > 0) {
				$.getScript('//cdn.jsdelivr.net/isotope/1.5.25/jquery.isotope.min.js', function(){
					$('#top-movies').isotope({
						itemSelector : '.top-movie'
					});
				});
			}
		});
	</script>
</body>
</html>