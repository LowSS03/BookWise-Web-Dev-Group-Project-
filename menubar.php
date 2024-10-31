<?php
    include 'dbConn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@1,700&display=swap" rel="stylesheet">
    <style>

        .nav{
            overflow: hidden;
            background: white;
            box-shadow: 0 2px 4px 0 rgba(0,0,0,.2);
            transition: top 0.3s;
        }

        .menubar1{
            background: white;
            height: 70px;
            align-items: center;
            justify-content: space-between;
        }

        .company_title {
            font-size: 30px;
            height: 50px;
            display: inline-block;
            vertical-align: bottom;
            list-style-type: none;
        }

        .btn2, .btn3, .btn4, .btn5, .btn6, .login {
            float: right;
            background: white;
            color: rgb(113, 113, 113);
            border: none;
            text-align: center;
            cursor: pointer;
            font-size: 16px;
            height: 29px;
            width: 100px;
            list-style-type: none;
            padding: 20px 0;
            text-decoration: none;
            font-family: 'Lato', sans-serif;
        }

        .btn9, .btn10{
            float: right;
            margin-right: 20px;
            background: white;
            border: none;
            text-align: center;
            cursor: pointer;
            font-size: 16px;
            height: 29px;
            width: 120px;
            list-style-type: none;
            padding: 20px 0;
            text-decoration: none;
            font-family: 'Lato', sans-serif;
        }

        .btn{
            text-decoration: none;
            color: grey;
            transition: all 0.5s ease-in-out;
        }

        .btn:hover{
            color: black;
        }

        .center{
            position: relative;
            margin-right: 700px;
            height: 70px;
            width: 70%;
            margin-top: -70px;
        }

        .btn2:hover, .btn3:hover, .btn4:hover,.btn5:hover, .btn6:hover, .login:hover{
            background: lightblue;
            text-decoration: none;
            border-radius: 50%;
            border: none;
            height: 30px;
            width: 100px;
            z-index: -1;
            transition: 0.5s;
            color: rgb(113, 113, 113);
        }

        .btn9:hover{
            background: lightgreen;
            text-decoration: none;
            border-radius: 50%;
            border: none;
            height: 30px;
            width: 130px;
            z-index: -1;
            transition: 0.5s;
        }

        .btn10:hover{
            background: rgb(223, 61, 61);
            text-decoration: none;
            border-radius: 50%;
            border: none;
            height: 30px;
            width: 130px;
            z-index: -1;
            transition: 0.5s;
        }

        .nav-link, #i{
            text-decoration: none;
            color: grey;
            transition: all 0.5s ease-in-out;
        }

        .nav-link:hover{
            color: black;
        }

        .fa-sign-out, .fa-user{
            color: grey;
        }

        .fa-user:hover, .fa-sign-out:hover{
            color: black;
        }

    </style>
</head>
<body>
    <nav class="nav">
        <div class="menubar1">
            <img src="image/logo5.png" height="60" width="60">
            <span class="company_title">BOOKWISE</span>
            <?php
                if (!empty($_SESSION['custID'])) {
                    ?>
                    <li class="btn10"><a class="nav-link" href="Logout.php">Log Out  🚪</a></li>
                    <li class="btn9"><a class="nav-link"  href="myAccount.php"><?php echo $_SESSION['custName']; ?>  😄</a></li>
                    <div class="center">
                        <li class="btn4"><a class="btn" href="ratings.php">Rating</a></li>
                        <li class="btn6"><a class="btn" href="viewBookingCustomer.php?custID=<?php echo $_SESSION['custID']; ?>">My Booking</a></li>
                        <li class="btn4"><a class="btn" href="roomListCard.php">Room</a></li>
                        <li class="btn5"><a class="btn" href="viewhotel.php">Hotel</a></li>
                        <li class="btn3"><a class="btn" href="aboutus.php">About Us<a></li>
                        <li class="btn2"><a class="btn" href="homepage.php">Home<a></li>
                    </div>
                    <?php
                }
                elseif (!empty($_SESSION['hotelID'])) {
                    ?>
                    <li class="btn10"><a class="nav-link" href="logout.php">Log Out  🚪</a></li>
                    <li class="btn9"><a class="nav-link" href="hotelProfile.php"><?php echo $_SESSION['hotelName']; ?>  🏨</a></li>
                    <div class="center">
                        <li class="btn6"><a class="btn" href="viewBooking.php?hotelID=<?php echo $_SESSION['hotelID']; ?>">Booking</a></li>
                        <li class="btn5"><a class="btn" href="roomList.php">Room</a></li>
                        <li class="btn4"><a class="btn" href="addroom.php">Add Room</a></li>
                        <li class="btn3"><a class="btn" href="aboutus.php">About Us<a></li>
                        <li class="btn2"><a class="btn" href="homepage.php">Home<a></li>
                    </div>
                    <?php
                }
                elseif (!empty($_SESSION['admin'])) {
                    ?>
                    <li class="btn10"><a class="nav-link" href="logout.php">Log Out  🚪</a></li>
                    <li class="btn9"><?php echo $_SESSION['admin']; ?>  👑</li>
                    <div class="center">
                        <li class="btn4"><a class="btn" href="adminViewBooking.php">Booking</a></li>
                        <li class="btn4"><a class="btn" href="adminViewRoom.php">Room</a></li>
                        <li class="btn5"><a class="btn" href="adminViewHotel.php">Hotel</a></li>
                        <li class="btn6"><a class="btn" href="adminViewCustomer.php">Customer</a></li>
                        <li class="btn3"><a class="btn" href="aboutus.php">About Us<a></li>
                        <li class="btn2"><a class="btn" href="homepage.php">Home<a></li>
                    </div>
                <?php
                }
                else {
                    echo '<li class="login"><a class="btn"href="signUp.php">Sign Up</a></li>';
                    echo '<li class="login"><a class="btn" href="login.php">Login</a></li>';
                    echo '<li class="btn3"><a class="btn" href="aboutus.php">About Us<a></li>';
                    echo '<li class="btn2"><a class="btn" href="homepage.php">Home<a></li>';
                }
                ?>
            </li>
    </div>
</nav>
    
</body>
</html>