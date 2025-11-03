<!doctype html>
<html lang="en">

<?= $this->include(THEME . 'block/header') ?>

<body>
    <section class="container-fluid1 mt-5 mb-5" data-aos="fade-up">

        <div class="row justify-content-center g-0 ">
            <div class="col-11">
                <h1 class="text-center mb-3 ">Get In Touch </h1>
                <div class="row justify-content-between align-items-center contactus  box-reverse rounded-3 ">

                    <div class="col-md-6 p-5 pt-2">
                        <div class="custom_row align-items-start g-2">
                            <h4>Contact Information</h4>
                            <p class="mb-4">For helpful advice, samples, and prices, please don't hesitate to
                                contact us by email, phone, or through the enquiry form.</p>

                            <span class="fs-5 font fw-bold"><i
                                    class="fa-solid fa-location-dot pe-3"></i>Address</span>
                            <div class="ms-5">
                                <p>10 Damson Way, Carshalton Beeches,<br>Surrey, United Kingdom</p>
                            </div>
                            <span class="fs-5 font fw-bold"><i class="fa-solid fa-envelope pe-3"></i>Email </span>
                            <div class="ms-5">
                                <p><a target="_blank" class="text-reset text-dark text-decoration-none"
                                        href="mailto:info@ampraish.co.uk">info@ampraish.co.uk</a></p>
                            </div>
                            <span class="fs-5 font fw-bold"><i class="fa-solid fa-phone pe-3"></i>Phone </span>
                            <div class="ms-5">
                                <p><a target="_blank" class="text-reset text-dark text-decoration-none"
                                        href="tel:+44 (0) 7717364224">+44
                                        (0)
                                        7717364224</a></p>
                            </div>
                        </div>

                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-5 p-md-5 p-sm-5">
                        <div class="card contactbox rounded-3">
                            <div class="card-body">
                                <div class="login_form p-3">

                                    <form action="<?= url('Home/contact') ?>" class="ajax-form-submit" method="post" id="contactusfrom">
                                        <div class="mb-4">
                                            <input
                                                class="form-control shadow-none border-0 border-bottom  border-1 rounded-0"
                                                type="text" placeholder="Name" name="name"
                                                aria-label="default input example" required>
                                        </div>
                                        <div class="mb-4">
                                            <input
                                                class="form-control shadow-none border-0 border-bottom  border-1 rounded-0"
                                                type="email" placeholder="Email" name="email"
                                                aria-label="default input example" required>
                                        </div>
                                        <div class="mb-4">
                                            <input
                                                class="form-control shadow-none border-0 border-bottom  border-1 rounded-0"
                                                type="tel" pattern="[0-9]{3}[0-9]{3}[0-9]{4}" name="mobile"
                                                placeholder="Phone No." aria-label="default input example" required>
                                        </div>
                                        <div class="mb-4">
                                            <input
                                                class="form-control shadow-none border-0 border-bottom  border-1 rounded-0"
                                                type="text" placeholder="Subject" name="subject"
                                                aria-label="default input example" required>
                                        </div>
                                        <div class="mb-4">
                                            <textarea
                                                class="form-control shadow-none border-0 border-bottom  border-1 rounded-0"
                                                placeholder="Message" name="message" id="floatingTextarea2"
                                                rows="3"></textarea>
                                        </div>
                                        <div class="mx-5 text-center my-3 ">


                                            <div class="form-group">
                                                <div class="tx-danger error-msg"></div>
                                                <div class="tx-success form_proccessing"></div>
                                            </div>
                                            <input class="form_button bg-primary btn text-white" id="save_data" type="submit" value="Submit">
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <?= $this->include(THEME . 'block/footer') ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        AOS.init({
            once: true,

        });
        $('.ajax-form-submit').on('submit', function(e) {
            $('#save_data').prop('disabled', true);
            $('.error-msg').html('');
           
            e.preventDefault();
            var aurl = $(this).attr('action');
            $.ajax({
                type: "POST",
                url: aurl,
                data: $(this).serialize(),
                success: function(response) {
                    if (response.st == 'success') {
                        Swal.fire("Success!", response.msg, "success");
                        $('.ajax-form-submit')[0].reset();
                    } else {
                        $('.form_proccessing').html('');
                        $('#save_data').prop('disabled', false);
                        $('.error-msg').html(response.msg);
                    }
                },
                error: function() {
                    $('#save_data').prop('disabled', false);
                    alert('Error');
                }
            });
            return false;
        });
    </script>
</body>

</html>