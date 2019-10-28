<?php include "view/layout/header.php";?>
<div class="site-wrap">
    <div class="site-mobile-menu site-navbar-target">
        <div class="site-mobile-menu-header">
            <div class="site-mobile-menu-close mt-3">
                <span class="icon-close2 js-menu-toggle"></span>
            </div>
        </div>
        <div class="site-mobile-menu-body"></div>
    </div>

    <header class="site-navbar py-4 js-sticky-header site-navbar-target" style="padding-top:0px !important;" role="banner">

        <div class="container-fluid" style="background: #4267b2;">
            <div class="d-flex align-items-center" style="padding: 5px;">
                <div class="" align="center" style="width:100%; color:white;font-size:25px">Bangladesh Bureau of Educational Information and Statistics<br>Ministry of Education <h3 style="color:white;font-weight: bold">Master Trainer Pool</h3></div>

            </div>
        </div>
        <div class="container-fluid" style="background:white;">
            <div class="d-flex align-items-center">
                <div class="mx-auto text-center">
                    <nav class="site-navigation position-relative text-right" role="navigation">
                        <ul class="site-menu main-menu js-clone-nav mx-auto d-none d-lg-block  m-0 p-0">
                            <li><a style="color:black" href="#home-section" class="nav-link">Home</a></li>
                            <li><a style="color:black" href="#programs-section" class="nav-link">About This Innovation</a></li>
                            <li style="background:grey"><a target="_blank" href="src/images/guidelines.pdf"  style="color:#ffe000;" class="nav-link blink-me"><span><b>Instructions</b></span></a></li>
                            <li><a style="color:black" href="#contact-section" class="nav-link">Contact Us</a></li>
                        </ul>
                    </nav>
                </div>

                <div class="ml-auto w-25">
                    <nav class="site-navigation position-relative text-right" role="navigation">
                        <ul class="site-menu main-menu site-menu-dark js-clone-nav mr-auto d-none d-lg-block m-0 p-0">
                            <li class=""><a href="main/signup.php"  style="color:red;" class="nav-link"><span><b>Registration</b></span></a></li>
                            <li class=""><a href="main/login.php" class="nav-link"><span><b>Login</b></span></a></li>
                        </ul>
                    </nav>
                    <a href="#" class="d-inline-block d-lg-none site-menu-toggle js-menu-toggle text-black float-right"><span class="icon-menu h3"></span></a>
                </div>
            </div>
        </div>

    </header>

    <div class="intro-section" id="home-section">

        <div class="slide-1" style="background-image: url('src/images/hero_1.jpg');" data-stellar-background-ratio="0.5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="row align-items-center">
                            <div class="col-lg-6 mb-4" style="font-weight: bold !important;">
                                <h2  data-aos="fade-up" data-aos-delay="100" style="color:#efff00;">Grab Opportunity to Enroll yourself as a Master Trainer of BANBEIS</h2>
                                <p data-aos="fade-up" data-aos-delay="300"><a href="main/signup.php" class="btn btn-primary py-3 px-5 btn-pill">Register Now</a></p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="site-section" id="programs-section">
        <div class="container">
            <div class="row mb-5 justify-content-center">
                <div class="col-lg-7 text-center"  data-aos="fade-up" data-aos-delay="">
                    <h2 class="section-title">About This Innovation</h2>
                </div>
            </div>
            <div class="row mb-5 align-items-center">
                <div class="col-lg-7 mb-5" data-aos="fade-up" data-aos-delay="100">
                    <img src="src/images/k_share.jpg" alt="Image" class="img-fluid"  style="border-radius: 12%;">
                </div>
                <div class="col-lg-4 ml-auto" data-aos="fade-up" data-aos-delay="200">
                    <h2 class="text-black mb-4">Quality Teachers</h2>
                    <p class="mb-4" style="font-weight: normal; color:deeppink">Teaching is a Great Profession<br>
                        <span style="color:darkblue;font-size:25px;">Qualityful teachers are more Great!</span>
                        <br>
                       We find out greatest among greats<br>
                        <span style="color:darkblue;font-size:25px;">Try Yourself!</span>  </p>


                </div>
            </div>

            <div class="row mb-5 align-items-center">
                <div class="col-lg-7 mb-5 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="100">
                    <img src="src/images/undraw_teaching.svg" alt="Image" class="img-fluid">
                </div>
                <div class="col-lg-4 mr-auto order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
                    <h2 class="text-black mb-4">Increase Learning Habit</h2>
                    <p class="mb-4">Teaching through Multimedia Classroom increases cognitive power</p>



                </div>
            </div>

            <div class="row mb-5 align-items-center">
                <div class="col-lg-7 mb-5" data-aos="fade-up" data-aos-delay="100">
                    <img src="src/images/poor_student.jpeg" alt="Image" class="img-fluid" style="border-radius: 12%;">
                </div>
                <div class="col-lg-4 ml-auto" data-aos="fade-up" data-aos-delay="200">
                    <h2 class="text-black mb-4">Literacy Does matter</h2>
                    <p class="mb-4">Through Quality Master Trainers teachers are taught better</p>
                </div>
            </div>

        </div>
    </div>


    <div class="site-section bg-light" id="contact-section">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-7">



                    <h2 class="section-title mb-3">Message Us</h2>
                    <p class="mb-5">We are always ready to help you. Kindly text us and you will get reply soon.</p>

                    <form method="post" data-aos="fade">
                        <div class="form-group row">
                            <div class="col-md-6 mb-3 mb-lg-0">
                                <input type="text" class="form-control" placeholder="First name">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Last name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input type="text" class="form-control" placeholder="Subject">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input type="email" class="form-control" placeholder="Email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <textarea class="form-control" id="" cols="30" rows="10" placeholder="Write your message here."></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">

                                <input type="submit" class="btn btn-primary py-3 px-5 btn-block btn-pill" value="Send Message">
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php include "view/layout/footer.php";?>