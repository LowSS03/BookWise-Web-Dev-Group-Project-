<?php
session_start();
include 'dbConn.php';

if(isset($_POST['loginBtn'])){
    $email = $_POST['inputEmail'];
    $password = $_POST['inputPassword'];

    $query = "SELECT * FROM customer WHERE customer_email='$email' AND password='$password'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result); //$row[0]; $row['email']
    $customercomp = mysqli_num_rows($result); //1 or 0

    $querycomp = "SELECT * FROM hotel WHERE hotel_email='$email' AND hotel_password='$password'";
    $resultcomp = mysqli_query($connection, $querycomp);
    $rowcomp = mysqli_fetch_array($resultcomp); //$row[0]; $row['email']   
    $hotelcomp = mysqli_num_rows($resultcomp); //1 or 0

    $admin = $email == "admin@gmail.com" && $password == "admin100";

    if ($customercomp == 1)
    {
        echo 'Record Found';
        $_SESSION['custID'] = $row['customer_id'];
        $_SESSION['custEmail'] = $row['customer_emsil'];
        $_SESSION['custName'] = $row['customer_name'];

        header("Location: homepage.php");
    }
    elseif ($hotelcomp == 1 ){
     
        $_SESSION['hotelID'] = $rowcomp['hotel_id'];
        $_SESSION['hotelEmail'] = $rowcomp['hotel_email'];
        $_SESSION['hotelName'] = $rowcomp['hotel_name'];

        header("Location: homepage.php");
    }
    elseif ($admin == 1){
        $_SESSION['admin'] = "Admin";

        header("Location: homepage.php");
    }
    else {
        echo '<script>alert("Invalid Email or Password!")</script>';
    }
}


