<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Example Serverside DataTable Using CodeIgniter4-DataTable Library</title>

    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <!-- DataTables CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap4.min.css">
</head>

<body>
    <div class="container">
        <h1 style="font-size:20pt">Example Serverside DataTable Using CodeIgniter4-DataTable Library</h1>
        <h3>Customers Data</h3>
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>id</th>
                    <th>asin</th>
                    <th>sku </th>
                    <th>product_title</th>
                    <th>listed_price</th>
                </tr>
            </thead>
            <tbody></tbody>
            <tfoot>
                <tr>
                    <th>id</th>
                    <th>asin</th>
                    <th>sku </th>
                    <th>product_title</th>
                    <th>listed_price</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <!-- Bootstrap 4.5 CDN  -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous">
    </script>
    <!-- DataTable CDN js -->
    <script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            order: [], //init datatable not ordering
            ajax: "<?php echo site_url('home/ajaxDatatables')?>",
            columnDefs: [{
                    targets: 0,
                    orderable: false
                }, //first column is not orderable.
            ]
        });
    });
    </script>

</body>

</html>