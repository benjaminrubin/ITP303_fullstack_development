<?php 
	
	//first check if there are any errors with the id variable
	if ( !isset($_GET['id']) || empty($_GET['id']) ) {
		$error = "Invalid DVD ID. No DVD record deleted.";
	}
	else {
		//id is set and not empty, log into the database
	
		//open connection with the database
		require 'config/config.php';

		//connect to database
		$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
		}

		$mysqli->set_charset('utf8');

		$dvdID = $_GET['id'];

		//check to see if a game with that ID exists
		$sql = "SELECT title FROM dvd_titles WHERE dvd_title_id = " . $dvdID . ";";


		$check = $mysqli->query($sql);
		if( $check->num_rows == 0 ){
			$error = "Invalid DVD ID. No DVD record deleted.";
		}
		//the ID and associate game exists, delete the game
		else {

			$row = $check->fetch_assoc();
			$title = $row['title'];

			$sql = "DELETE FROM dvd_titles WHERE dvd_title_id = " . $dvdID . ";";
			$result = $mysqli->query($sql);
			if ( $result == false ){
				echo $mysqli->error;
				exit();
			}
		}

		$mysqli->close();
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Delete a Game | Footaball Schedule</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
		<li class="breadcrumb-item active">Delete</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Delete a DVD</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">

				<?php if(isset($error) && !empty($error) ) : ?>

				<div class="text-danger">
					<?php echo $error ?>
				</div>
			<?php else : ?>

				<div class="text-success">
					The DVD <?php echo "'" . $title . "'" ?> was successfully deleted..
				</div>
			<?php endif; ?>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_results.php" role="button" class="btn btn-primary">Back to Search Results</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>