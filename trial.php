
<!DOCTYPE html>
<html>
<head>

	<title>document</title>
	  <link rel="stylesheet"  href="format.css">
</head>
<body>

	<div class="wrapper">
		<header>
			<img src="photo-1599058917212-d750089bc07e.avif" class="background">
			<h1 class="title">SMART FILTER</h1>
        </header>




        <section>

        	
			<div class="box">
				<p class="desc">Select perfect shoe made for you by using smart technology that can differentiate between shoes based on pressure distribution of the area you are concerned with to decrease load on you therefore optimising your everyday comfort level.</p>

			
			<p class="p2">please answer the questions below:</p>
			 

			<form id="details" action="trial.php" method="get" onsubmit="return handleSubmit();">
			<div class="boxx2">
		    <div class="image-side">
			<div class="space">
				<label >Activities you intend it to use for?<br>
				<select name="activities"  id="activity" autocomplete="on">

			        <option value="all">All</option>
					<option value="basketball">Basketball</option>
					<option value="walking">Walking</option>
					<option value="running">Running</option>
					<option value="football">Football</option>
					
				</select>
			    </label><br>
			</div>


			<div class="space">
			    	<label>Select your shoe size<br>
					<select name="size" id="sizes" autocomplete="on">

				        <option value="all">All</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						
					</select>
				    </label><br>
			 </div>
			</div>


				<img src="heel.jpg" class="refrence">
			


			<div class="space afterimg">
			    	<label>Specific region of foot you are concerned with
			    		(For example:pain felt on a specific part after prolong use/record of previous injury in that region)?<br>
			    		
					<select name="region" class="lastq" id="regions" autocomplete="on">
				        <option value="all"date-image>All</option>
						<option value="heel">Heel</option>
						<option value="lat arch">Lat Arch</option>
						<option value="mid arch">Mid Arch</option>
						<option value="gt">GT</option>
					</select>
				    </label><br>
			</div>
			</div>
			
			</div>

			<input type="submit" name="confirm" value="Search" id="searching">


			</form>
        </section>


<?php

$db_server = "localhost:3307";
$db_user = "root";
$db_pass = "";
$db_name = "shoes";
$conn = "";

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db_name);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["confirm"])) {
    $activity = $_GET["activities"];
    $size = $_GET["size"];
    $region = $_GET["region"];

    if ($activity == "all" && $size == "all" && $region == "all") {
        $sql = "SELECT  S.name, S.image_path1, S.link, R.image_path, R.pressure
            FROM shoes AS S
            JOIN region AS R ON S.id = R.id
            JOIN sizes AS SI ON S.id = SI.id
            ORDER BY R.pressure ASC";
    }
     else if ($activity == "all" && $size == "all") {
        $sql = "SELECT  S.name, S.image_path1, S.link, R.image_path, R.pressure
            FROM shoes AS S
            JOIN region AS R ON S.id = R.id
            JOIN sizes AS SI ON S.id = SI.id
            WHERE R.region='$region' 
            ORDER BY R.pressure ASC";
    }

     else if ($activity == "all" && $region == "all") {
        $sql = "SELECT  S.name, S.image_path1, S.link, R.image_path, R.pressure
            FROM shoes AS S
            JOIN region AS R ON S.id = R.id
            JOIN sizes AS SI ON S.id = SI.id
            WHERE SI.size = $size  
            ORDER BY R.pressure ASC";
    }


     else if ($size == "all" && $region == "all") {
        $sql = "SELECT  S.name, S.image_path1, S.link, R.image_path, R.pressure
            FROM shoes AS S
            JOIN region AS R ON S.id = R.id
            JOIN sizes AS SI ON S.id = SI.id
            WHERE S.activity = '$activity'  
            ORDER BY R.pressure ASC";
    }

     else if ($activity == "all") {
        $sql = "SELECT  S.name, S.image_path1, S.link, R.image_path, R.pressure
            FROM shoes AS S
            JOIN region AS R ON S.id = R.id
            JOIN sizes AS SI ON S.id = SI.id
            WHERE R.region='$region'
            AND SI.size = $size 
            ORDER BY R.pressure ASC ";
    } 
     else if ($region == "all") {
        $sql = "SELECT  S.name, S.image_path1, S.link, R.image_path, R.pressure
            FROM shoes AS S
            JOIN region AS R ON S.id = R.id
            JOIN sizes AS SI ON S.id = SI.id
            WHERE S.activity = '$activity' 
            AND SI.size = $size 
            ORDER BY R.pressure ASC ";
    }

         else if ($size == "all") {
        $sql = "SELECT  S.name, S.image_path1, S.link, R.image_path, R.pressure
            FROM shoes AS S
            JOIN region AS R ON S.id = R.id
            JOIN sizes AS SI ON S.id = SI.id
            WHERE R.region='$region'
            AND S.activity = '$activity' 
            ORDER BY R.pressure ASC ";
    }

    else {
        $sql = "SELECT  S.name, S.image_path1, S.link,R.pressure,R.image_path
            FROM shoes AS S
            JOIN region AS R ON S.id = R.id
            JOIN sizes AS SI ON S.id = SI.id
            WHERE S.activity = '$activity'
            AND R.region = '$region'
            AND SI.size = $size
            ORDER BY R.pressure ASC";
    }

    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Query error: " . mysqli_error($conn);
    }

    echo '<h2>Recommended shoes:</h2>';
    echo "<br><hr>";

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="rlt">';
            
            echo '<div class="polaroid"><div class="result1"><a href="' . $row["link"] . '" target="_blank">' . '<img class="result_img" src="' . $row["image_path1"] . '"></a></div>';
            echo ' <div class="name"><a style="text-decoration=none;" href="' . $row["link"] . '"target="_blank">' . '<h2><u>' . $row["name"] . '</u></h2></a></div></div>';

            echo  '<div class=result2><p class="press_res1">Pressure distribution : ' . $row["pressure"] . '</p>' . '<img class="result_img2" src="' . $row["image_path"] . '"></div>';
            echo "</div><br><hr>";
        }
    }


    mysqli_close($conn);
    exit(); // Terminate script after processing the form data
}
?>



	</div>

</body>
</html>





