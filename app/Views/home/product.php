<!doctype html>
<html lang="en">

<?= $this->include(THEME . 'block/header') ?>

<body>
    <!-- nav section starts -->
   
    <!-- nav section ends -->
    <section class=" mt-5" data-aos="fade-up">

        <div class="row justify-content-center g-0 ">
            <!-- <div class="col-11"> -->
            <h1 class="text-center mb-3 ">Our Metallic Belts </h1>
            <div class="row justify-content-between align-items-center contactus  box-reverse rounded-3 mb-5">

                <div class="col-md-7 ">

                    <p class="subtitle1">We are a highly reliable global supplier of metallic belts known for
                        exceptional durability, performance and shortened lead times.</p>
                    <img class="img" src="<?= ASSETS; ?>images/Frame.jpg" alt="Metallic Belt 1">
                </div>
                <div class="col-sm-12 col-md-12 col-lg-5 p-md-5 p-sm-5">
                    <div class="card contactbox rounded-3">
                        <div class="card-body">
                            <div class="login_form p-3">

                                <h4 style="font-weight: bold;" class="mb-4">Engineered for Laminate Tube
                                    Manufacturing</h4>
                                <p class="mb-4">Our belts are designed with years of R&D to be suitable for
                                    induction heating,
                                    double induction heating (DIBS) and resistance heating (HS) of laminate and
                                    cosmetic tube
                                    production. The belt material and coating are carefully selected to optimise
                                    energy
                                    consumption and the heating provides no changeover between ABL and PBL on
                                    the
                                    double
                                    induction system. Our belts ensure high heat transfer and minimal friction,
                                    resulting in
                                    high-quality seaming on ABL, PBL, and metalised laminates. The overwhelming
                                    positive
                                    feedback and collaboration for our multinational customers speak to the
                                    quality
                                    and
                                    reliability of our belts real-world application.</p>

                                <ul class="feature-list" style="padding-left: 10px;">
                                    <li>
                                        <!-- <i class="fas fa-check"></i> -->
                                        <div>
                                            <strong>Broad Compatibility:</strong> We manufacture products in a
                                            range
                                            of lengths,
                                            widths, and thicknesses, compatible with all Swiss, Bulgarian, and
                                            Chinese machine
                                            suppliers, and suitable for machines operating at speeds from 60 to
                                            600
                                            TPM.
                                        </div>
                                    </li>
                                    <li>
                                        <!-- <i class="fas fa-check"></i> -->
                                        <div>
                                            <strong>Trusted by Industry Leaders:</strong> We are proud partners
                                            in
                                            developing
                                            belts for specific projects like 360-degree printed tubes and
                                            cost-reduction
                                            initiatives for leading oral care and luxury packaging brands.
                                        </div>
                                    </li>
                                    <li>
                                        <!-- <i class="fas fa-check"></i> -->
                                        <div>
                                            <strong>Value & Flexibility:</strong> We offer competitive pricing,
                                            flexible
                                            ordering, and significant volume discounts for yearly blanket orders
                                            to
                                            help you
                                            save on procurement costs.
                                        </div>
                                    </li>
                                </ul>

                                <div class="mt-4">
                                    <a href="<?=url('contact')?>" class="btn btn-outline-primary btn-sm">Discuss Your
                                        Requirements</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- </div> -->
    </section>
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