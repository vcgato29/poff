  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    
    
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>
    
    <title>Adjustor test - Admin</title>
    

<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
<base href="http://<?php echo $_SERVER['HTTP_HOST']?>/" />

<link type="text/css" href="/css/admin.css" rel="stylesheet" />
<!--[if lt IE 6]>
	<link type="text/css" href="/css/admin-ie6.css" rel="stylesheet">
<![endif]-->
<!--[if IE 7]>
	<link type="text/css" href="/css/admin-ie7.css" rel="stylesheet">
<![endif]-->
<!--[if lt IE 6]>
    <script type="text/javascript" src="js/unitpngfix.js"></script>
<![endif]-->

<script type="text/javascript" src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.mousewheel-3.0.2.js"></script>
<script type="text/javascript" src="/js/fancybox.js"></script>
<script type="text/javascript" src="/js/mainAdminFunctions.js"></script>
<?php include_javascripts() ?>

<link rel="stylesheet" href="/css/fancybox/fancybox.css" />

<script type="text/javascript">
	$(document).ready(function() {
		<?php include_slot('structuresfancybox') ?>
	});
</script>

  </head>