<?php

//open connection with the database
require 'config/config.php';

// Take out the &page parameter using REGEX
$page_url = preg_replace('/&page=\d*/', '', $_SERVER['REQUEST_URI']);

	//connect to database
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ( $mysqli->connect_errno ) {
	echo $mysqli->connect_error;
	exit();
}

$mysqli->set_charset('utf8');


//design the query
// $sql = "SELECT dvd_titles.dvd_title_id, dvd_titles.title, genres.genre, ratings.rating, labels.label, formats.format, sounds.sound, dvd_titles.award, dvd_titles.release_date 
// 		FROM dvd_titles
// 		LEFT JOIN genres ON dvd_titles.genre_id = genres.genre_id
// 		LEFT JOIN ratings ON dvd_titles.rating_id = ratings.rating_id
// 		LEFT JOIN labels ON dvd_titles.label_id = labels.label_id
// 		LEFT JOIN formats ON dvd_titles.format_id = formats.format_id
// 		LEFT JOIN sounds ON dvd_titles.sound_id = sounds.sound_id
// 		WHERE 1=1";


$sql = "SELECT COUNT(*) AS count
		FROM dvd_titles
		LEFT JOIN genres ON dvd_titles.genre_id = genres.genre_id
		LEFT JOIN ratings ON dvd_titles.rating_id = ratings.rating_id
		LEFT JOIN labels ON dvd_titles.label_id = labels.label_id
		LEFT JOIN formats ON dvd_titles.format_id = formats.format_id
		LEFT JOIN sounds ON dvd_titles.sound_id = sounds.sound_id
		WHERE 1=1";

//(dvd) title
if( isset($_GET['title']) && !empty($_GET['title']) ) {
	$sql = $sql . " AND dvd_titles.title LIKE '%" . $_GET['title'] . "%'";
}
//genre
if( isset($_GET['genre']) && !empty($_GET['genre']) ) {
	$sql = $sql . " AND dvd_titles.genre_id = " . $_GET['genre'];
}
//rating
if( isset($_GET['rating']) && !empty($_GET['rating']) ) {
	$sql = $sql . " AND dvd_titles.rating_id = " . $_GET['rating'];
}
//label
if( isset($_GET['label']) && !empty($_GET['label']) ) {
	$sql = $sql . " AND dvd_titles.label_id = " . $_GET['label'];
}
//format
if( isset($_GET['format']) && !empty($_GET['format']) ) {
	$sql = $sql . " AND dvd_titles.format_id = " . $_GET['format'];
}
//sound
if( isset($_GET['sound']) && !empty($_GET['sound']) ) {
	$sql = $sql . " AND dvd_titles.sound_id = " . $_GET['sound'];
}
//award
if( isset($_GET['award']) && ($_GET['award'] != "any") ) {
	
	if ($_GET['award'] == "yes"){
		$sql = $sql . " AND dvd_titles.award IS NOT NULL";
	}
	else {
		$sql = $sql . " AND dvd_titles.award IS NULL";
	}
}
//release_date_from
if( isset($_GET['release_date_from']) && !empty($_GET['release_date_from']) ) {
	$sql = $sql . " AND dvd_titles.release_date > '" . $_GET['release_date_from'] . "'";

	// echo $_GET['release_date_from'];
	// echo $sql;
}

//release_date_to
if( isset($_GET['release_date_to']) && !empty($_GET['release_date_to']) ) {
	$sql = $sql . " AND dvd_titles.release_date < '" . $_GET['release_date_to'] . "'";
}

$sql = $sql . ";";

$results = $mysqli->query($sql);




if ($results == false ) {
	echo $mysqli->query($sql);
	exit();
}

$results_per_page = 20;
$first_page = 1;

$row = $results->fetch_assoc();
$num_results = $row['count'];
//in case current page is not initialized
$current_page = 1;

if( $num_results == 0 ){
	$error = "There are no DVDs that match your query.";
}
else{
	$last_page = ceil($num_results / $results_per_page);

	if (isset($_GET['page']) && !empty($_GET['page'])) {
		$current_page = $_GET['page'];
	}
	else {
		$current_page = $first_page;
	}

	//make sure the page is within bounds
	if ( $current_page < $first_page ) {
		$current_page = $first_page;
	}
	elseif ( $current_page > $last_page ) {
		$current_page = $last_page;
	}

	$start_index = ($current_page - 1 ) * $results_per_page;

	// END OF PAGINATION

	// Now get the details for the results
	$sql = str_replace("COUNT(*) AS count", "dvd_titles.dvd_title_id, dvd_titles.title, genres.genre, ratings.rating, labels.label, formats.format, sounds.sound, dvd_titles.award, dvd_titles.release_date", $sql);

	//set the limitations on the results coming out
	$sql = str_replace(';', '', $sql);

	// echo "<hr>" . $sql . "<hr>";

	$sql = $sql . " LIMIT " . $start_index . ", " . $results_per_page . ";";

	// echo "<hr>" . $sql . "<hr>";


	$results = $mysqli->query($sql);
	if ($results == false) {
		echo $mysqli->error;
		exit();
	}
}


