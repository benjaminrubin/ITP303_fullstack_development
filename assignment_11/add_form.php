<?php
	
//open connection with the database
require 'config/config.php';

//connect to database
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ( $mysqli->connect_errno ) {
	echo $mysqli->connect_error;
	exit();
}

$mysqli->set_charset('utf8');


//genre
	$genre_query = "SELECT genres.genre, genres.genre_id FROM genres;";
	$genres = $mysqli->query($genre_query);
	if( $genres == false ) {
		echo $mysqli->error;
		exit();
	}

//rating
	$rating_query = "SELECT ratings.rating, ratings.rating_id FROM ratings;";
	$ratings = $mysqli->query($rating_query);
	if( $ratings == false ) {
		echo $mysqli->error;
		exit();
	}


//label
	$label_query = "SELECT labels.label_id, labels.label FROM labels";
	$labels = $mysqli->query($label_query);
	if( $labels == false) {
		echo $mysqli->error;
		exit();
	}

//format

	$format_query = "SELECT formats.format_id, formats.format FROM formats";
	$formats = $mysqli->query($format_query);
	if ( $formats == false ){
		echo $mysqli->error;
		exit();
	}

//sound

	$sound_query = "SELECT sounds.sound, sounds.sound_id FROM sounds";
	$sounds = $mysqli->query($sound_query);
	if ( $sounds == false ){
		echo $mysqli->error;
		exit();
	}

	$mysqli->close();

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add Form | DVD </title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<style>
		.form-check-label {
			padding-top: calc(.5rem - 1px * 2);
			padding-bottom: calc(.5rem - 1px * 2);
			margin-bottom: 0;
		}
	</style>
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item active">Add</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4 mb-4">Add a DVD</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">

		<form action="add_confirmation.php" method="POST">

			<div class="form-group row">
				<label for="title-id" class="col-sm-3 col-form-label text-sm-right">DVD Title: <span class="text-danger">*</span></label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="title-id" name="title">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="genre-id" class="col-sm-3 col-form-label text-sm-right">Genre:</label>
				<div class="col-sm-9">
					<select name="genre" id="genre-id" class="form-control">
						<option value="" selected>-- Select One --</option>

						<!-- Genre dropdown options here -->
						
						<?php while( $row = $genres->fetch_assoc() ) : ?>
							<option value="<?php echo $row['genre_id'] ?>"> <?php echo $row['genre'] ?> </option>
						<?php endwhile; ?>
						

					</select>
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="rating-id" class="col-sm-3 col-form-label text-sm-right">Rating:</label>
				<div class="col-sm-9">
					<select name="rating" id="rating-id" class="form-control">
						<option value="" selected>-- Select One --</option>

						<!-- Rating dropdown options here -->
						<?php while( $row = $ratings->fetch_assoc() ) : ?>
							<option value="<?php echo $row['rating_id'] ?>"> <?php echo $row['rating'] ?> </option>
						<?php endwhile; ?>

					</select>
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="label-id" class="col-sm-3 col-form-label text-sm-right">Label: </label>
				<div class="col-sm-9">
					<select name="label" id="label-id" class="form-control">
						<option value="" selected>-- Select One --</option>

						<!-- Label dropdown options here -->
						<?php while( $row = $labels->fetch_assoc() ) : ?>
							<option value="<?php echo $row['label_id'] ?>"> <?php echo $row['label'] ?> </option>
						<?php endwhile; ?>

					</select>
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="format-id" class="col-sm-3 col-form-label text-sm-right">Format:</label>
				<div class="col-sm-9">
					<select name="format" id="format-id" class="form-control">
						<option value="" selected>-- Select One --</option>

						<!-- Format dropdown options here -->
						<?php while ( $row = $formats->fetch_assoc() ) : ?>
							<option value = "<?php echo $row['format_id']?>"> <?php echo $row['format'] ?></option>
						<?php endwhile; ?>

					</select>
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="sound-id" class="col-sm-3 col-form-label text-sm-right">Sound: </label>
				<div class="col-sm-9">
					<select name="sound" id="sound-id" class="form-control">
						<option value="" selected>-- Select One --</option>

						<!-- Sound dropdown options here -->
						<?php while ( $row = $sounds->fetch_assoc() ) : ?>
							<option value = "<?php echo $row['sound_id'] ?>"> <?php echo $row['sound'] ?> </option>
						<?php endwhile; ?>

					</select>
				</div>
			</div> <!-- .form-group -->
			<div class="form-group row">
				<label for="award-id" class="col-sm-3 col-form-label text-sm-right">Award:</label>
				<div class="col-sm-9">
					<input type="text" class="form-control" id="award-id" name="award">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="date" class="col-sm-3 col-form-label text-sm-right">
					Date:
				</label>
				<div class="col-sm-9">
					<input type="date" class="form-control" id="date-id" name="date">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
					<button type="submit" class="btn btn-primary">Add</button>
					<button type="reset" class="btn btn-light">Reset</button>
				</div>
			</div> <!-- .form-group -->
		</form>
	</div> <!-- .container -->
</body>
</html>