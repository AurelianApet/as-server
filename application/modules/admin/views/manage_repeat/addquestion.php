<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<h1>
    <i class="fa fa-plus"></i>
    <?php if ($this->uri->segment(3) !== null) { ?> 
        자주하는 질문 편집
    <?php } else { ?>
        자주하는 질문 추가
    <?php } ?>
</h1>
<hr>
<?php
if (validation_errors()) {
    ?>
    <hr>
    <div class="alert alert-danger"><?= validation_errors() ?></div>
    <hr>
    <?php
}
if ($this->session->flashdata('result_publish')) {
    ?>
    <hr>
    <div class="alert alert-success"><?= $this->session->flashdata('result_publish') ?></div>
    <hr>
    <?php
}
?>
<form method="POST" action="" enctype="multipart/form-data">
    <div>
        <div class="form-group"> 
            <label>질문 </label>
            <input type="text" name="question" value="<?= $id > 0 ? $load_data['question'] : '' ?>" class="form-control">
        </div>
        <div class="form-group">
            <label for="answer">대답 </label>
            <textarea name="answer" id="answer" rows="50" class="form-control"><?= $id > 0 ? $load_data['answer'] : '' ?></textarea>
            <script>
                CKEDITOR.replace('answer');
                CKEDITOR.config.entities = false;
            </script>
        </div>
    </div>
    <div class="form-group for-shop">
        <label>카테고리</label>
        <select class="selectpicker form-control show-tick show-menu-arrow" name="categorie">
            <?php foreach ($categories as $key_cat => $categorie) { ?>
                <option <?= isset($_POST['categorie']) && $_POST['categorie'] == $key_cat ? 'selected=""' : '' ?> value="<?= $key_cat ?>">
                    <?php
                    foreach ($categorie['info'] as $nameAbbr) {
                        if ($nameAbbr['abbr'] == $this->config->item('language_abbr')) {
                            echo $nameAbbr['name'];
                        }
                    }
                    ?>
                </option>
            <?php } ?>
        </select>
    </div>
    <?php if ($this->uri->segment(3) !== null) { ?>
        <button type="submit" name="submit" class="btn btn-lg btn-default btn-publish">보관</button>
        <a href="<?= base_url('admin/questions') ?>" class="btn btn-lg btn-default">취소</a>
    <?php } else { ?>
        <button type="submit" name="submit" class="btn btn-lg btn-default btn-publish">추가</button>
    <?php } ?>
</form>
