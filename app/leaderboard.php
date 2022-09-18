<?php
session_start();
require_once('includes/init.php');

if(!empty($_GET['cp']) && !empty($_GET['cge'])) {
    $_SESSION['cp'] = $_GET['cp'];
    $_SESSION['cge'] = $_GET['cge'];
}

if($_GET['app'] == 'main') {
	$_SESSION['main_app'] = "1";
}

$_SESSION['token'] = $_COOKIE['token'] ?? null;

 if ( !isset($_SESSION['token']) ) {
 	header('location: login.php?' . http_build_query($_GET));
 }

$token = $_SESSION['token'];

$user_data = get_user_by_token($conn, $token);

 if ( empty( $user_data ) ) header('location: login.php?' . http_build_query($_GET));
?>
<!DOCTYPE html>
<html>
<head>
	<title>Payments</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0,user-scalable=false">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
      
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@600&display=swap" rel="stylesheet">

	
    <link rel="stylesheet" href="css/style.css" >
    <style>
		<?php include 'css/custom-style.php' ?>
	</style>
</head>
<body class="bg-primary">  
<section class="topbar">
   <i style="font-family: 'Material Icons'; font-size: 80px;">leaderboard</i><br><br><br><br><br><br>
</section>

<div class="notice-bg">
<div class="notice-block"><section class="payments">
   <!-- <span style="color: black; font-family: 'Nunito', sans-serif;">Top 50 User's</span><br><br><center> -->
 <?php    
$sql = "SELECT * FROM users WHERE users.id > 1 ORDER BY balance DESC LIMIT 50";
if($result = mysqli_query($conn, $sql)){
    if(mysqli_num_rows($result) > 0){
        echo "<table id='leaderboard' class='mytable'>";
            echo "<tr class='trHead'>";
                echo "<th>Rank</th>";
                echo "<th>Name</th>";
                echo "<th>Balance</th>";
                echo "<th>Refer</th>";
            echo "</tr>";
        while($row = mysqli_fetch_array($result)){
            echo "<tr class='row'>";
                echo "<td></td>";
                echo "<td>" . $row['fname'] . "</td>";
                echo "<td>" . $row['balance'] . "</td>";
                echo "<td>" . $row['t_ref'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        // Free result set
        mysqli_free_result($result);
    } else{
        echo "No records matching your query were found.";
    }
} else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($conn);
}
 
// Close connection
mysqli_close($conn);
?>
</center>
 </section></div></div>
	<?php include 'developer.php'; ?>

</body>
</html><style>
 .mytable {
 counter-reset: serial-number; /* Set the serial number counter to 0 */
}
.mytable td:first-child:before {
 counter-increment: serial-number; /* Increment the serial number counter */
 content: counter(serial-number); /* Display the counter */
}</style>