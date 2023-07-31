<link href="<?= base_url('assets/css/bootstrap-toggle.min.css') ?>" rel="stylesheet">
<h1><img src="<?= base_url('assets/imgs/settings-page.png') ?>" class="header-img" style="margin-top:-3px;">푸쉬설정</h1>
<hr>
<div class="row">
    <div class="col-sm-6 col-md-6">
        <div class="panel panel-success col-h">
            <div class="panel-heading">지불완료시</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('paymentDone')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('paymentDone') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <input type="hidden" name="paymentDone" value="<?= $paymentDone ?>">
                    <input <?= $paymentDone == 1 ? 'checked' : '' ?> data-toggle="toggle" data-for-field="paymentDone" class="toggle-changer" type="checkbox">
                    <button class="btn btn-default" value="" type="submit">
                        보관
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6">
        <div class="panel panel-success col-h">
            <div class="panel-heading">답변완료시</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('answerDone')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('answerDone') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <input type="hidden" name="answerDone" value="<?= $answerDone ?>">
                    <input <?= $answerDone == 1 ? 'checked' : '' ?> data-toggle="toggle" data-for-field="answerDone" class="toggle-changer" type="checkbox">
                    <button class="btn btn-default" value="" type="submit">
                        보관
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6">
        <div class="panel panel-success col-h">
            <div class="panel-heading">지불청구시</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('paymentRequest')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('paymentRequest') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <input type="hidden" name="paymentRequest" value="<?= $paymentRequest ?>">
                    <input <?= $paymentRequest == 1 ? 'checked' : '' ?> data-toggle="toggle" data-for-field="paymentRequest" class="toggle-changer" type="checkbox">
                    <button class="btn btn-default" value="" type="submit">
                        보관
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6">
        <div class="panel panel-success col-h">
            <div class="panel-heading">업데이트시</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('productUpdate')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('productUpdate') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <input type="hidden" name="productUpdate" value="<?= $productUpdate ?>">
                    <input <?= $productUpdate == 1 ? 'checked' : '' ?> data-toggle="toggle" data-for-field="productUpdate" class="toggle-changer" type="checkbox">
                    <button class="btn btn-default" value="" type="submit">
                        보관
                    </button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-md-6">
        <div class="panel panel-success col-h">
            <div class="panel-heading">특가상품출시시</div>
            <div class="panel-body">
                <?php if ($this->session->flashdata('productAdd')) { ?>
                    <div class="alert alert-info"><?= $this->session->flashdata('productAdd') ?></div>
                <?php } ?>
                <form method="POST" action="">
                    <input type="hidden" name="productAdd" value="<?= $productAdd ?>">
                    <input <?= $productAdd == 1 ? 'checked' : '' ?> data-toggle="toggle" data-for-field="productAdd" class="toggle-changer" type="checkbox">
                    <button class="btn btn-default" value="" type="submit">
                        보관
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url('assets/js/bootstrap-toggle.min.js') ?>"></script>