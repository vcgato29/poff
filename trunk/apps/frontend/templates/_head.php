<head>
<title><?php include_component('seo', 'pageTitle')?></title>
<?php include_component('seo', 'metas')?>

<?php include_stylesheets() ?>

<link rel="stylesheet" href="/css/reset.css" type="text/css" />
<link rel="stylesheet" href="/css/poff-min.css" type="text/css" />


<script src="/js/jquery-1.4.2.min.js" type="text/javascript"></script>
<script src="/js/jquery-timers.js" type="text/javascript"></script>
<script src="/css/jquery.countdown.css" type="text/javascript"></script>
<script src="/js/jquery.countdown.min.js" type="text/javascript"></script>
<script src="/js/poff-min.js" type="text/javascript"></script>
<script src="/js/jquery.uniform.min.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
      $(function(){
        $("input:checkbox").uniform();
        $("#uniform-post_all").click(pChecked);
        <?php include_slot('CounterWidget')?>
       $('#clocker').countdown({since: new Date(1910, 00, 00, 00, 00),
    	layout: '<?php echo date('d.m.Y')?> <span class="separator">|</span> {hnn}:{mnn}:{snn}'});
      });
	  function pChecked() {
	      var n = $(this).find("input:checked").length;
	      if(n==1) $('.posting').attr('checked', true);
	      else $('.posting').attr('checked', false);
	      $.uniform.update();
	  }

    </script>
<link rel="stylesheet" href="/css/uniform.default.css" type="text/css" media="screen">
<?php include_javascripts()?>
<!--[if IE 7]>
<link rel="stylesheet" type="text/css" href="/css/poff-ie7.css">
<![endif]-->
<script type="text/javascript" src="/js/sexy-bookmarks-public.js"></script>
<link rel="stylesheet" type="text/css" href="/css/sexy-bookmarks-style.css" media="screen" />
<script type="text/javascript" src="/js/swfobject.js"></script>
<script type="text/javascript"> 
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script> 
<script type="text/javascript"> 
var pageTracker = _gat._getTracker("UA-8361561-11");
</script> 
<script src="http://veebiturundus.ee/custom_ee.js" 
type="text/javascript"></script> 
<script type="text/javascript"> 
pageTracker._initData();
pageTracker._trackPageview();
</script>
</head>