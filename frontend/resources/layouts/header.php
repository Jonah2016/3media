<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=5">
    <meta name="theme-color" media="(prefers-color-scheme: light)" content="white">
    <meta name="theme-color" media="(prefers-color-scheme: dark)"  content="black">
    <meta name="og:title" property="og:title" content="<?php if(isset($og_title)){ echo $og_title; } else{ echo '3Music Tv'; } ?>"/>
    <meta property="og:image" content="<?php if(isset($og_image)){ echo $og_image; } else{ echo ASSETS_PATH.'/img/logo.png'; } ?>"/>
    <meta property="og:url" content="<?php if(isset($og_url)){ echo $og_url; } else{ echo 'https://3music.tv'; } ?>"/>
    <meta name="description" content="An innovative media broadcast company focusing on music, entertainment and lifestyle content to entertain and inform our TG.  Our content is broadcast mainly on TV, Online and radio.">
    <meta property="og:description" content="<?php if(isset($og_description)){ echo $og_description; } else{ echo 'An innovative media broadcast company focusing on music, entertainment and lifestyle content to entertain and inform our TG.  Our content is broadcast mainly on TV, Online and radio.'; } ?>"/>
    <meta name="robots" content=" Nofollow, Noarchive, Nosnippet"><!-- Noindex -->
    <meta name="date" content="<?php echo date('Y-m-d'); ?>" />
    <meta name="sitecode" content="gh" />
    <meta property="og:og:site_name" content="3Music Tv">
    <link rel="canonical" href="https://www.3music.tv/">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo ASSETS_PATH; ?>/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo ASSETS_PATH; ?>/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo ASSETS_PATH; ?>/favicon/favicon-16x16.png">
    <link rel="manifest" href="<?php echo ASSETS_PATH; ?>/favicon/site.webmanifest">
    <link rel="mask-icon" href="<?php echo ASSETS_PATH; ?>/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <title> <?php if ($page_title != '') { echo '3MUSIC - '.$page_title; } else { echo '3MUSIC'; } ?> </title>
    
    <!-- Bootstrap core -->
    <link href="<?php echo ASSETS_PATH; ?>/vendors/bootstrap/css/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Main styles -->
    <link href="<?php echo ASSETS_PATH; ?>/css/custom.css" rel="stylesheet" media="all">
    <link href="<?php echo ASSETS_PATH; ?>/css/app.css" rel="stylesheet" media="all">
    <link href="<?php echo ASSETS_PATH; ?>/vendors/perfect-scrollbar/perfect-scrollbar.css" rel="stylesheet" media="all">
    <link href="<?php echo ASSETS_PATH; ?>/vendors/jquery/jquery-ui.css" rel="stylesheet" media="all">
    <link href="<?php echo ASSETS_PATH; ?>/vendors/aos/aos.css" rel="stylesheet">
    <link href="<?php echo ASSETS_PATH; ?>/css/animate.css" rel="stylesheet" media="all" />

    <!-- Select boxes -->
    <link href="<?php echo ASSETS_PATH; ?>/vendors/bootstrap-select/bootstrap-select.min.css" rel="stylesheet" media="all" />
    <link href="<?php echo ASSETS_PATH; ?>/vendors/multiselect/css/multi-select.css" rel="stylesheet" type="text/css" media="all" />

    <!-- owl carousel-->
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>/vendors/owl.carousel/assets/owl.carousel.css"  media="all">
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>/vendors/owl.carousel/assets/owl.theme.default.css"  media="all">

    <!-- Custom icons & fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="<?php echo ASSETS_PATH; ?>/vendors/fontawesome-free-5.15.3-web/css/all.min.css" rel="stylesheet" type="text/css" media="all">
    <link href="<?php echo ASSETS_PATH; ?>/vendors/bootstrap-icons/bootstrap-icons.css" rel="stylesheet" media="all">

    <!-- Scripts -->
    <script src="<?php echo ASSETS_PATH; ?>/vendors/jquery/jquery-3.6.0.min.js" ></script> 

</head>
<body style="<?php echo $sett_data['body_background_style']; ?>">
    <!-- facebook widget -->
    <div id="fb-root"></div>
    <!-- <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v13.0" nonce="zRYBo25L"></script> -->
    <!-- Page wrapper -->