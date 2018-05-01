<!DOCTYPE html>
<html lang="en">

  <meta charset="UTF-8">

<title>response_time</title>

    <!-- Theme skin -->
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">
    <!-- Custom styles for this template--> 
    <link href="css/3-col-portfolio.css" rel="stylesheet">
  <link href="css/style2.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap.min.css"><!-- 
    <link rel="stylesheet" type="text/css" href="css/dataTables.foundation.min.css">
    <link rel="stylesheet" type="text/css" href="css/dataTables.jqueryui.min.css"> -->
    <link rel="stylesheet" type="text/css" href="css/jquery.dataTables.min.css">
  </head>

  <body>


    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-red fixed-top">
      <div class="container">
        <a class="navbar-brand" href="#">Bupass</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
              <a class="nav-link" href="" style="color: #fff;">Home
                <span class="sr-only">(current)</span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- Page Content -->
    <div class="container" style="margin-top: 10px; ">  
        <div class="row">
        <div class="col-md-8 col-md-offset-3">
             <table id="example" class="table table-striped table-bordered" style="width:100%">
        <thead>
            <tr>
                <th>Start Timestamp</th>
                <th>Code</th>
                <th>Total Response Time</th>
            </tr>
        </thead>
         <tbody>
            <?php

            $result = include 'endpoints.php';
            foreach ($result as $value) {
                $url = $value['base_url'];
                $method = $value['method'];
                $content_type = $value['content_type'];
                $data = $value['data'];


                if ($content_type == null) {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url . '?postId=' . $data['postId']);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_HEADER, false);
                    $timestamp = time();
                    curl_exec($ch);
                    if (!curl_exec($ch)) {
                        echo 'Error: ' . curl_error($ch);
                    }
                    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    $time = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
                    curl_close($ch);
                } elseif ($content_type == 'application/x-www-form-urlencoded') {
                    $value1 = $data['key1'];
                    $value2 = $data['key2'];
                    $params = 'key1=' . $value1 . '&key2=' . $value2;
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array($content_type));
                    $timestamp = time();
                    curl_exec($ch);
                    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    $time = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
                    curl_close($ch);
                } else if ($content_type == 'application/json') {

                    $value1 = $data['key1'];
                    $value2 = $data['key2'];
                    $params = 'key1=' . $value1 . '&key2=' . $value2;
                    $ch = curl_init($url);
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array($content_type));
                    $timestamp = time();
                    curl_exec($ch);
                    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                    $time = curl_getinfo($ch, CURLINFO_TOTAL_TIME);
                    curl_close($ch);
                }


                ?>
                <tr>
                    <td><?php echo date('H:i:s', $timestamp);?> </td>
                    <td><?php echo$code ?></td>
                    <td><?php echo$time ?></td>
                </tr>

            <?php


            }?>

       
       
           
        </tbody>
       </table>

            </div>
                  <!-- /.row -->     

    </div>
    <!-- /.container -->
    
   
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" src="js/jquery.dataTables.min.js"></script>

    <script type="text/javascript" src="js/dataTables.buttons.min.js"></script>  
    <script type="text/javascript" src="js/buttons.flash.min.js"></script> 
    <script type="text/javascript" src="js/jszip.min.js"></script> 
    <script type="text/javascript" src="js/pdfmake.min.js"></script> 
    <script type="text/javascript" src="js/vfs_fonts.js"></script> 
    <script type="text/javascript" src="js/buttons.html5.min.js"></script> 
    <script type="text/javascript" src="js/buttons.html5.min.js"></script> 
    <script type="text/javascript">
      $(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5'
        ]
    } );
} );
    </script> 

  </body>

</html>

