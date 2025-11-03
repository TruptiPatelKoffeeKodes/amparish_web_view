 <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="<?= ASSETS; ?>images/logo (1).png" type="image/x-icon">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&display=swap" rel="stylesheet">
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-xwQgDEsFsdgWmN/5Yp52M/zbrh4CX6E1FOT6PWZXzAMFYiW8jpiR5f87/v9PP6HQbXA8+7F2jG4/+7dgBnELGQ==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->


        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
        <!-- css stylesheet -->
        <link href="<?= ASSETS; ?>css/style.css" rel="stylesheet">

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
            rel="stylesheet">
        <style>
            .font-head {
                font-family: "Raleway", sans-serif;
                font-optical-sizing: auto;
                font-weight: 900;
                font-style: normal;
            }
        </style>
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">


        <title>Ampraish</title>
    </head>
      <div class="container-fluid banner py-5">
            <nav class="navbar navbar-expand-lg pt-4">
                <div class="container" style="padding-top: 1%;">
                    <a class="navbar-brand" href="<?=url('')?>">
                        <img src="<?= ASSETS; ?>images/logo (1).png" class="logo">
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fa-solid fa-bars text-white"></i>
                    </button>

                    <div class="collapse navbar-collapse pt-2 pt-lg-5" id="navbarNav">
                        <ul class="navbar-nav ms-auto">
                            <li class="nav-item px-3">
                                <a class="nav-link text-dark active" aria-current="page" href="<?=url('')?>">Home</a>
                            </li>
                            <li class="nav-item px-3">
                                <a class="nav-link text-dark" href="<?=url('product')?>">Product</a>
                            </li>
                            <li class="nav-item px-3">
                                <a class="nav-link text-dark " href="<?=url('contact')?>">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>