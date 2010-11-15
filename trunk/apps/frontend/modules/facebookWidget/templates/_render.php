<?php slot('facebook') ?>


<!-- TODO:
    1. create application for olly.ee
    2. replace profile and application ID
-->

<?php use_javascript('http://static.ak.connect.facebook.com/js/api_lib/v0.4/FeatureLoader.js.php/en_US') ?>
<script type="text/javascript">FB.init("80de4ff50aaaf29fd7c184e6fecd645e");</script>

<!-- style="position: absolute; right: 23px;" -->
<div class="people">
	<div class="facebookiconcontainer" style="position: absolute; right: 23px;">
		<img class="facebookicon" width="17" height="17" alt="" src="/olly/img/fb.png">
	</div>
<fb:fan profile_id="140486565987374" stream="0" connections="8" logobar="0" width="225" padding-left="3px" height="200" css="http://<?php echo $sf_request->getHost() ?>/olly/facebook.css?11"></fb:fan>
</div>

<?php end_slot() ?>