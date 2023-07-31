<div id="languages">
    <h1><i class="fa fa-list-alt"></i> 카테고리</h1> 
    <hr>
    <?php if (validation_errors()) { ?>
        <div class="alert alert-danger"><?= validation_errors() ?></div>
        <hr>
        <?php
    }
    if ($this->session->flashdata('result_add')) {
        ?>
        <div class="alert alert-success"><?= $this->session->flashdata('result_add') ?></div>
        <hr>
        <?php
    }
    if ($this->session->flashdata('result_delete')) {
        ?>
        <div class="alert alert-success"><?= $this->session->flashdata('result_delete') ?></div>
        <hr>
        <?php
    }
    ?>
    <a href="javascript:void(0);" data-toggle="modal" data-target="#add_edit_articles" class="btn btn-primary btn-xs pull-right" style="margin-bottom:10px;"><b>+</b> 카테고리추가</a>
    <div class="clearfix"></div>
    <?php
    if (!empty($categories)) {
        ?>
        <div class="table-responsive">
            <table class="table table-striped custab">
                <thead>
                    <tr>
                        <th></th>
                        <th>번호</th>
                        <th>카테고리</th>
                        <th class="text-center">활동</th>
                    </tr>
                </thead>
                <?php
                $i = 1;
                foreach ($categories as $key_cat => $categorie) {
                    $catName = '';
                    foreach ($categorie['info'] as $ff) {
                        $catName .= '<div>'
                                . '<a href="javascript:void(0);" class="editCategorie" data-indic="' . $i . '" data-for-id="' . $key_cat . '" data-abbr="' . $ff['abbr'] . '" data-toggle="tooltip" data-placement="top" title="Edit this categorie">'
                                . '<i class="fa fa-pencil" aria-hidden="true"></i>'
                                . '</a> '
                                . '<span id="indic-' . $i . '">' . $ff['name'] . '</span>'
                                . '</div>';
                        $i++;
                    }
                    ?>
                    <tr>
                        <td></td>
                        <td><?= $key_cat ?></td>
                        <td><?= $catName ?></td>
                        <td class="text-center">
                            <a href="<?= base_url('admin/categories/?delete=' . $key_cat) ?>" class="btn btn-danger btn-xs confirm-delete"><span class="glyphicon glyphicon-remove"></span> 삭제</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </table>
        </div>
        <?php
        echo $links_pagination;
    } else {
        ?>
        <div class="clearfix"></div><hr>
        <div class="alert alert-info">자료가 없습니다!</div>
    <?php } ?>

    <!-- add edit home categorie -->
    <div class="modal fade" id="add_edit_articles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="" method="POST">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">카테고리추가</h4>
                    </div>
                    <div class="modal-body">
                        <?php foreach ($languages as $language) { ?>
                            <input type="hidden" name="translations[]" value="<?= $language->abbr ?>">
                        <?php } foreach ($languages as $language) { ?>
                            <div class="form-group">
                                <label>카테고리명 </label>
                                <input type="text" name="categorie" class="form-control">
                            </div>
                        <?php } ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">취소</button>
                        <button type="submit" name="submit" class="btn btn-primary">보관</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
