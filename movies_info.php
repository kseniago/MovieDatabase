<?php

$nav_selected = "HOME";
$left_buttons = "NO";
$left_selected = "";

  include("./nav.php");
  global $db;

  if(isset($_GET['movie_id'])){

		$id = mysqli_real_escape_string($db, $_GET['movie_id']);


		$sqlMetadata = "SELECT * FROM movies 
		LEFT JOIN movie_media ON movies.movie_id = movie_media.movie_id
		LEFT JOIN movie_data ON movies.movie_id = movie_data.movie_id
		WHERE movies.movie_id = $id";

		$sqlProducer = "SELECT * FROM movies
		LEFT JOIN movie_people AS mp ON movies.movie_id = mp.movie_id
		LEFT JOIN people ON people.people_id = mp.people_id
		WHERE mp.role = 'Producer' AND movies.movie_id = $id";

		$sqlDirector = "SELECT * FROM movies
		LEFT JOIN movie_people AS mp ON movies.movie_id = mp.movie_id
		LEFT JOIN people ON people.people_id = mp.people_id
		WHERE mp.role = 'Director' AND movies.movie_id = $id";

		$sqlMusicDirector = "SELECT * FROM movies
		LEFT JOIN movie_people ON movie_people.movie_id = movies.movie_id
		LEFT JOIN people ON movie_people.people_id = people.people_id 
		LEFT JOIN song_people AS sp ON people.people_id = sp.people_id
		WHERE sp.role = 'Composer' AND movies.movie_id = $id";

		$sqlLeadActor = "SELECT * FROM movies
		LEFT JOIN movie_people AS mp ON movies.movie_id = mp.movie_id
		LEFT JOIN people ON people.people_id = mp.people_id
		WHERE mp.role = 'Lead Actor' AND movies.movie_id = $id";

		$sqlLeadActress = "SELECT * FROM movies
		LEFT JOIN movie_people AS mp ON movies.movie_id = mp.movie_id
		LEFT JOIN people ON people.people_id = mp.people_id
		WHERE mp.role = 'Lead Actress' AND movies.movie_id = $id";

		$sqlActors = "SELECT * FROM movies
		LEFT JOIN movie_people AS mp ON movies.movie_id = mp.movie_id
		LEFT JOIN people ON people.people_id = mp.people_id
		WHERE mp.role = 'Actor' AND movies.movie_id = $id";

		$sqlActresses = "SELECT * FROM movies
		LEFT JOIN movie_people AS mp ON movies.movie_id = mp.movie_id
		LEFT JOIN people ON people.people_id = mp.people_id
		WHERE mp.role = 'Actress' AND movies.movie_id = $id";

		$sqlComposer = "SELECT * FROM movies
		LEFT JOIN movie_people ON movie_people.movie_id = movies.movie_id
		LEFT JOIN people ON movie_people.people_id = people.people_id 
		LEFT JOIN song_people AS sp ON people.people_id = sp.people_id
		WHERE sp.role = 'Composer' AND movies.movie_id = $id";

		$sqlSongs = "SELECT * FROM movies
		LEFT JOIN movie_song ON movies.movie_id = movie_song.movie_id
		LEFT JOIN songs ON songs.song_id = movie_song.song_id
		WHERE movies.movie_id = $id";

		//get the query result
		$metadata = mysqli_query($db, $sqlMetadata);
		$peopleProducer =  mysqli_query($db, $sqlProducer);
		$peopleDirector = mysqli_query($db, $sqlProducer);
		$peopleMusicDirector = mysqli_query($db, $sqlMusicDirector);
		$peopleLeadActor = mysqli_query($db, $sqlLeadActor);
		$peopleLeadActress = mysqli_query($db, $sqlLeadActress);
		$peopleActors = mysqli_query($db, $sqlActors);
		$peopleActresses = mysqli_query($db, $sqlActresses);
		$peopleComposer = mysqli_query($db, $sqlComposer);
		$songs =  mysqli_query($db, $sqlSongs);

		//fetch result in array format
		$movieBasics = mysqli_fetch_assoc($metadata);
		$producer = mysqli_fetch_assoc($peopleProducer);
		$director = mysqli_fetch_assoc($peopleDirector);
		$musicDirector = mysqli_fetch_assoc($peopleMusicDirector);
		$composer = mysqli_fetch_assoc($peopleComposer);
		$leadActor = mysqli_fetch_assoc($peopleLeadActor);
		$leadActress = mysqli_fetch_assoc($peopleLeadActress);
		$actor = mysqli_fetch_assoc($peopleActors);
		$actress = mysqli_fetch_assoc($peopleActresses);
		$songBasics = mysqli_fetch_assoc($songs);

		mysqli_free_result($metadata);
		mysqli_free_result($peopleProducer);
		mysqli_free_result($peopleDirector);
		mysqli_free_result($peopleMusicDirector);
		mysqli_free_result($peopleLeadActor);
		mysqli_free_result($peopleLeadActress);
		mysqli_free_result($peopleActors);
		mysqli_free_result($peopleActresses);
		mysqli_free_result($peopleComposer);
		mysqli_free_result($songs);
		mysqli_close($db);

		function make_links_clickable($text){
			return preg_replace('!(((f|ht)tp(s)?://)[-a-zA-Zа-яА-Я()0-9@:%_+.~#?&;//=]+)!i', '<a href="$1">$1</a>', $text);
		}
  }
