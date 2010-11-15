<div class="centerbox">
    <div class="centerboxtop"></div>
        <div class="centerboxcontent">
            <div class="centerboxmain">
                    <div class="bmaintopl">
                        <div class="boxinpealkiri">
                            <?php include_slot('subject') ?>
                        </div>
                    </div>
                    <div class="bmaintopr">
                        <?php include_partial('searchResults/searchBox') ?>
                    </div>
                    <div class="clear"></div>
                    
                    <div class="centerboxin">
                        <div class="boxinleft">
                            <?php include_component('query', 'leftMenu') ?>
                        </div>
                        <div class="boxinright">
                            <?php include_slot('content') ?>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                    <?php include_slot('bottomArticlesWidget') ?>
                    <div class="clear"></div>
            </div>
    </div>
</div>