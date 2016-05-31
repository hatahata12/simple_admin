<!DOCTYPE html>
<html>
  <head>
    <title>スクレピング管理ツール</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="/admin/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- styles -->
    <link href="/admin/css/styles.css" rel="stylesheet">
    <link href="/admin/css/contents.css" rel="stylesheet">
    <link rel="stylesheet" href="/admin/css/buttons.css">
    <link rel="stylesheet" href="/admin/css/main.css">
    <link type="text/css" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1/themes/ui-lightness/jquery-ui.css" rel="stylesheet" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        h1 {
            color : #fff;
        }
    </style>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://code.jquery.com/jquery.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/admin/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1/jquery-ui.min.js"></script>
    <script src="/admin/js/custom.js"></script>
    <script src="/admin/js/contents.js"></script>

    <?php
        preg_match('{.+controller.php/(.+)/}', $_SERVER['REQUEST_URI'], $matchs);
        if (isset($matchs[1])) {
            $urlPrefix = $matchs[1];
            if (file_exists(__DIR__ . '/../../web/admin/js/contents/'.$urlPrefix.'.js')) {
                echo '<script src="/admin/js/contents/'.$urlPrefix.'.js"></script>';
            }
        } else {
            $urlPrefix = '';
        }
    ?>
  </head>
  <body>
      <div class="header">
         <div class="container">
            <div class="row">
               <div class="col-md-5">
                  <!-- Logo -->
                  <div class="logo">
                     <h1><?php echo $title ?></h1>
                  </div>
               </div>
            </div>
         </div>
    </div>