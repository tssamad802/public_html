<?php
?>
<section class="results m-t-30">
    <div class="container">
        <div class="row">

            <div class="col-sm-12">
                <div class="widget">
                    <div class="widget-heading widget-default b-b-0">
                        <h3 class="widget-title text-dark">
                            Products
                        </h3>
                        <div class="clearfix"></div>
                    </div>
                </div>
                <div class="row" id="resultDiv"></div>
            </div>

        </div>
    </div>
</section>
<script>
    SimpleAjax('<?php echo RESOURCES_DOMAIN;?>/ajax/ajax_products.php?actions=productlisting&page=0','searchfrm','resultDiv');
</script>