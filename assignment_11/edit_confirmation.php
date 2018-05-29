<?php
require 'config/config.php';

if ( !isset($_POST['title']) || empty($_POST['title']) )  {

	// Missing required fields.
	$error = "Please fill out all required fields.";

} else {

	// DB Connection
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->errno ) {
		echo $mysqli->error;
		exit();
	}


// TITLE
	if( isset($_POST['title']) && !empty($_POST['title']) ){
		$title = $mysqli->real_escape_string($_POST['title']);
	} else{
		$title = "null";
	}
// DATE
	if( isset($_POST['release_date']) && !empty($_POST['release_date']) ){
		$date = $_POST['release_date'];
	} else {
		$date = "null";
	}
// AWARD
	if( isset($_POST['award']) && !empty($_POST['award']) ){
		$award = $mysqli->real_escape_string($_POST['award']);
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

	$sql = "UPDATE dvd_titles
					SET title = '" . $title . "', 
					release_date = " . $date .", 
					award = '" . $award . "', 
					label_id = " . $label_id .", 
					sound_id = " . $sound_id .", 
					genre_id = " . $genre_id .", 
					rating_id = " . $rating_id .", 
					format_id = " . $format_id ."
					WHERE dvd_title_id = " . $_POST['dvd_id'] . ";";

	$results = $mysqli->query($sql);
	if ( !$results ) {
		echo $mysqli->error;
		exit();
	}

	$mysqli->close();

}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Edit Confirmation | Song Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
		<li class="breadcrumb-item"><a href="details.php?id=<?php echo $_POST['dvd_id']; ?>">Details</a></li>
		<li class="breadcrumb-item"><a href="edit_form.php?id=<?php echo $_POST['dvd_id']; ?>">Edit</a></li>
		<li class="breadcrumb-item active">Confirmation</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Edit Confirmation</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">

		<?php if ( isset($error) && !empty($error) ) : ?>

		<div class="text-danger">
			<?php echo $error; ?>
		</div>

	<?php else : ?>

		<div class="text-success">

			<span class="font-italic"> '<?php echo $_POST['title']; ?>' </span> was successfully edited.

		</div>

	<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="details.php?id=<?php echo $_POST['dvd_id']; ?>" role="button" class="btn btn-primary">Back to Details</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>