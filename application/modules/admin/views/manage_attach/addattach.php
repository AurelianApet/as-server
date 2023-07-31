<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<h1>
    <i class="fa fa-files-o"></i>
    <?php if ($this->uri->segment(3) !== null) { ?> 
        부품 편집
    <?php } else { ?>
        부품 추가
    <?php } ?>
</h1>
<hr>
<?php
$timeNow = time();
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
    <?php
    $i = 0;
    foreach ($languages as $language) {
        ?>
        <div class="locale-container locale-container-<?= $language->abbr ?>" <?= $language->abbr == MY_DEFAULT_LANGUAGE_ABBR ? 'style="display:block;"' : '' ?>>
            <input type="hidden" name="translations[]" value="<?= $language->abbr ?>">
            <div class="form-group"> 
                <label>부품 </label>
                <input type="text" name="title" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['title']) ? $trans_load[$language->abbr]['title'] : '' ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="description<?= $i ?>">설명 </label>
                <textarea name="description" id="description<?= $i ?>" rows="50" class="form-control"><?= $trans_load != null && isset($trans_load[$language->abbr]['description']) ? $trans_load[$language->abbr]['description'] : '' ?></textarea>
                <script>
                    CKEDITOR.replace('description<?= $i ?>');
                    CKEDITOR.config.entities = false;
                </script>
            </div>
            <div class="form-group for-shop">
                <label>가격 </label>
                <input type="text" name="price" placeholder="without currency at the end" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['price']) ? $trans_load[$language->abbr]['price'] : '' ?>" class="form-control">
            </div>
            <div class="form-group for-shop">
                <label>SN </label>
                <input type="text" name="serial_number" placeholder="without currency at the end" value="<?= $trans_load != null && isset($trans_load[$language->abbr]['serial_number']) ? $trans_load[$language->abbr]['serial_number'] : '' ?>" class="form-control">
            </div>
        </div>
        <?php
        $i++;
    }
    ?>
    <div class="form-group bordered-group">
        <?php
        $types = explode('|', $allowedTypes);
        $results = [];
        foreach($types as $type) {
            $results[] = '.'.$type;
        }
        if (isset($_POST['image']) && $_POST['image'] != null) {
            $image = 'attachments/shop_images/' . htmlspecialchars($_POST['image']);
            if (!file_exists($image)) {
                $image = 'attachments/no-image.png';
            }
            ?>
            <p>현재화상:</p>
            <div>
                <img src="<?= base_url($image) ?>" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;">
            </div>
            <input type="hidden" name="old_image" value="<?= htmlspecialchars($_POST['image']) ?>">
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="image" value="<?= htmlspecialchars($_POST['image']) ?>">
                <?php
            }
        }
        ?>
        <label for="userfile">화상</label>
        <input type="file" id="userfile" name="userfile" accept="<?= implode(',', $results) ?>">
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
    <div class="form-group for-shop">
        <label>수량</label>
        <input type="text" placeholder="number" name="quantity" value="<?= isset($_POST['quantity']) ? htmlspecialchars($_POST['quantity']) : '' ?>" class="form-control" id="quantity">
    </div>
    <?php if ($this->uri->segment(3) !== null) { ?>
        <button type="submit" name="submit" class="btn btn-lg btn-default btn-publish">보관</button>
        <a href="<?= base_url('admin/attachs') ?>" class="btn btn-lg btn-default">취소</a>
    <?php } else { ?>
        <button type="submit" name="submit" class="btn btn-lg btn-default btn-publish">추가</button>
    <?php } ?>
</form>
