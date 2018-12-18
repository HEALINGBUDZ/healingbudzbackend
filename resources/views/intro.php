<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html lang="en">
    <head>
        <title> Intro | Healling Budz </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="css/style.css" />
        <link rel="shortcut icon" type="image/png" href="<?php echo asset('userassets/images/favicon.jpg') ?>"/>
    </head>
    <style>body {
            padding: 0px;
            margin: 0px;
            font-family: 'Lato', sans-serif;
        }
        .intro_overlay {
            background: rgba(0,0,0,0.8);
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            overflow: auto;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            -ms-box-sizing: border-box;
            -o-box-sizing: border-box;
        }
        .slide_one {
            background: #3a3a3a;
        }
        .slide_one .intro_top_section {
            background: #5c5c5c;
        }
        .slide_second {
            background: #0371ad;
        }
        .slide_second .intro_top_section{
            background: #0083cb;
        }
        .slide_third {
            background: #e4b000;
        }
        .slide_third .intro_top_section{
            background: #f4c62b;
        }
        .slide_fourth {
            background: #721d6f;
        }
        .slide_fourth .intro_top_section{
            background: #93268f;
        }
        .inner_top {
            display: flex;
            align-items: center;
        }
        .intro_box {
            text-align: center;
            max-width: 742px;
            width: 100%;
            margin: 0 auto;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%,-50%);
            -moz-transform: translate(-50%,-50%);
            -webkit-transform: translate(-50%,-50%);
            -ms-transform: translate(-50%,-50%);
            -o-transform: translate(-50%,-50%);
        }
        .intro_box .intro_top_section {
            padding: 20px 30px 30px 30px;
            min-height: 309px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            -ms-box-sizing: border-box;
            -o-box-sizing: border-box;
            position: relative;
        }
        .intro_box .intro_top_section .inner_top img {
            max-width: 100%;
            max-width: 250px;
            max-height: 150px;
        }
        .intro_box .intro_top_section .inner_top {
            display: -webkit-box;  /* OLD - iOS 6-, Safari 3.1-6, BB7 */
            display: -ms-flexbox;  /* TWEENER - IE 10 */
            display: -webkit-flex; /* NEW - Safari 6.1+. iOS 7.1+, BB10 */
            display: flex; 

            -webkit-box-align: center;
            -moz-box-align: center;
            -ms-flex-align: center;
            -webkit-align-items: center;
            align-items: center;

            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;

            justify-content: center;
            -ms-grid-row-align: auto;
            align-self: auto;

            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;

            height: 100%;    
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0px;
            top:0px;
        }
        .intro_box .intro_top_section h2 {
            font-size: 21px;
            font-weight: 900;
            color: #fff;
            margin: 20px 0 30px;
        }
        .intro_box .intro_bottom_section {
            padding: 10px 80px 50px 80px;
            min-height: 309px;
            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            -ms-box-sizing: border-box;
            -o-box-sizing: border-box;
        }
        .intro_box .intro_bottom_section h3 {
            font-size: 18px;
            color: #fff;
            font-weight: bold;
            line-height: 30px;
        }
        .intro_box .intro_bottom_section .intro_divider  {
            text-align: center;
        }
        .intro_box .intro_bottom_section .intro_divider span  {
            width: 122px;
            height: 2px;
            background-color: #fff;
            display: block;
            margin: 0 auto;
        }
        .intro_box .intro_bottom_section p {
            font-size: 15px;
            color: #fff;
            font-weight: 300;
            line-height: 22px;
        }
        .intro_box .intro_pagination {
            display: inline-block;
        }
        .intro_box .intro_pagination span {
            display: inline-block;
            border-radius: 50%;
            width: 13px;
            height: 13px;
            background-color: rgba(0,0,0,0.3);
            margin: 0 4px;
            cursor: pointer;
        }
        .intro_box .intro_pagination span.active {
            background-color: #fff;
        }
        .intro_box .intro_footer {
            position: absolute;
            bottom: 0px;
            left: 0px;
            width: 100%;
            padding: 15px 25px 25px 25px;

            box-sizing: border-box;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            -ms-box-sizing: border-box;
            -o-box-sizing: border-box;
        }
        #skip_intro_screen_mobile {
            display: none;
            color: #fff;
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;

        }
        .intro_box .intro_footer .intro_skip,
        .intro_box .intro_footer .intro_next_slide{
            font-size: 15px;
            color: #fff;
            font-weight: 400;
            cursor: pointer;
        }
        .intro_box .intro_footer .intro_skip{
            float: left;
        }
        .intro_box .intro_footer .intro_next_slide{
            float: right;
        }
        .intro_box .intro_slides {
            display: none;
        }



        @media screen AND (max-width: 745px), screen AND (max-height: 745px) {
            .intro_box {
                position: relative;
                left: 0px;
                top: 0px;
                transform: translate(0,0);
                -moz-transform: translate(0,0);
                -webkit-transform: translate(0,0);
                -ms-transform: translate(0,0);
                -o-transform: translate(0,0);
            }
            .intro_box .intro_top_section {
                min-height: inherit;
            }
            .intro_box .intro_bottom_section {
                padding: 10px 20px 50px 20px;
                min-height: inherit;
            }
            .intro_overlay {
                padding: 20px;
            }
            .intro_box .intro_top_section .inner_top {
                position: relative;
                display: block;
            }
            #skip_intro_screen_mobile {
                display: block;
            }
            #skip_intro_screen {
                display: none;
            }
        }

        @media screen AND (max-width: 479px){
            .intro_box .intro_top_section {
                padding: 20px 30px 15px 30px
            }
            .intro_box .intro_top_section h2 {
                font-size: 17px;
                margin: 20px 0 15px;
            }
        }</style>
    <body>

        <div class="intro_overlay" id="intro_screen">
            <div class="intro_box">
                <div class="intro_slides slide_one">
                    <div class="intro_top_section">
                        <div class="inner_top">
                            <h2>Welcome to Healing Budz</h2>
                            <img src="<?= asset('userassets/images/welcometohealingbudz.png') ?>" alt="Budz Map"/>
                        </div>
                    </div>
                    <div class="intro_bottom_section">
                        <h3>Back in the day you got everything you needed to know about cannabis from your cousin Tommy.</h3>
                        <div class="intro_divider"><span></span></div>
                        <p>Today's cannabis patients are part horticulturalist, part herbalist, and part chemist, but they are also passionate about sharing their knowledge. Our Budz are patients with stories to tell. The Healing Budz community connects you to decades of real life experience. Demystify cannabis and get all the answers you couldn't ask Tommy - privately and anonymously. </p>
                    </div>               
                </div> <!-- slide 1st -->
                <div class="intro_slides slide_second">
                    <div class="intro_top_section">
                        <div class="inner_top">
                            <h2>Live Q&A Forum</h2>
                            <img src="<?= asset('userassets/images/Live-Q&A-Forum.png') ?>" alt="Live Q&A Forum"/>
                        </div>
                    </div>
                    <div class="intro_bottom_section">
                        <h3>The Healing Budz Community has heard it all...</h3>
                        <div class="intro_divider"><span></span></div>
                        <p>So ask away and get quick answers to thousands of live questions on a range of plant science and healing topics. Answer questions on your area of expertise and earn points towards our rewards program!</p>
                    </div>               
                </div> <!-- slide 2nd -->
                <div class="intro_slides slide_third">
                    <div class="intro_top_section">
                        <div class="inner_top">
                            <h2>Strain User Reviews</h2>
                            <img src="<?= asset('userassets/images/Strain-User-Reviews.png') ?>" alt="Strain-User-Reviews.png"/>
                        </div>
                    </div>
                    <div class="intro_bottom_section">
                        <h3>Individualized strain reviews, powered by you, not a laboratory... </h3>
                        <div class="intro_divider"><span></span></div>
                        <p>From Acapulco Gold to White Widow, find your strain in our database with our individualized strain reviews, rankings on aroma, taste, potency, genetics, and health benefits. Powered by you, not a laboratory, in a language you can understand without a botany degree. Share your prize worthy bud photos, best growing techniques, mood, sensation, and effects.</p>
                    </div>               
                </div> <!-- slide 2nd -->
                <div class="intro_slides slide_fourth">
                    <div class="intro_top_section">
                        <div class="inner_top">
                            <h2>Budz Adz</h2>
                            <img src="<?= asset('userassets/images/buds-ads-l.svg') ?>" alt="Budz Map"/>
                        </div>
                    </div>
                    <div class="intro_bottom_section">
                        <h3>Find medical dispensaries, physicians, natural healers, smoke shops, glass artists, canna chefs...</h3>
                        <div class="intro_divider"><span></span></div>
                        <p>Discover your local canna community. Be in the know about upcoming deals, promotions, fun industry events, and educational seminars in just a few taps.</p>
                    </div>               
                </div> <!-- slide 1st -->
                <div class="intro_footer">
                    <a href="<?= asset('/wall') ?>" class="intro_skip" id="skip_intro_screen">Skip</a>
                    <div class="intro_pagination">
                        <span class="intro_page" onclick="currentSlide(1)"></span>
                        <span class="intro_page" onclick="currentSlide(2)"></span>
                        <span class="intro_page" onclick="currentSlide(3)"></span>
                        <span class="intro_page" onclick="currentSlide(4)"></span>
                    </div>
                    <span class="intro_next_slide" onclick="nextSlides(1)">Next</span>
                </div>
                <a href="<?= asset('/wall') ?>" class="intro_skip" id="skip_intro_screen_mobile">Skip</a>
            </div>
        </div>

        <script>

            var intro_screen = document.getElementById('intro_screen');
            if (intro_screen) {
                var skip_intro_screen = document.getElementById('skip_intro_screen');

//                skip_intro_screen.addEventListener('click', function () {
//                    intro_screen.style.display = 'none';
//                });

                var skip_intro_screen_mobile = document.getElementById('skip_intro_screen_mobile');

                skip_intro_screen_mobile.addEventListener('click', function () {
                    intro_screen.style.display = 'none';
                });

            }


            var slideIndex = 1;
            showSlides(slideIndex);

// Next/previous controls
            function nextSlides(n) {
                if (slideIndex == 4) {
                    window.location.href = "<?= asset('wall?sorting=Newest') ?>"
                } else {
                    showSlides(slideIndex += n);
                }
            }

// Thumbnail image controls
            function currentSlide(n) {
                showSlides(slideIndex = n);
            }

            function showSlides(n) {
                var i;
                var slides = document.getElementsByClassName("intro_slides");
                var dots = document.getElementsByClassName("intro_page");
                if (n > slides.length) {
                    slideIndex = 1
                }
                if (n < 1) {
                    slideIndex = slides.length
                }
                for (i = 0; i < slides.length; i++) {
                    slides[i].style.display = "none";
                }
                for (i = 0; i < dots.length; i++) {
                    dots[i].className = dots[i].className.replace(" active", "");
                }
                slides[slideIndex - 1].style.display = "block";
                dots[slideIndex - 1].className += " active";
            }
                    </script>        
    </body>
</html>