<section class="results m-t-30">
    <div class="container">


        <div class="widget m-t-20">
            <!-- /widget heading -->
            <div class="widget-heading">
                <h3 class="widget-title text-dark">
                   Privacy and Policy
                </h3>
                <div class="clearfix"></div>
            </div>
            <div class="widget-body">
                <div class="row" id="resultDiv">
                    <?php
                        $Query ="select * from tblpolicy";
                        $db->query($Query);
                    while($db->next_record()){
                        ?>
                        <div class="col-lg-12 col-md-12 col-sm-4 col-xs-12 thumb">
                            <div class="thumb-inside">
                                <h1><?=$db->f('Title')?></h1>
                            </div>

                            <div class="store_name text-center">
                                <h5><?=$db->f('Description')?></h5>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
</section>