// Close DB Connection.
$mysqli->close();


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DVD Search Results</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item active">Results</li>
	</ol>
	<div class="container-fluid">
		<div class="row">
			<h1 class="col-12 mt-4">DVD Search Results</h1>
		</div> <!-- .row -->
	</div> <!-- .container-fluid -->
	<div class="container-fluid">
		<div class="row mb-4">
			<div class="col-12 mt-4">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	<div class="row">
<!-- Navigation bar -->

<div class="col-12">
				<nav aria-label="Page navigation example">
					<ul class="pagination justify-content-center">
						<li class="page-item <?php 
							if ($current_page == $first_page) { echo "disabled";} ?>">
							<a class="page-link" href="<?php echo $page_url . "&page=" . $first_page ?>">First</a>
						</li>
						<li class="page-item">
							<a class="page-link" href="<?php echo $page_url . "&page=" . ($current_page - 1) ?>">Previous</a>
						</li>
						<li class="page-item active">
							<a class="page-link" href=""><?php echo $current_page ?></a>
						</li>
						<li class="page-item">
							<a class="page-link" href="<?php echo $page_url . "&page=" . ($current_page + 1) ?>">Next</a>
						</li>
						<li class="page-item 	<?php 
							if ($current_page == $last_page) { echo "disabled";} ?>">
							<a class="page-link" href="<?php echo $page_url . "&page=" . $last_page ?>">Last</a>
						</li>
					</ul>
				</nav>
			</div> <!-- .col -->


<!-- end of navigation bar -->
		
			<div class="col-12">

			<?php if ( isset($error) && !empty($error) ) : ?>

				<div class="text-danger">
					<?php echo $error ?>
				</div>

			<?php else : ?>

					Showing <?php echo $results->num_rows ?> out of <?php echo $num_results ?> result(s).

				</div> <!-- .col -->
				<div class="col-12">
					<table class="table table-hover table-responsive mt-4">
						<thead>
							<tr>
								<th></th>
								<th>DVD Title</th>
								<th>Release Date</th>
								<th>Genre</th>
								<th>Rating</th>
							</tr>
						</thead>
						<tbody>

							<?php while ($row = $results->fetch_assoc() ) : ?>

								<tr>
									<td>
										<a href="delete.php?id=<?php echo $row['dvd_title_id'] ?>" class="btn btn-outline-danger" onclick="return confirm('You are about to delete <?php echo "\'" . $row['title'] . "\'" ?>. Are you sure?')"> Delete </a>
									</td>
									<td>
										<a href="details.php?id=<?php echo $row['dvd_title_id'] ?>" ><?php echo $row['title'] ?> </a>
									</td>
									<td>
										<?php echo $row['release_date'] ?>
									</td>
									<td>
										<?php echo $row['genre'] ?>
									</td>
									<td>
										<?php echo $row['rating'] ?>
									</td>
								</tr>

							<?php endwhile ?>
						</tbody>
					</table>



				</div> <!-- .col -->


					<div class="col-12">
						<nav aria-label="Page navigation example">
							<ul class="pagination justify-content-center">
								<li class="page-item <?php 
									if ($current_page == $first_page) { echo "disabled";} ?>">
									<a class="page-link" href="<?php echo $page_url . "&page=" . $first_page ?>">First</a>
								</li>
								<li class="page-item">
									<a class="page-link" href="<?php echo $page_url . "&page=" . ($current_page - 1) ?>">Previous</a>
								</li>
								<li class="page-item active">
									<a class="page-link" href=""><?php echo $current_page ?></a>
								</li>
								<li class="page-item">
									<a class="page-link" href="<?php echo $page_url . "&page=" . ($current_page + 1) ?>">Next</a>
								</li>
								<li class="page-item 	<?php 
									if ($current_page == $last_page) { echo "disabled";} ?>">
									<a class="page-link" href="<?php echo $page_url . "&page=" . $last_page ?>">Last</a>
								</li>
							</ul>
						</nav>
					</div> <!-- .col -->


	


		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
			<?php endif; ?>
	</div> <!-- .container-fluid -->
</body>
</html>