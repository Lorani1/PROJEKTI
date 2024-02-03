<?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "projekt";

    $data = mysqli_connect($host, $user, $password, $db);

    $sql = "SELECT * FROM aboutus";

    $result = mysqli_query($data, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="About)Us.css">
    <link rel="stylesheet" href="about.css">
    <title>About Us</title>
</head>
<body>
    <header>
        <h1>About Our Team</h1>
    </header>

    <?php

        while($info = $result->fetch_assoc()){
            {
        }
    
    ?>
    <section class="team-member">
        <img src="<?php echo $info['image']?>" alt="Person 1">
        <div class="member-info">
            <h2><?php echo $info['name']?></h2>
            <p><?php echo $info['position']?></p>
            <p><?php echo $info['description']?></p>
        </div>
    </section>
    <?php
        }
    ?>
</body>
</html>
