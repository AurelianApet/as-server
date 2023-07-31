<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<h1>
    <i class="fa fa-plus"></i>
    <?php if ($this->uri->segment(3) !== null) { ?> 
        설치가이드 편집
    <?php } else { ?>
        설치가이드 추가
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

    <div class="form-group bordered-group">
        <?php
        $types = explode('|', $allowedTypes);
        $results = [];
        foreach($types as $type) {
            $results[] = '.'.$type;
        }
        if (isset($_POST['image']) && $_POST['image'] != null) {
            echo '<p>현재화상:</p>';
            if (strpos($_POST['image'], ',') !== false) {
                $images = explode(',', $_POST['image']);
                foreach($images as $imageName) {
                    $image = 'attachments/shop_images/' . htmlspecialchars($imageName);
                    if (!file_exists($image)) {
                        $image = 'attachments/no-image.png';
                    }
                    echo '<div><img src="'.base_url($image).'" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;"></div>';
                }
            } else {
                $image = 'attachments/shop_images/' . htmlspecialchars($_POST['image']);
                if (!file_exists($image)) {
                    $image = 'attachments/no-image.png';
                }
                echo '<div><img src="'.base_url($image).'" class="img-responsive img-thumbnail" style="max-width:300px; margin-bottom: 5px;"></div>';
            }
            ?>            
            
            <input type="hidden" name="old_image" value="<?= htmlspecialchars($_POST['image']) ?>">
            <?php if (isset($_GET['to_lang'])) { ?>
                <input type="hidden" name="image" value="<?= htmlspecialchars($_POST['image']) ?>">
                <?php
            }
        }
        ?>
        <label for="userfile">사진, 동영상 첨부</label>
        <input type="file" id="userfile" name="userfile[]" multiple accept="<?= implode(',', $results) ?>">
    </div>

    <div>
        <!-- <div class="form-group"> 
            <label>Title </label>
            <input type="text" name="title" value="<?= $id > 0 ? $load_data['title'] : '' ?>" class="form-control">
        </div> -->
        <div class="form-group">
            <label for="setup_guide">설치가이드 </label>
            <textarea name="setup_guide" id="setup_guide" rows="50" class="form-control"><?= $id > 0 ? $load_data['setup_guide'] : '' ?></textarea>
            <script>
                CKEDITOR.replace('setup_guide');
                CKEDITOR.config.entities = false;
            </script>
        </div>
    </div>
    
    <div class="form-group for-shop hidden">
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
        <a href="<?= base_url('admin/guides') ?>" class="btn btn-lg btn-default">취소</a>
    <?php } else { ?>
        <button type="submit" name="submit" class="btn btn-lg btn-default btn-publish">추가</button>
    <?php } ?>
</form>
