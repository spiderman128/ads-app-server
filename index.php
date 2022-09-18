<?php

require_once('dbconnection.php');

?>

<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no, shrink-to-fit=no">
<title>Invisible Lab BD</title>
<link rel="icon" type="image/png" href="/images/invisible_lab_logo.jpg">
<style>
	body {
		padding: 1rem;
		font-size: 1.2rem;
		font-family: 'Consolas', monospace;
	}
	
	.error-icon { 
        display: inline-block;
        width: 24px;
        height: 24px;
        vertical-align: -5px;
        margin-right: 8px;
        background: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAABmJLR0QA/wD/AP+gvaeTAAADLUlEQVRoge2ZTUtVQRjHf3OuN1K8QqbQVwgiItIrKWWmUWBBqz5A66iWfoFqldC6bYS1cBElgtfCFvmCGzdRURi2sCzIF0zvy5kWctSr5947L8+JFv5385y58/x/M3PmnpmBA1XWj+7uxl9Xsk1J5lBJNLrW13aKUD0CugCFYjbU3G3KTb+VziUOsNrTdi5Q6qWGxj2PCoHmRsP49LBkPlGAld5sV6D1KyBToYo4hBiAgflIohAiABbmI4lBeAM4mI8kAuEF4GE+kjeEM4CA+UheEE4AguYjOUNYAyRgPpIThBVAguYjWUMYA9iYT7Wf5fC9wbLYxsAdSjPvTFJZQQQmlax7Pr9pFotXOlQMrfe0XzepXBPAZdrozf1mtTkAWEBUBXCe8/m8Way6jCAqAni9sHG9HTMqBqoJEQvgu9rETRdtPwKRqkLsAxBZKuN6220EIlWEKAMQW+fjervgBQAVILYBVi+dOZHSegSBP6nYKeQ3ApHSoWJopTfbFQW2AVQpuB+zDXRTsQhhuFMOQyiVRJoG0oHWD6PC7il0QSoDULYSCfX+brUtdXZmoBygKJmhzHR+Q7JpgLCleaMEZQB6RDTF7hfZfQmtID2hXsyuwy6AVCk1gGZJLEVCU0jBGgS3o/I2QP2byXkdBOeBRZFMyYzAeoi61pibmosC+z6nV3s7jisdjgPHfDKpllZIH9oqFPLon96Du65R/Znc1OuyPHE1pSAEFWseqmxofCHUkWbqLl9F1TdQHB8lnP/i0gxUMQ81dmSuECrTRP3jp6ijLVuBYoE/t24Sfvpg0wzUMA819gOZscn3WgU9WL7YqdNtO+YB6tLUdffZNAEG5sFgR+YCEX5bAK3LYwtfTX8OhubBcE9sCxF+/sjm4AP090X08m8Kz55QHH1p8lOwMA+Wxyr/YHWyMg8OB1sJQlibB8ejxQQgnMyDx+GuIISzefA8XheA8DIPAhccHhDe5kHoiskBQsQ8CF7yWUCImQfha1YDCFHzkMBF99rF7Em0HkPRuufRqta6PzM+MyGZz+hTwkaNuam5ukB3KMVzYBlY1jCsVZCVNn+g/0F/AT6m6DyRY13uAAAAAElFTkSuQmCC') 50% 50% no-repeat;
        background-size: 100%;
	}
	
	.absolute-center {
	    text-align: center;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }
    
    @media screen and (max-width: 480px) {
        .absolute-center {
            transform: translate(-50%, -50%) scale(0.8);
        } 
    }
    
    @media screen and (max-width: 360px) {
        .absolute-center {
            transform: translate(-50%, -50%) scale(0.6);
        } 
    }
    
    @media screen and (max-width: 220px) {
        .absolute-center {
            transform: translate(-50%, -50%) scale(0.4);
        } 
    }
    
</style>

<div class="absolute-center">
    <img src="data:image/png;base64,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"/>
    <p style="font-size: 2rem">Invisible Lab BD</p>
</div>


