<?php

	//open connection with the database
	$host = "303.itpwebdev.com";
	$password = "Iaminla123";
	$db = "benjamfr_DVD_db";
	$user = "benjamfr_db_user";
	

	//connect to database
	$mysqli = new mysqli($host,$user,$password, $db);
	if ( $mysqli->connect_errno ){
		echo $mysqli->connect_errno;
		exit();
	}

	$mysqli->set_charset('utf8');

//design the query
$sql = "SELECT dvd_titles.dvd_title_id, dvd_titles.title, genres.genre, ratings.rating, labels.label, formats.format, sounds.sound, dvd_titles.award, dvd_titles.release_date 
		FROM dvd_titles
		LEFT JOIN genres ON dvd_titles.genre_id = genres.genre_id
		LEFT JOIN ratings ON dvd_titles.rating_id = ratings.rating_id
		LEFT JOIN labels ON dvd_titles.label_id = labels.label_id
		LEFT JOIN formats ON dvd_titles.format_id = formats.format_id
		LEFT JOIN sounds ON dvd_titles.sound_id = sounds.sound_id
		WHERE 1=1";


//get all the fields, and if a field is empty call it null



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

//send a query to the database and store the returned data + check for errors

$results = $mysqli->query($sql);

// var_dump($results);
// echo $results->num_rows;




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
			<div class="col-12">

				Showing <?php echo $results->num_rows ?> result(s).

			</div> <!-- .col -->
			<div class="col-12">
				<table class="table table-hover table-responsive mt-4">
					<thead>
						<tr>
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
									<a href="details.php?id= <?php echo $row['dvd_title_id'] ?>" ><?php echo $row['title'] ?> </a>
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
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container-fluid -->
</body>
</html>