mysqli_close($connection)
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        .bg-image {
            background-image: url("image/klcc1.jpg");
            filter: blur(6px);
            -webkit-filter: blur(2px);
            height: 100%; 
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .login-container {
            background-image: url("image/klcc1.jpg");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            color: white;
            font-weight: bold;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            height: 70%;
            width: 80%;
            padding: 20px;
            text-align: center;
        }

        .waviy {
            position: relative;
            text-align: left;
        }

        .waviy span {
            position: relative;
            display: inline-block;
            font-size: 80px;
            color: #fff;
            text-transform: uppercase;
            animation: flip 3s infinite;
            animation-delay: calc(.2s * var(--i))
        }

        @keyframes flip {
            0%,80% {
                transform: rotateY(360deg) 
            }
        }

        .input_text{
            border: 0;
            background: none;
            display: block;
            margin: 20px auto;
            text-align: center;
            border: 2px solid #3498db;
            padding: 14px 20px;
            width: 200px;
            outline: none;
            color: white;
            border-radius: 24px;
            transition: 0.25s;
        } 

        .input_text:focus{
            width: 280px;
            border-color: #2ecc71;
        }

        .input_text.has-value,
        .input_text:focus:not(:placeholder-shown) {
            color: white;
            background-color: transparent;
        }

        ::placeholder{
            color: white;
        }

        .box-container{
            margin-left: 600px;
            margin-top: -250px;
            position: relative;
            height: 400px;
            width: 500px;
            background: rgba(0, 0, 0, 0.5);
            border: white 1px;
        }

        .buttons {
            display: flex;
            width: 380px;
            gap: 10px;
            --b: 2px;   /* the border thickness */
            --h: 1.8em; /* the height */
            margin-left: 70px;
        }

        .buttons button {
            /*--_c: #88C100;*/
            --_c: #ffffff;
            flex: calc(1.25 + var(--_s,0));
            min-width: 50px;
            font-size: 15px;
            height: var(--h);
            cursor: pointer;
            color: var(--_c);
            border: var(--b) solid var(--_c);
            background: 
                conic-gradient(at calc(100% - 1.3*var(--b)) 0,var(--_c) 209deg, #0000 211deg) 
                border-box;
            clip-path: polygon(0 0,100% 0,calc(100% - 0.577*var(--h)) 100%,0 100%);
            padding: 0 calc(0.288*var(--h)) 0 0;
            margin: 0 calc(-0.288*var(--h)) 0 0;
            box-sizing: border-box;
            transition: flex .4s;
        }
        
        .buttons button + button {
            --_c: #FF003C;
            flex: calc(.75 + var(--_s,0));
            background: 
                conic-gradient(from -90deg at calc(1.3*var(--b)) 100%,var(--_c) 119deg, #0000 121deg) 
                border-box;
            clip-path: polygon(calc(0.577*var(--h)) 0,100% 0,100% 100%,0 100%);
            margin: 0 0 0 calc(-0.288*var(--h));
            padding: 0 0 0 calc(0.288*var(--h));
        }

        .buttons button:focus-visible {
            outline-offset: calc(-2*var(--b));
            outline: calc(var(--b)/2) solid #000;
            background: none;
            clip-path: none;
            margin: 0;
            padding: 0;
        }

        .buttons button:focus-visible + button {
            background: none;
            clip-path: none;
            margin: 0;
            padding: 0;
        }

        .buttons button:has(+ button:focus-visible) {
            background: none;
            clip-path: none;
            margin: 0;
            padding: 0;
        }

        button:hover,
        button:active:not(:focus-visible) {
            --_s: .75;
        }

        button:active {
            box-shadow: inset 0 0 0 100vmax var(--_c);
            color: #fff;
        }

        .tooltip {
            position: relative;
            display: inline-block;
            border-bottom: 1px dotted black;
            text-decoration: none;
            color: lightgreen;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: black;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px 0;
            top: 100%;
            left: 50%;
            margin-left: -60px; 
            /* Position the tooltip */
            position: absolute;
            z-index: 1;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
        }


    </style>
</head>
<body>
<div class="bg-image"></div>
    <div class="login-container">
    <form action="#" method="POST">
        <div class="waviy">
            <span style="--i:1">W</span>
            <span style="--i:2">E</span>
            <span style="--i:3">L</span>
            <span style="--i:4">C</span>
            <span style="--i:5">O</span>
            <span style="--i:6">M</span>
            <span style="--i:7">E</span>
            <span style="--i:8">!</span>
            <br/>
            <span style="--i:1">T</span>
            <span style="--i:2">O</span>
            <br/>
            <span style="--i:1">B</span>
            <span style="--i:2">O</span>
            <span style="--i:3">O</span>
            <span style="--i:4">K</span>
            <span style="--i:5">W</span>
            <span style="--i:6">I</span>
            <span style="--i:7">S</span>
            <span style="--i:8">E</span>
        </div>
        <div class="box-container">
            <div class="label_TextField">
                <br/>
                <input class="input_text" type="email" placeholder="Email" name="inputEmail" required><br/>
                <input class="input_text" type="password" placeholder="Password" name="inputPassword" required> <br/>
            </div>
            <br/>
            <div class="buttons">
                <button type="submit" value="login" name="loginBtn"><b> Login </b></button>
                <button type="button" value="cancel" name="cancelBtn" onclick="window.location.href='homepage.php'"><b>Cancel </b></button><br/>
            </div>
            <br/>
            <br/>
            <div class="signUp">
                Dont Have Account Yet? Click <a class="tooltip" href="signUp.php">Here
                    <span class="tooltiptext">Register Here</span>
                </a> TO Register An Account
            </div>
        </div>
    </form>
    </div>

    <script>
        const inputTextElements = document.querySelectorAll('.input_text');

        inputTextElements.forEach((input) => {
            input.addEventListener('input', function () {
                if (this.value !== '') {
                    this.classList.add('has-value');
                } else {
                    this.classList.remove('has-value');
                }
            });
        });
    </script>
</body>
</html>