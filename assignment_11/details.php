<?php

	if ( !isset($_GET['id']) || empty($_GET['id']) ) {
		$error = "Invalid Track ID";
	}
	else {
		//open connection with the database
		
		require 'config/config.php';
		
		// DB Connection
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}

		$mysqli->set_charset('utf8');


		//although we have a track id, let's make sure it is a valid one
		$sql_id = "SELECT * FROM dvd_titles WHERE dvd_titles.dvd_title_id = " . $_GET['id'] . ";";
		$check = $mysqli->query($sql_id);
		if ( $check->num_rows == 0 ) {
			echo $mysqli->error;
			$error = "Invalid Track ID";
			$mysqli->close();
		}

		//the id is valid, display the results
		else {
		//design the query
			$sql = "SELECT dvd_titles.dvd_title_id, dvd_titles.title AS dvd_title, genres.genre, ratings.rating, labels.label, formats.format, sounds.sound, dvd_titles.award, dvd_titles.release_date 
				FROM dvd_titles
				LEFT JOIN genres ON dvd_titles.genre_id = genres.genre_id
				LEFT JOIN ratings ON dvd_titles.rating_id = ratings.rating_id
				LEFT JOIN labels ON dvd_titles.label_id = labels.label_id
				LEFT JOIN formats ON dvd_titles.format_id = formats.format_id
				LEFT JOIN sounds ON dvd_titles.sound_id = sounds.sound_id
				WHERE dvd_titles.dvd_title_id = " . $_GET['id'] . ";";

			$results = $mysqli->query($sql);

			//if there is an error with the results, store an error variable
			if ($results == false){
				$error = $mysqli->error;
			}

			$details = $results->fetch_assoc();
			$mysqli->close();
		}
	}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DVD Details | DVD Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
		<li class="breadcrumb-item active">Details</li>
	</ol>

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">DVD Details</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<div class="row mt-4">
			<div class="col-12">

				<?php if (isset($error) && !empty($error) ) : ?>
					<div class="text-danger font-italic"><?php echo $error ?></div>
				<?php else : ?>
					<table class="table table-responsive">

						<tr>
							<th class="text-right">Title:</th>
							<td> <?php echo $details['dvd_title'] ?> </td>
						</tr>

						<tr>
							<th class="text-right">Release Date:</th>
							<td> <?php if(!$details['release_date']) { echo "n/a";} else { echo $details['release_date'];} ?> </td>
						</tr>

						<tr>
							<th class="text-right">Genre:</th>
							<td> <?php if(!$details['genre']){echo "n/a";} else{echo $details['genre'];} ?> </td>
						</tr>

						<tr>
							<th class="text-right">Label:</th>
							<td> <?php if(!$details['label']){echo "n/a";} else{ echo $details['label'];} ?> </td>
						</tr>

						<tr>
							<th class="text-right">Rating:</th>
							<td> <?php if(!$details['rating']){echo "n/a";} else{echo $details['rating'];} ?> </td>
						</tr>

						<tr>
							<th class="text-right">Sound:</th>
							<td> <?php if(!$details['sound']){echo "n/a";} else{ echo $details['sound'];} ?> </td>
						</tr>

						<tr>
							<th class="text-right">Format:</th>
							<td> <?php if(!$details['format']){echo "n/a";} else{echo $details['format'];} ?> </td>
						</tr>

						<tr>
							<th class="text-right">Award:</th>
							<td> <?php if(!$details['award']){ echo "none";} else{ echo $details['award'];} ?> </td>
						</tr>

					</table>

				<?php endif; ?>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_results.php" role="button" class="btn btn-primary">Back to Search Results</a>

				<a href="edit_form.php?id=<?php echo $_GET['id']; ?>" class="btn btn-warning">Edit This Title</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>