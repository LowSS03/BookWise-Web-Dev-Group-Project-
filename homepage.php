<?php
session_start();
include 'dbConn.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>
    <title>Document</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
        }

        .menubar{
            width: 100%;
            top: 0;
            position: relative;
            left: 0;
            z-index: 9999;
            box-shadow: 0 2px 4px 0 rgba(0,0,0,.2);
        }

        .container{
            margin-top: 70px;
            width: 100%;
            height: 100%;
            background: #222;
            display: flex;
            align-items: center;
            justify-content: center;
            left: 0;
        }

        .swiper{
            margin-top: 0px;
            width: 100%;
            height: 750px;
            left: 0;
        }

        .swiper-slide img{
            width: 100%;
        }

        .swiper .swiper-button-prev, .swiper-button-next{
            color: #fff;
        }

        .swiper .swiper-pagination-bullet-active{
            background: #fff;
            position: relative;
            z-index: 9999;
        }

        .triangle{
            position: absolute;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 400px 800px 400px;
            border-color: transparent rgba(70, 70, 70) transparent transparent;
            opacity: 0.8;
            bottom: 0;
            right: 0;
            transform: rotate(90deg);
        }

    /* Caption text */
        .t1 {
            text-align: center;
            letter-spacing: 8px;
            font-size: 35px;
            color: white;
            top: 250px;
            left: 220px;
            position: relative;
            width: 40px;
            height: 130px;
            margin: 0px;
            padding: 0px 20px 30px 0px;
            transform: rotate(270deg);
            animation: text 2s 1;
        }

        .t2 {
            text-align: left;
            letter-spacing: 5px;
            font-size: 16px;
            color: white;
            top: 90px;
            left: 120px;
            position: relative;
            width: 400px;
            height: 20px;
            margin: 0px;
            transform: rotate(270deg);
            animation: text 3s 0;
        }

        .center-rec{
            position: absolute;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 350px 350px 0 0;
            border-color: transparent rgba(70, 70, 70, 0.6) transparent transparent;
            top: 10%;
            left: 10%;
            transform: rotate(90deg);
        }

        .t3 {
            text-align: left;
            letter-spacing: 8px;
            font-size: 45px;
            color: white;
            top: -260px;
            left: 10px;
            position: relative;
            width: 290px;
            height: 200px;
            margin: 0px;
            transform: rotate(270deg);
        }

        .t4 {
            text-align: left;
            letter-spacing: 5px;
            font-size: 16px;
            color: white;
            top: -415px;
            left: 50px;
            position: relative;
            width: 400px;
            height: 20px;
            margin: 0px;
            transform: rotate(270deg);
        }

        .center-rec,
        .t3,
        .t4 {
            opacity: 0;
        }

        .center-rec.animate,
        .t3.animate,
        .t4.animate {
            animation: fadeIn 2s forwards;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
                color: black;
                margin-bottom: -40px;
            }
            50%{
                letter-spacing: 10px;
                margin-bottom: -40px;
            }
            100% {
                opacity: 1;
                letter-spacing: 5px;
            }
        }

        .rectangular{
            position: absolute;
            height: 300px;
            width: 650px;
            background-color: rgba(0, 0, 0, 0.6);
            top: 30%;
            left: 31%;
            text-align: center;
        }

        .t5 {
            text-align: center;
            letter-spacing: 8px;
            font-size: 45px;
            color: white;
            position: relative;
            height: 130px;
            margin-left: 20px;
            padding: 0px 20px 30px 0px;
        }

        .t6 {
            text-align: center;
            letter-spacing: 5px;
            font-size: 16px;
            color: white;
            left: 190px;
            position: relative;
            width: 400px;
            height: 20px;
            margin-top: -80px;
            margin-left: -65px;
        }

        .rectangular,
        .t5,
        .t6 {
            opacity: 0;
        }

        .rectangular.animate,
        .t5.animate,
        .t6.animate {
            animation: swipeIn 2s forwards;
        }

        @keyframes swipeIn{
            0% {
                color: black;
                opacity: 0;
            }
            50% {
                opacity: 0.5;
                color: grey;
                letter-spacing: 10px;
            }

            100% {
                opacity: 1;
                letter-spacing: 5px;
            }
        }

        .triangle2{
            position: absolute;
            width: 0;
            height: 0;
            border-style: solid;
            border-width: 0 400px 800px 400px;
            border-color: transparent rgba(0, 0, 0, 0.6) transparent transparent;
            bottom: 0;
            right: 0;
            transform: rotate(90deg);
        }

        .t7 {
            text-align: center;
            letter-spacing: 8px;
            font-size: 35px;
            color: white;
            top: 180px;
            left: 200px;
            position: relative;
            width: 40px;
            height: 130px;
            margin: 0px;
            padding: 0px 20px 30px 0px;
            transform: rotate(270deg);
        }

        .t8 {
            text-align: left;
            letter-spacing: 5px;
            font-size: 16px;
            color: white;
            top: 70px;
            left: 200px;
            position: relative;
            width: 400px;
            height: 130px;
            margin: 0px;
            transform: rotate(270deg);
        }

        .triangle2,
        .t7,
        .t8 {
            opacity: 0;
        }

        .triangle2.animate,
        .t7.animate,
        .t8.animate {
            animation: swipeIn2 3s forwards;
        }

        @keyframes swipeIn2 {
            0% {
                color: black;
                opacity: 0;
            }
            50% {
                opacity: 0.5;
                color: grey;
                letter-spacing: 10px;
            }

            100% {
                opacity: 1;
                letter-spacing: 5px;
            }
        }

        .bg-image {
            box-sizing: border-box;
            margin-top: 80px;
            height: 90%; 
            width: 90%;
            margin-left: 5%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        .img1 { 
            background-image: url("image/hotel2.jpg"); 
        }

        .box1{
            position: absolute;
            left: 4.9%;
            background-color: transparent;
            height: 45%;
            width: 19.9%;
            color: white;
            padding-left: 20px;
            padding-right: 20px;
            border-style: solid;
            border-color: white;
            border-width: 1px;
            transition: all 0.8s ease;
            overflow: hidden;
        }

        .box2{
            position: absolute;
            left: 27.5%;
            background-color: transparent;
            height: 45%;
            width: 19.9%;
            color: white;
            padding-left: 20px;
            padding-right: 20px;
            border-style: solid;
            border-color: white;
            border-width: 1px;
            transition: all 0.8s ease;
            overflow: hidden;
        }

        .box3{
            position: absolute;
            left: 50%;
            background-color: transparent;
            height: 45%;
            width: 19.9%;
            color: white;
            padding-left: 20px;
            padding-right: 20px;
            border-style: solid;
            border-color: white;
            border-width: 1px;
            transition: all 0.8s ease;
            overflow: hidden;
        }

        .box4{
            position: absolute;
            left: 72.5%;
            background-color: transparent;
            height: 45%;
            width: 19.9%;
            color: white;
            padding-left: 20px;
            padding-right: 20px;
            border-style: solid;
            border-color: white;
            border-width: 1px;
            transition: all 0.8s ease;
            overflow: hidden;
        }

        .text1{
            padding: 50px 20px;
            text-align: center;
            color: white;
            display: none;
            font-size: 40px;
            font-weight: 700;
            letter-spacing: 8px;
            margin-bottom: 20px;
            background: rgba(13, 12, 21);
            position: relative;
            animation: text 2s 1;
        }

        .text2{
            margin-top: -30px;
            text-align: center;
            display: none;
            font-size: 20px;
            letter-spacing: 3px;
            color: #6ab04c;
        }

        .box1:hover, .box2:hover, .box3:hover, .box4:hover{
            width: 19.9%;
            cursor: pointer;
            background-color: rgba(13, 12, 21, 0.8);
        }

        @keyframes text {
            0%{
                color: black;
                margin-bottom: -40px;
            }
            30%{
                letter-spacing: 20px;
                margin-bottom: -40px;
            }
            85%{
                letter-spacing: 8px;
                margin-bottom: -40px;
            }
        }

        .footer{
            margin-top: 5%;
        }

        audio::-webkit-media-controls-timeline,
        video::-webkit-media-controls-timeline {
            display: none;
        }
        audio::-webkit-media-controls,
        video::-webkit-media-controls {
            display: none;
        }

        video{
            width: 100%;
        }

    </style>
</head>
<body>
<div class="menubar">
    <?php include "menubar.php"; ?>
</div>

<div class="contianer">
        <!-- Slider main container -->
        <div class="swiper">
        <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                <div class="swiper-slide"><video autoplay muted loop><source src="image/video.mp4" type="video/mp4"></video>
                    <div class="triangle">
                        <h2 class="t1">Unforgettable Moments Await</h2>
                        <p class="t2">Experience Unforgettable Moments in Our Exquisite Handpicked Hotels.</p>
                    </div>
                </div>

                <div class="swiper-slide"><img src="image/slideshow2.jpg">
                    <div class="center-rec">
                        <h2 class="t3">Luxury & Comfort Combined</h2>
                        <p class="t4">Luxury, Comfort, and Elegance Combined for Your Ultimate Indulgence.</p>
                    </div>
                </div>

                <div class="swiper-slide"><img src="image/slideshow3.jpg">
                    <div class="rectangular">
                        <h2 class="t5">Discover Your Ideal Getaway</h2>
                        <p class="t6">Find Your Ideal Getaway in our Diverse Collection of Unique Hotels.</p>
                    </div>
                </div>

                <div class="swiper-slide"><img src="image/slideshow5.jpg">
                    <div class="triangle2">
                        <h2 class="t7">Effortless Booking, Endless Possibilities</h2>
                        <p class="t8">Effortless Booking, Endless Possibilities - Your Perfect Stay Awaits.</p>
                    </div>
                </div>
            </div>
            <!-- If we need pagination -->
            <div class="swiper-pagination"></div>

            <!-- If we need navigation buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>

    <script>
        const swiper = new Swiper('.swiper', {
            autoplay: {
                delay: 5000,
                disableOnIntercation: false,
            },
            loop: true,

            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },

            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },

        });

        swiper.on('slideChange', function () {
            var activeIndex = swiper.activeIndex;

            if (activeIndex === 1) {
                var centerRec = document.querySelector('.center-rec');
                var t3 = document.querySelector('.t3');
                var t4 = document.querySelector('.t4');

                centerRec.classList.add('animate');
                t3.classList.add('animate');
                t4.classList.add('animate');
            } 
            else if (activeIndex === 2) {
                var rectan = document.querySelector('.rectangular');
                var t5 = document.querySelector('.t5');
                var t6 = document.querySelector('.t6');

                rectan.classList.add('animate');
                t5.classList.add('animate');
                t6.classList.add('animate');
            }
            else if (activeIndex === 3) {
                var tri2 = document.querySelector('.triangle2');
                var t7 = document.querySelector('.t7');
                var t8 = document.querySelector('.t8');

                tri2.classList.add('animate');
                t7.classList.add('animate');
                t8.classList.add('animate');
            }
            });

    </script>

