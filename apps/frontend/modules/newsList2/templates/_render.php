<?php slot('newsArchivePage2') ?>
<div class="content opennews">
  <table class="othernews">
       <tbody>
       <?php include_partial('newsList2/newsBox', array('pager' => $pager)) ?>
        </tbody></table>

       <div class="content_separator last"></div>

 </div>
<?php end_slot() ?>