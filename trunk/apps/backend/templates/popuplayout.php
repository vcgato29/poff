<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Attitude CMS</title>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link href="/css/popup/content.css" type="text/css" rel="stylesheet" />
		<link href="/css/popup/data.css" type="text/css" rel="stylesheet" />
		<link href="/css/popup/navigate.css" type="text/css" rel="stylesheet" />
		
		

		<link rel="stylesheet" href="/css/popup/calendar.css" type="text/css" />
		<link rel="stylesheet" type="text/css" media="screen" href="/css/leftmenu.css" />
		
		<script type="text/javascript" src="/js/ckeditor/ckeditor.js"></script>
		<script type="text/javascript" src="/js/ckfinder/ckfinder.js"></script>
		<script type="text/javascript" src="/js/popup/calendar.js"></script>
		<script language="javascript" src="/js/popup/AC_RunActiveContent.js" type="text/javascript"></script>
		<script language="javascript" src="/js/popup/functions.js" type="text/javascript"></script>
		<script language="javascript" src="/js/popup/navigation.js" type="text/javascript"></script>
		<script type="text/javascript" src="/js/jquery.min.js"></script>
	</head>

	<body class="popup">
		<table id="mainTable" cellspacing="0" cellpadding="0" width="100%" align="center">
			<tr>
				<td>
					<?php include_slot('popuptabs') ?>
				</td>
			</tr>
			<tr>
				<td style="padding: 10px;">
					<?php echo $sf_content ?>
				</td>
			</tr>
		</table>
	</body>

</html>