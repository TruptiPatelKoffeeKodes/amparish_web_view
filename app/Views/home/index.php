<!doctype html>
<html lang="en">

   <?= $this->include(THEME . 'block/header') ?>

    <body>
        <!-- nav section starts -->
      
        <!-- nav section ends -->
        <!-- banner section starts -->
        <div class="container-fluid ">
            <div class="container" style="padding-top: 2%;">
                <div class="row text-center1">
                    <div class="col-lg-8 d-flex align-items-center justify-content-center ">
                        <div class="box text-cente ">
                            <h1 class="font-head" data-aos="fade-right" data-aos-delay="400"
                                style="word-spacing: 6px;letter-spacing: 2px;">
                                Worldwide Specialists
                                in Heat Sealing Solutions</h1>
                            <h5 class="text-primary font-weight-light" data-aos="fade-left" data-aos-delay="400">A
                                global supplier of
                                superior quality heat
                                sealing bands for the
                                packaging, medical, and industrial markets.</h5>
                        </div>
                    </div>

                    <div class="col-lg-4 text-center">
                        <!-- <img src="images/belt1.jpg" class="img-fluid w-75 animatedUpDown "> -->
                        <img src="<?= ASSETS; ?>images/circle_image.png" alt="Profile Image" data-aos="zoom-in" data-aos-delay="400" class="circle-image">
                    </div>


                </div>
            </div>
        </div>
        <!-- banner section ends -->
        <div style="height:5vh"></div>

        <!-- about us section banner starts -->
        <section class="my-5" data-aos="fade-up">
            <div class="container">
                <h1 class=" text-center ">A Legacy of Quality & Precision </h1>
                <div class="row mt-5">
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <img src="<?= ASSETS; ?>images/Frame2.jpg" class="img" style="height: 250px;border-radius: 15px;">
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <p style="line-height: 25px;word-spacing: 5px;">
                            For over half a decade, we have specialized in consumables for heat sealing machines. Our
                            deep
                            and specialized experience has enabled us to gain a comprehensive understanding of the
                            diverse
                            and ever-evolving needs of our customers in the packaging and manufacturing industry.
                            Despite
                            serving numerous countries around the globe, our personal approach remains core to our
                            business.
                            We are here to share our knowledge and tailor solutions to your specific needs, however
                            exacting
                            they may be.
                        </p>
                        <button onclick="window.location.href='<?=url('contact')?>'"
                            class="btn btn-outline-primary btn-sm ">Know More</button>

                    </div>
                </div>
            </div>
        </section>
        <!-- about us section banner ends -->

        <div style="height:5vh"></div>

        <!-- our Product section starts   -->
        <section class="my-5" data-aos="fade-up">

            <div class="container">
                <h1 class="text-capitalize text-center ">Our Products </h1>
                <div class="row row-cols-1 row-cols-md-4 g-4 mt-2  ">
                    <div class="col">
                        <div class="card h-100 new-service-card">
                            <div class="service-card">
                                <div class="service-icon">
                                    <i class="fas fa-check-circle"></i>

                                </div>
                                <h4>Why Choose Us?</h4>
                                <p>Our high-quality stainless steel heat sealing machine bands are trusted and preferred
                                    by
                                    packaging professionals around the globe.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 new-service-card">
                            <div class="service-card">
                                <div class="service-icon">
                                    <i class="fa fa-puzzle-piece"></i>
                                </div>
                                <h4>Complete Product Assembly</h4>
                                <p>From sourcing components to final packaging, we offer complete assembly services to
                                    deliver a market-ready product.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 new-service-card">
                            <div class="service-card">
                                <div class="service-icon">
                                    <i class="fas fa-phone"></i>
                                </div>
                                <h4>Get In Touch</h4>
                                <p>For further information, please call
                                    <a class="text-reset text-dark text-decoration-none"
                                        href="tel:+44 (0) 7717364224">+44 (0) 7717364224</a>
                                    <br> or email us at
                                    <a target="_blank" class="text-reset text-dark text-decoration-none"
                                        href="mailto:pravin.shetty@ampraish.co.uk">pravin.shetty[@]ampraish.co.uk.</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card h-100 new-service-card">
                            <div class="service-card">
                                <div class="service-icon">
                                    <i class="fas fa-wrench"></i>
                                </div>
                                <h4>Additional Services</h4>
                                <p>We provide bespoke consultancy to our customer on how to get optimal output from our
                                    products in terms of durability, power consumption and heat management.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- our Product section ends   -->

        <div style="height:5vh"></div>

        <!-- footer section starts -->
         <?= $this->include(THEME . 'block/footer') ?>

        <!-- footer section ends -->


        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
            </script>

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->

        <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
        <script>
            AOS.init({
                once: true, // whether animation should happen only once - while scrolling down

            });
        </script>
    </body>

</html>