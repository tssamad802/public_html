<?php
if (!isset($RUNFILE_FROM_INDEX_PAGE)) {
    die("Direct Access Not Allowed");
}

?>
<!-- Main Content -->
<div class="hk-pg-wrapper hk-auth-wrapper" style="background: url(images/login_bg.jpg) no-repeat top center;">

    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-12 pa-0">
                <div class="auth-form-wrap pt-xl-0 pt-70">
                    <div class="auth-form" style="width:500px; margin:0 auto">

                        <form class="needs-validation" method="post" action="" novalidate>

                            <input type="hidden" name="ActionFlag" value="<?= encodeencriptstring('LoginPanel') ?>" />
                            <input type="hidden" name="<?= $token_id; ?>" value="<?= $token_value; ?>" />
                            <input type="hidden" name="RedirectURL" value="<?= $_SERVER['SCRIPT_NAME'] ?>" />
                            <h1 class="display-4 text-center mb-10">&nbsp;</h1>
                            <!--<p class="text-center mb-30"><?= APPLICATION_TITLE ?>.</p>-->

                            <div class="loginbox">
                                <p class="text-center mb-20 mt-20" style="color:#f95851; font-weight:bold">
                                    <?= WELCOMETEXT ?>
                                </p>
                                <table class="textalignright">
                                    <tr>
                                        <td><strong><?= USERNAME ?></strong></td>
                                        <td>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="<?= USERNAME ?>"
                                                    name="txtUserName" required />
                                                <div class="invalid-feedback">
                                                    <?= ENTER_USERNAME ?>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong><?= PASSWORD ?></strong></td>
                                        <td>
                                            <div class="form-group">
                                                <div class="input-group">
                                                    <input class="form-control" placeholder="<?= PASSWORD ?>"
                                                        name="txtPassword" type="password" required />
                                                    <!--<div class="input-group-append">
                                                            <span class="input-group-text"><span class="feather-icon"><i data-feather="eye-off"></i></span></span>
                                                        </div> -->
                                                    <div class="invalid-feedback">
                                                        <?= ENTER_PASSWORD ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>
                                            <div class="formbuttonrightside loginbuttons">
                                                <button class="btn btn-danger" type="reset"><?= RESET ?></button>
                                                <button class="btn btn-primary" type="submit"><?= LOGIN ?></button>
                                            </div>
                                        </td>
                                    </tr>
                                </table>

                            </div>
                            <p class="font-14 text-center mt-15" style="color:#393939;"><?= FOOTER_TEXT ?></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .loginbox {
        padding: 20px;
        background: #fff;
        border: 2px solid #71bfd1;
        border-radius: 5px;
    }

    .loginbox table {
        width: 300px;
        margin: 0 auto;
    }
</style>