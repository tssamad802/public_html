<section class="contact m-t-30">
    <div class="container">
        <div class="row">
            <!-- REGISTER -->
            <div class="col-md-8">
                <div class="widget">
                    <div class="widget-body">
                        <div class="alert alert-warning">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Please fill this.</strong>
                        </div>
                        <form class="form-horizontal space-50" id="ContactForm">
                            <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
                            <input type="hidden" name="Action" value="<?=encodeencriptstring('ContactForm')?>">
                            <fieldset>
                                <div class="form-group required">
                                    <label class="col-md-3 control-label">You are a <sup>*</sup>
                                    </label>
                                    <div class="col-md-7">
                                        <div class="radio radio-success radio-single">
                                            <input type="radio" id="singleRadio1" value="option1" name="radioSingle1" aria-label="Single radio One">
                                            <label>Business</label>
                                        </div>
                                        <div class="radio radio-success radio-single">
                                            <input type="radio" id="singleRadio1" value="option4" name="radioSingle1" aria-label="Single radio Two">
                                            <label>Individual</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group ">
                                    <label class="col-md-3 control-label">Name <sup>*</sup>
                                    </label>
                                    <div class="col-md-7">
                                        <input  placeholder="" name="Name" class="form-control input-md" type="text" required>
                                    </div>
                                </div>
                                <div class="form-group required">
                                    <label for="inputEmail3" class="col-md-3 control-label">Email <sup>*</sup>
                                    </label>
                                    <div class="col-md-7">
                                        <input type="email" class="form-control" name="Email" id="inputEmail3" placeholder="" required>
                                    </div>
                                </div>
                                <div class="form-group required">
                                    <label class="col-md-3 control-label">Phone <sup>*</sup>
                                    </label>
                                    <div class="col-md-7">
                                        <input placeholder="" name="Phone" class="form-control input-md" type="text" required>
                                    </div>
                                </div>
                                <div class="form-group required">
                                    <label class="col-md-3 control-label">Mesaage</label>
                                    <div class="col-md-7">
                                        <textarea class="form-control" cols="40" id="Description" name="Message" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label"></label>
                                    <div class="col-md-7">
                                        <div class="termbox mb10">
                                            <div class="radio radio-success radio-single">
                                                <input type="radio" id="singleRadio3" value="option3" name="radioSingle2" aria-label="Single radio One" required>
                                                <label>I have read and agree to the <a href="#">Terms &amp; Conditions</a>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group m-top-30">
                                    <div class="col-md-3"></div>
                                    <div class="col-md-7">
                                        <div class="clearfix"></div>
                                        <a class="btn btn-danger btn-raised legitRipple"   title="add tags" onclick="FormSubmiting('ContactForm')">Send message</a>
                                    </div>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
                <!-- end: Widget -->
            </div>
            <!-- /REGISTER -->
            <!-- WHY? -->
            <!--<div class="col-md-4">-->
            <!--    <h3>Registration is fast, easy, and free.</h3>-->
            <!--    <p>Once you're registered, you can:</p>-->
            <!--    <ul class="list-check list-unstyled">-->
            <!--        <li><i class="fa fa-check"></i>Buy, sell, and interact with other members.</li>-->
            <!--        <li><i class="fa fa-check"></i>Save your favorite searches and get notified.</li>-->
            <!--        <li><i class="fa fa-check"></i>Watch the status of up to 200 items.</li>-->
            <!--        <li><i class="fa fa-check"></i>View yourinformation from any computer in the world.</li>-->
            <!--        <li><i class="fa fa-check"></i>Connect with the Atropos community.</li>-->
            <!--    </ul>-->
            <!--    <hr>-->
            <!--    <div class="panel">-->
            <!--        <div class="panel-heading">-->
            <!--            <h4 class="panel-title"><a data-parent="#accordion" data-toggle="collapse" class="panel-toggle collapsed" href="#faq1" aria-expanded="false"><i class="ti-info-alt" aria-hidden="true"></i>Can I viverra sit amet quam eget lacinia?</a></h4>-->
            <!--        </div>-->
            <!--        <div class="panel-collapse collapse" id="faq1" aria-expanded="false" role="article" style="height: 0px;">-->
            <!--            <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam rutrum ut erat a ultricies. Phasellus non auctor nisi, id aliquet lectus. Vestibulum libero eros, aliquet at tempus ut, scelerisque sit amet nunc. Vivamus id porta neque, in pulvinar ipsum. Vestibulum sit amet quam sem. Pellentesque accumsan consequat venenatis. Pellentesque sit amet justo dictum, interdum odio non, dictum nisi. Fusce sit amet turpis eget nibh elementum sagittis. Nunc consequat lacinia purus, in consequat neque consequat id.</div>-->
            <!--        </div>-->
            <!--    </div>-->
                <!-- end:panel -->
            <!--    <div class="panel">-->
            <!--        <div class="panel-heading">-->
            <!--            <h4 class="panel-title"><a data-parent="#accordion" data-toggle="collapse" class="panel-toggle collapsed" href="#faq2" aria-expanded="false"><i class="ti-info-alt" aria-hidden="true"></i>Can I viverra sit amet quam eget lacinia?</a></h4>-->
            <!--        </div>-->
            <!--        <div class="panel-collapse collapse" id="faq2" aria-expanded="false" role="article" style="height: 0px;">-->
            <!--            <div class="panel-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam rutrum ut erat a ultricies. Phasellus non auctor nisi, id aliquet lectus. Vestibulum libero eros, aliquet at tempus ut, scelerisque sit amet nunc. Vivamus id porta neque, in pulvinar ipsum. Vestibulum sit amet quam sem. Pellentesque accumsan consequat venenatis. Pellentesque sit amet justo dictum, interdum odio non, dictum nisi. Fusce sit amet turpis eget nibh elementum sagittis. Nunc consequat lacinia purus, in consequat neque consequat id.</div>-->
            <!--        </div>-->
            <!--    </div>-->
                <!-- end:Panel -->

            <!--</div>-->
            <!-- /WHY? -->
        </div>
    </div>
</section>