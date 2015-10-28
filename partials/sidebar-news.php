				<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
					<div class="panel panel-default">
						<div class="panel-heading">Archives</div>
						<div class="panel-body">
							<ol class="list-unstyled">

								<?php
								for ($i = 0; $i <= 12; $i++) {

									$time = strtotime('-'.$i.' month');

									$date_value = date('Y-m', $time);

									$month_label = utf8_encode(strftime('%B', $time));

									$date_label = ucfirst($month_label).' '.date('Y', $time); // Octobre 2015
								?>
								<li><a href="news.php?date=<?= $date_value ?>"><?= $date_label ?></a></li>
								<?php } ?>

							</ol>
						</div>
					</div>

				</div><!-- #sidebar -->