<?php
if ( mysqli_num_rows(mysqli_query($conn, "SHOW TABLES LIKE 'users'")) == 1 ) {
    
    exit;
}

$sql_users_table = "CREATE TABLE users (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	fname VARCHAR(255) NOT NULL,
	mobile VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	ref VARCHAR(255) NOT NULL,
	did VARCHAR(255) NOT NULL,
	token VARCHAR(255) NOT NULL,
	balance INTEGER DEFAULT 0,
	i_click INTEGER DEFAULT 0,
	d_bonus INTEGER DEFAULT 0,
	t_ref INTEGER DEFAULT 0,
	pending INTEGER DEFAULT 0,
	today_spin INTEGER DEFAULT 0,
	spin_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	today_task INTEGER DEFAULT 0,
	task_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	today_task1 INTEGER DEFAULT 0,
	task_time1 TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	today_task2 INTEGER DEFAULT 0,
	task_time2 TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	today_task3 INTEGER DEFAULT 0,
	task_time3 TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	today_task4 INTEGER DEFAULT 0,
	task_time4 TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	reg_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql_users_table) === TRUE) {
	echo "✔️ USERS TABLE CREATED SUCCESSFULLY <br/>";
} else {
	die( "❌ Error: " . $conn->error . "<br/>" );
}
  
$sql_payments_table = "CREATE TABLE payments (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	mnumber VARCHAR(255) NOT NULL,
	number VARCHAR(255) NOT NULL,
	amount INTEGER DEFAULT 0,
	method VARCHAR(255) NOT NULL,
	status VARCHAR(255) NOT NULL DEFAULT 'Pending',
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql_payments_table) === TRUE) {
	echo "✔️ PAYMENTS TABLE CREATED SUCCESSFULLY <br/>";
} else {
    echo "❌ Error: " . $conn->error . "<br/>";
}

$sql_admins_table = "CREATE TABLE admins (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	username VARCHAR(255) NOT NULL,
	password VARCHAR(255) NOT NULL,
	date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql_admins_table) === TRUE) {
	echo "✔️ ADMIN TABLE CREATED SUCCESSFULLY <br/>";
	
	$sql_admin1 =  "INSERT INTO admins (username, password)
  	        VALUES ('invisible', '".md5('invisibleadmin')."'),('invisible', '".md5('Tahmid')."')";
    if ($conn->query($sql_admin1) === TRUE) {
	echo "✔️ ADMIN CREATED SUCCESSFULLY";
    } else {
    echo "❌ Error: " . $conn->error . "<br/>";
     }
} else {
    echo "❌ Error: " . $conn->error . "<br/>";
}

$sql_methods_table = "CREATE TABLE methods (
	id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	amount INTEGER DEFAULT 0,
	type VARCHAR(255) NOT NULL,
	hint VARCHAR(255) NOT NULL
)";

if ($conn->query($sql_methods_table) === TRUE) {
	echo "✔️ METHODS TABLE CREATED SUCCESSFULLY <br/>";
	
      
} else {
    echo "❌ Error: " . $conn->error . "<br/>";
}
$sql_admin4 =  "INSERT INTO methods (name, amount, type, hint)
  	        VALUES ('Recharge', '1000', 'number', 'Enter Recharge Number'),('Bkash', '5000', 'number', 'Enter Bkash Number')";
  	        
if ($conn->query($sql_admin4) === TRUE) {
	echo "✔️ METHODS  CREATED SUCCESSFULLY <br/>";
	
      
} else {
    echo "❌ Error: " . $conn->error . "<br/>";
}
//$token = MD5('1234');
$token = sha1('1234');

$sql_admin =  "INSERT INTO users (fname, mobile, password, ref, did, token)
  	        VALUES ('Admin', '1234', '".md5('12345678')."', 'Tahmid', 'ff28ba36e8e11718', '$token')";
if ($conn->query($sql_admin) === TRUE) {
	echo "✔️ ADMIN CREATED SUCCESSFULLY";
} else {
    echo "❌ Error: " . $conn->error . "<br/>";
}?>
