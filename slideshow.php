<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css"/>
    <title>Document</title>
    <style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    .container{
        margin-top: 70px;
        width: 100%;
        height: 99vh;
        background: #222;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .swiper{
        width: 80%;
        height: fit-content;
    }

    .swiper-slide img{
        width: 100%;
    }

    .swiper .swiper-button-prev, .swiper-button-next{
        color: #fff;
    }

    .swiper .swiper-pagination-bullet-active{
        background: #fff;
    }


    .triangle{
        width: 0;
        height: 0;
        border-style: solid;
        border-width: 0 400px 800px 400px;
        border-color: transparent rgba(70, 70, 70) transparent transparent;
        opacity: 0.8;
        position: absolute;
        bottom: 0;
        right: 0;
        transform: rotate(90deg);
    }

/* Caption text */
    .t1 {
        text-align: center;
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

    .t2 {
        text-align: center;
        font-size: 16px;
        color: white;
        top: 80px;
        left: 220px;
        position: relative;
        width: 160px;
        height: 20px;
        margin: 0px;
        transform: rotate(270deg);
    }
    </style>
</head>
<body>
    <div class="contianer">
        <!-- Slider main container -->
        <div class="swiper">
        <!-- Additional required wrapper -->
            <div class="swiper-wrapper">
                <!-- Slides -->
                <div class="swiper-slide"><img src="image/Slideshow1.jpg">
                    <div class="triangle">
                        <h2 class="t1">Welcome to BookWise</h2>
                        <p class="t2">We are offer to the Hotel Owner and customer</p>
                    </div>
                </div>
                <div class="swiper-slide"><img src="image/Slideshow1.jpg">

                </div>
                <div class="swiper-slide"><img src="image/Slideshow1.jpg">

                </div>
                <div class="swiper-slide"><img src="image/Slideshow1.jpg">

                </div>
    ...
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
    </script>

</body>
</html>
