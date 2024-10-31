<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>
    <style>
        body{
            margin: 0;
        }

        .background-color1{
            background-color: black;
        }

        .footer{
            position: relative;
            height: 480px;
            width: 100%;
            left: 0;
            border-top-left-radius: 220px;
            background-image: url("image/footer-image.jpg");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            background-color: black;
        }

        .column4{
            position: absolute;
            height: 70%;
            width: 25%;
            top: 10%;
            margin-left: 5%;
        }

        .icon{
            letter-spacing: 20px;
        }

        .column5{
            position: absolute;
            height: 70%;
            width: 25%;
            top: 5%;
            margin-left: 40%;
            color: white;
            text-align: left;
        }

        .column6{
            position: absolute;
            height: 70%;
            width: 25%;
            top: 5%;
            margin-left: 70%;
            color: white;
            text-align: left;
        }

        .top{
            color: white;
        }

        .link{
            text-decoration: none;
            color: white;
            cursor: pointer;
            font-size: 20px;
        }

        .h5{
            text-decoration: underline;
            font-size: 35px;
        }

        #facebook{
            color: white;
            font-size: 35px;
        }

        .fa-map-marker, .fa-phone, .fa-envelope{
            color: white;
            font-size: 25px;
            height: 25px;
            width: 35px;
        }

        .bottom{
            top: 85%;
            position: relative;
            text-align: center;
            align-items: center;
            color: white;
        }

        .line{
            margin-left: 5%;
            height: 0px;
            width: 90%;
            border-style: solid;
            border-color: white;
            border-width: 1px;
        }



    </style>
</head>
<body>
<div class="background-color1">
    <div class="footer">
        <div class="row">
            <div class="column4">
                <div class="top">
                    <img src="image/logo4.png" style="height: 100px; width: 250px; border-radius: 15px;">
                    <h2>BookWise</h2>
                    <h3>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quo natus hic neque aliquam quia rerum et doloremque rem iure pariatur!</h3>
                </div>
                <br/>
                <br/>
                <div class="icon">
                    <a href="facebook"><i id="facebook" class="fa fa-facebook" aria-hidden="true"></i></a>
                    <a href="twitter"><i id="facebook" class="fa fa-twitter" aria-hidden="true"></i></a>
                    <a href="instagram"><i id="facebook" class="fa fa-instagram" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="column5">
                <h2 class="h5">Information</h2>
                <a class="link" href="aboutus.php">About Us</a>
            </div>
            <div class="column6">
                <h2 class="h5">Contact Us</h2>
                    <h4>📱+013-260 6290</h4>
                    <h4>📧bookwise@mail.com</h4>
                    <h4>📍Jalan Teknologi 5, Taman Teknologi Malaysia, 57000 Kuala Lumpur, Wilayah Persekutuan Kuala Lumpur</h4>
            </div>
        </div>
        <div class="bottom">
            <div class="line"></div>
            <p>© Copyright 2023 BookWise all rights reserved.</p>
        </div>
    </div>
    </div>
</body>
</html>