?>

<!DOCTYPE html>
<html>

	<div class="container center">
		<?php if($movieBasics): ?>
			<h2 style = "color: #01B0F1;">MOVIES</h3>
			<p><b>English name: </b><?php echo $movieBasics['english_name']; ?></p>
			<p><b>Original name: </b><?php echo $movieBasics['native_name']; ?></p>
			<p><b>Year produced: </b><?php echo $movieBasics['year_made']; ?></p>
			<p><b>Country: </b><?php echo $movieBasics['country']; ?></p>
			<p><b>Language: </b><?php echo $movieBasics['language']; ?></p>
			<p><b>Genre: </b><?php echo $movieBasics['genre']; ?></p>
			<p><b>Plot: </b><?php echo $movieBasics['plot']; ?></p>
		<?php else: ?>
			<h5>No such movie exists.</h5>
		<?php endif ?>
	</div>

	<div class="container center">
		<h2 style = "color: #01B0F1;">PEOPLE</h3>
		<?php if($producer): ?>
			<p><b>Producer: </b><?php echo $producer['stage_name']; ?></p>
		<?php elseif($director): ?>
			<p><b>Director: </b><?php echo $director['stage_name']; ?></p>
		<?php elseif($musicDirector): ?>
			<p><b>Music Director: </b><?php echo $musicDirector['stage_name']; ?></p>
		<?php elseif($leadActor): ?>
			<p><b>Lead Actor: </b><?php echo $leadActor['stage_name']; ?></p>
		<?php elseif($leadActress): ?>
			<p><b>Lead Actress: </b><?php echo $leadActress['stage_name']; ?></p>
		<?php elseif($actor): ?>
			<p><b>Actors: </b><?php echo $actor['stage_name']; ?></p>
		<?php elseif($actress): ?>
			<p><b>Actresses: </b><?php echo $actress['stage_name']; ?></p>
		<?php endif ?>
	</div>

	<div class="container center">
		<h2 style = "color: #01B0F1;">SONGS</h3>
		<?php if($songBasics): ?>
			<p><b>Title: </b><?php echo $songBasics['title']; ?></p>
			<p><b>Lyrics: </b><?php echo $songBasics['lyrics']; ?></p>
			<p><b>Theme: </b><?php echo $songBasics['theme']; ?></p>
		<?php endif ?>
	</div>
</html>
