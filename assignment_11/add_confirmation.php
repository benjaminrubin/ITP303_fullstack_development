<?php
	//verify that all required variables were filled out
if( !isset($_POST['title']) || empty($_POST['title']) ){
	
		$error = "Please fill out all required fields";

} else {
	//open connection with the database
	require 'config/config.php';

	//connect to database
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

	$mysqli->set_charset('utf8');

// TITLE
	if( isset($_POST['title']) && !empty($_POST['title']) ){
		$title = $_POST['title'];
	} else{
		$title = "null";
	}
// DATE
	if( isset($_POST['date']) && !empty($_POST['date']) ){
		$date = $_POST['date'];
	} else {
		$date = "null";
	}
// AWARD
	if( isset($_POST['award']) && !empty($_POST['award']) ){
		$award = $_POST['award'];
	} else{
		$award = "null";
	}
// LABEL
	if( isset($_POST['label']) && !empty($_POST['label']) ){
		$label_id = $_POST['label'];
	} else {
		$label_id = "null";
	}
// SOUND
	if( isset($_POST['sound']) && !empty($_POST['sound']) ){
		$sound_id = $_POST['sound'];
	} else {
		$sound_id = "null";
	}

// GENRE
	if( isset($_POST['genre']) && !empty($_POST['genre']) ){
		$genre_id = $_POST['genre'];
	} else {
		$genre_id = "null";
	}
// RATING
	if( isset($_POST['rating']) && !empty($_POST['rating']) ){
		$rating_id = $_POST['rating'];
	} else {
		$rating_id = "null";
	}
// FORMAT
	if( isset($_POST['format']) && !empty($_POST['format']) ){
		$format_id = $_POST['format'];
	} else {
		$format_id = "null";
	}


	//date is in the format MM-DD-YYYY


	//generate SQL statement to insert new football game
	$sql = "INSERT INTO dvd_titles (title, release_date, award, label_id, sound_id, genre_id, rating_id, format_id)
			VALUES ("
			. "'" . $title . "',"
			. "'" . $date . "',"
			. "'" . $award . "',"
			. $label_id . ","
			. $sound_id . ","
			. $genre_id . ","
			. $rating_id . ","
			. $format_id
			. ");";

	$results = $mysqli->query($sql);

	//check for errors with the sql statement
	if( $results == false ){
		echo $mysqli->error;
		exit();
	}

	//Clost the database connection
	$mysqli->close();

}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add Confirmation | DVD Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="add_form.php">Add</a></li>
		<li class="breadcrumb-item active">Confirmation</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Add a DVD</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">
				<?php if (isset($error)) : ?>
					<div class="text-danger">
						<?php echo $error ?>
					</div>
				<?php else : ?>
					<div class="text-success">
						The DVD "<?php echo $title ?>" was successfully added.
					</div>
				<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="add_form.php" role="button" class="btn btn-primary">Back to Add Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>