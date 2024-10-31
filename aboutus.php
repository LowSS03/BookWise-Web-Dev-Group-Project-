<?php
    session_start();
    include 'dbConn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Document</title>
    <style>
    @import url('https://fonts.googleapis.com/css2?family=Angry+Birds&display=swap');


        body, html{ 
            margin: 0;
        }

        .menubar{
            width: 100%;
            top: 0;
            position: absolute;
            left: 0;
            z-index: 9999;
            box-shadow: 0 2px 4px 0 rgba(0,0,0,.2);
        }

        .Row{
            margin-top: 70px;
            position: relative;
            height: 700px;
            width: 100%;
        }

        .word{
            text-align: center;
            position: absolute;
            height: 100%;
            width: 35%;
            margin-left: 0;
            background-image: url("image/background6.jpg");
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .word2{
            margin-top: 25%;
        }

        .word2 h1{
            font-family: 'Arial Black', cursive;
        }

        .word2 h2{
            font-family: 'Angry Birds', cursive;
            /* font-size: 16px; */
            font-weight: normal;
            color: #333;
        }

        .image{
            position: absolute;
            height: 100%;
            width: 65%;
            left: 35%;
            background-color: grey;
        }

        .aboutus-image{
            height: 100%;
            width: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .part1{
            position: relative;
            background-image: url("image/background1.jpg");
            background-attachment: fixed;
            width: 100%;
            height: 500px;
            display: flex;
            left: 0;
            right: 0;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .aboutus1{
            position: absolute;
            left: 37%;
            background-color: rgb(0, 0, 0, 0.7);
            height: 80%;
            width: 21%;
            color: white;
            padding-left: 20px;
            padding-right: 20px;
            border-style: solid;
            border-color: white;
            border-width: 2px;
            transition: all 0.8s ease;
            overflow: hidden;
            margin-top: 21px;
            text-align: center;
            z-index: 1;
        }

        .vision{
            position: absolute;
            left: 10%;
            background-color: rgb(0, 0, 0, 0.7);
            height: 80%;
            width: 21%;
            color: white;
            padding-left: 20px;
            padding-right: 20px;
            border-style: solid;
            border-color: grey;
            border-width: 2px;
            transition: all 0.8s ease;
            overflow: hidden;
            margin-top: 21px;
            text-align: left;
        }

        .mission{
            position: absolute;
            left: 64%;
            background-color: rgb(0, 0, 0, 0.7);
            height: 80%;
            width: 21%;
            color: white;
            padding-left: 20px;
            padding-right: 20px;
            border-style: solid;
            border-color: grey;
            border-width: 2px;
            transition: all 0.8s ease;
            overflow: hidden;
            text-align: right;
        }

        .p{
            letter-spacing: 3px;
        }

        .column1 {
            float: right;
            width: 33.3%;
            margin-bottom: 16px;
            box-sizing: inherit;
            margin-top: 20px;
        }

        .column2 {
            float: center;
            width: 33.3%;
            margin-bottom: 16px;
            box-sizing: inherit;
            margin-top: 20px;
        }

        .column3 {
            float: left;
            width: 33.3%;
            margin-bottom: 16px;
            box-sizing: inherit;
            margin-top: 20px;
        }

        .h2{
            font-size: 50px;
            font-family: DejaVu Sans Mono, monospace;
        }

        .h3{
            font-family: DejaVu Sans Mono, monospace;
            font-size: 30px;
        }

        .h4{
            font-family: Optima, sans-serif;
            font-size: 20px;
        }

        .u-line-1 {
            position: absolute;
            width: 100px;
            height: 15px;
            background-color: white;
            left: 33.85%;
            top: 60%;
            z-index: 2;
        }

        .u-line-2 {
            position: absolute;
            width: 100px;
            height: 15px;
            background-color: white;
            right: 36%;
            top: 60%;
            z-index: 2;
        }

        .container{
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-left: 0;
        }

        .image-container{
            background-image: url("image/background.webp");
            height: 100%;
            width: 100%;
            left: 0;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            text-align: center;
        }

        .column {
            float: left;
            width: 25%;
            margin-bottom: 16px;
            box-sizing: inherit;
            margin-top: 20px;
        }

        .title1{
            font-size: 50px;
            text-align: center;
            font-family: "Gill Sans Extrabold";
        }

        .our-team {
            font-family: tahoma;
            padding: 30px 0 40px;
            margin-bottom: 30px;
            background-color: #e3f5f0;
            text-align: center;
            overflow: hidden;
            position: relative;
            height: 450px;
            width: 300px;
            margin-left: 50px;
            border-radius: 8px;
            box-shadow: 0 7px 6px 0 rgba(0,0,0,.2);
        }

        .our-team .picture {
            display: inline-block;
            height: 200px;
            width: 200px;
            margin-bottom: 50px;
            z-index: 1;
            position: relative;
        }

        .our-team .picture::before {
            content: "";
            width: 100%;
            height: 0;
            border-radius: 50%;
            background-color: #1369ce;
            position: absolute;
            bottom: 135%;
            right: 0;
            left: 0;
            opacity: 0.9;
            transform: scale(3);
            transition: all 0.3s linear 0s;
        }

        .our-team:hover .picture::before {
            height: 100%;
        }

        .our-team .picture::after {
            content: "";
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: #1369ce;
            position: absolute;
            top: 0;
            left: 0;
            z-index: -1;
        }

        .our-team .picture img {
            width: 100%;
            height: auto;
            border-radius: 50%;
            transform: scale(1);
            transition: all 0.9s ease 0s;
        }

        .our-team:hover .picture img {
            box-shadow: 0 0 0 14px #f7f5ec;
            transform: scale(0.7);
        }

        .our-team .title {
            display: block;
            font-size: 15px;
            color: #4e5052;
            text-transform: capitalize;
        }

        .our-team .social {
            width: 100%;
            padding: 0;
            margin: 0;
            background-color: #1369ce;
            position: absolute;
            bottom: -100px;
            left: 0;
            transition: all 0.5s ease 0s;
        }

        .our-team:hover .social {
            bottom: 0;
        }

        .our-team .social li {
            display: inline-block;
        }

        .our-team .social li a {
            display: block;
            padding: 10px;
            font-size: 17px;
            color: white;
            transition: all 0.3s ease 0s;
            text-decoration: none;
        }

        .our-team .social li a:hover {
            color: #1369ce;
            background-color: #f7f5ec;
        }

        .name{
            font-size: 32px;
        }

    </style>
</head>
<body>
<div class="menubar">
    <?php include "menubar.php"; ?>
</div>

    <div class="part2">
        <div class="Row">
            <div class="word">
                <div class="word2">
                    <h1>BookWise</h1>
                    <h2>BookWise is a user-friendly hotel booking system that simplifies the process of finding and reserving the perfect accommodation. With a vast database of hotels, real-time availability updates, and intuitive filtering options, it offers a seamless experience for travelers. Choose BookWise for convenience, reliability, and a hassle-free hotel booking experience. Experience convenience, reliability, and peace of mind with BookWise as your trusted hotel booking system.</h2>
                </div>
            </div>
            <div class="image">
                <img class="aboutus-image" src="image/background5.jpg">
            </div>
        </div>
    </div>

    <div class="part1">
        <div class="row1">
            <div class="column1">
            <div class="u-line-1"></div>
            <div class="u-line-2"></div>
                <div class="aboutus1">
                    <h2 class="h2">About Us</h2>
                    <h3 class="h3">IMAGINING A WORLD WHERE PEOPLE CAN BELONG ANYWHERE</h3>
                </div>
            </div>
            <div class="column2">
                <div class="vision">
                    <h3 class="h3">Our Mission</h3>
                    <p class="p">We exist to serve organizations that are making a positive social impact. We bring teams of creative and technical talent together to help our clients achieve their mission.</p>
                </div>
            </div>
            <div class="column3">
                <div class="mission">
                    <h3 class="h3">Our Vision</h3>
                    <p class="p">We believe that great design and effective communication are key ingredients for improving our lives and the world around us.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="image-container">
            <h1 class="title1">Our Team</h1>
        <div class="row">
            <div class="column">
                <div class="our-team">
                    <div class="picture">
                        <img class="img-fluid" src="image/rose.webp">
                    </div>
                    <div class="team-content">
                        <h3 class="name">Low Sze Shun</h3>
                        <h4 class="title">Project Leader</h4>
                    </div>
                    <ul class="social">
                        <li><a href="https://codepen.io/collection/XdWJOQ/"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="https://codepen.io/collection/XdWJOQ/"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="https://codepen.io/collection/XdWJOQ/"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        <li><a href="https://codepen.io/collection/XdWJOQ/"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="column">
                <div class="our-team">
                    <div class="picture">
                        <img class="img-fluid" src="image/lisa.webp">
                    </div>
                    <div class="team-content">
                        <h3 class="name">Ling Xin Jie</h3>
                        <h4 class="title">System Analyst</h4>
                    </div>
                    <ul class="social">
                        <li><a href="https://codepen.io/collection/XdWJOQ/"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="https://codepen.io/collection/XdWJOQ/"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="https://codepen.io/collection/XdWJOQ/"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        <li><a href="https://codepen.io/collection/XdWJOQ/"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="column">
                <div class="our-team">
                    <div class="picture">
                        <img class="img-fluid" src="image/jennie.jpg">
                    </div>
                    <div class="team-content">
                        <h3 class="name">Loo Yih Leh</h3>
                        <h4 class="title">Programmer</h4>
                    </div>
                    <ul class="social">
                        <li><a href="https://codepen.io/collection/XdWJOQ/"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="https://codepen.io/collection/XdWJOQ/"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="https://codepen.io/collection/XdWJOQ/"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        <li><a href="https://codepen.io/collection/XdWJOQ/"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="column">
                <div class="our-team">
                    <div class="picture">
                        <img class="img-fluid" src="image/jisoo.webp">
                    </div>
                    <div class="team-content">
                        <h3 class="name">Lee Yung Keong</h3>
                        <h4 class="title">Programmer</h4>
                    </div>
                    <ul class="social">
                        <li><a href="https://codepen.io/collection/XdWJOQ/"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="https://codepen.io/collection/XdWJOQ/"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="https://codepen.io/collection/XdWJOQ/"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        <li><a href="https://codepen.io/collection/XdWJOQ/"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>
</body>
<footer>
    <div class="footer">
        <?php include "footer.php"; ?>
    </div>
</footer>
</html>