<div class="bg-image img1">
        <div class="box1" onmouseenter="showText(this)" onmouseleave="hideText(this)">
            <span class="text1">Design</span><br>
            <span class="text2">Sleek Design for Effortless Navigation</span>
        </div>

        <div class="box2" onmouseenter="showText(this)" onmouseleave="hideText(this)">
            <span class="text1">Ease of Use</span><br>
            <span class="text2">User-Friendly Interface for Seamless Booking</span>
        </div>

        <div class="box3" onmouseenter="showText(this)" onmouseleave="hideText(this)">
            <span class="text1">Hotel</span><br>
            <span class="text2">Explore a Wide Selection of 100+ Hotels</span>
        </div>

        <div class="box4" onmouseenter="showText(this)" onmouseleave="hideText(this)">
            <span class="text1">Booking</span><br>
            <span class="text2">Instant Confirmation for Hassle-Free Reservations</span>
        </div>
    </div>
    
    <script>
    function showText(box) {
        var textElements = box.querySelectorAll(".text1, .text2");
        textElements.forEach(function(element) {
            element.style.display = "block";
        });
    }

    function hideText(box) {
        var textElements = box.querySelectorAll(".text1, .text2");
        textElements.forEach(function(element) {
            element.style.display = "none";
        });
    }

    </script>

</body>
<footer>
    <div class="footer">
        <?php include "footer.php"; ?>
    </div>
</footer>
</html>