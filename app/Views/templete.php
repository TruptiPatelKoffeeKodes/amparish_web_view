<?php
$request = \Config\Services::request();

$uri = $request->uri;
$c = $uri->getSegment(1);
if (!session('uid')) {
    header("Location: " . url('auth') . "");
    exit;
} else {
    if (!(@$_COOKIE['gcode'] && $_COOKIE['gcode'] == md5(GCODE)) && $c != 'auth') {

        header("Location: " . url('auth/google') . "");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?= ASSETS; ?>img/brand/favicon.ico">
    <title>Admin</title>
    <link rel="stylesheet" type="text/css" href="<?= ASSETS; ?>plugins/fontawesome-free/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= ASSETS; ?>plugins/ionicons/css/ionicons.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= ASSETS; ?>plugins/typicons.font/typicons.css" />
    <link rel="stylesheet" type="text/css" href="<?= ASSETS; ?>plugins/feather/feather.css" />
    <link rel="stylesheet" type="text/css" href="<?= ASSETS; ?>plugins/flag-icon-css/css/flag-icon.min.css" />

    <link rel="stylesheet" type="text/css" href="<?= ASSETS; ?>plugins/datatable/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= ASSETS; ?>plugins/datatable/responsivebootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/fixedheader/3.1.7/css/fixedHeader.dataTables.min.css" />
    <link rel="stylesheet" type="text/css"
        href="<?= ASSETS; ?>plugins/datatable/fileexport/buttons.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="<?= ASSETS; ?>css/style.css" />
    <link rel="stylesheet" type="text/css" href="<?= ASSETS; ?>css/custom-style.css" />
    <link rel="stylesheet" type="text/css" href="<?= ASSETS; ?>css/skins.css" type="text/css" />

    <link rel="stylesheet" type="text/css" href="<?= ASSETS; ?>plugins/select2/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?= ASSETS; ?>plugins/multipleselect/multiple-select.css">
    <link rel="stylesheet" type="text/css" href="<?= ASSETS; ?>plugins/sidebar/sidebar.css">

    <link rel="stylesheet" type="text/css" href="<?= ASSETS; ?>plugins/select2/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?= ASSETS; ?>plugins/multipleselect/multiple-select.css">
    <link rel="stylesheet" type="text/css"
        href="<?= ASSETS; ?>plugins/jquery.mCustomScrollbar/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" type="text/css" href="<?= ASSETS; ?>plugins/sidebar/sidebar.css">
    <link rel="stylesheet" type="text/css" href="<?= ASSETS; ?>plugins/sweet-alert/sweetalert2.min.css">

    <link rel="stylesheet" type="text/css" href="<?= ASSETS; ?>plugins/summernote/summernote-bs4.css">

    <style type="text/css">
    .dnone {
        display: none;
    }

    span.btn-coll.btn-secondary.btn-xs {
        margin: 7px;
        padding: 7px;
        border-radius: 50%;
        cursor: pointer;
    }

    div[data-toggle="open"] .fa.fa-plus {
        display: none;
    }

    div[data-toggle="close"] .fa.fa-minus {
        display: none;
    }

    .btn-attr.btn-secondary.btn-xs {
        margin: 1px;
        padding: 7px;
        cursor: pointer;
        width: auto;
        height: 100%;
        display: inline-block;
    }
    </style>
</head>

<body class="main-body">

    <!-- Loader -->
    <div id="global-loader">
        <img src="<?= ASSETS; ?>img/loader.svg" class="loader-img" alt="Loader">
    </div>
    <!-- End Loader -->

    <!-- Page -->
    <div class="page">

        <?= $this->include(THEME . 'block/header') ?>
        <div class="main-content pt-0">
            <div class="container">
                <?= $this->include(THEME . 'block/flashmsg') ?>

                <?= $this->renderSection('content') ?>
                <!-- <div class="modal fade colored-header colored-header-primary" id="fm_model" tabindex="-1" role="dialog"> -->
                <div class="modal fade colored-header colored-header-primary" id="fm_model" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header modal-header-colored">
                                <h3 class="modal-title "><span class="model_title"></span></h3>
                                <button class="close md-close" type="button" data-dismiss="modal"
                                    aria-hidden="true"><span class="mdi mdi-close"> </span></button>
                                <input id="fm_action" type="hidden" />
                            </div>
                            <div class="modal-body">

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?= $this->include(THEME . 'block/scripts') ?>

        <?= $this->renderSection('scripts') ?>
        <script>
        $('body').on('click', '[data-toggle="modal"]', function() {
            $($(this).data("target") + ' .modal-body').load($(this).attr("href"), function() {
                afterload();
            });

            $('.model_title').text($(this).data("title"));
            if ($(this).data("action") != undefined)
                $('#fm_action').val($(this).data("action"));

        });
        </script>
        <?= $this->include(THEME . 'block/footer') ?>
</body>

</html>