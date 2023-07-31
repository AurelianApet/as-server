<div id="guides">
    <?php
    if ($this->session->flashdata('result_delete')) {
        ?>
        <hr>
        <div class="alert alert-success"><?= $this->session->flashdata('result_delete') ?></div>
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
    <h1><i class="fa fa-book"></i> 설치가이드</h1>
    <hr>
    <div class="row">
        <div class="col-xs-12">
            <?php
            if ($guides) {
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>번호</th>
                                <th>설치가이드</th>
                                <th>날자</th>
                                <th class="text-right">활동</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($guides as $row) {
                                ?>
                                <tr>
                                    <td>
                                        <?= $row->id ?>
                                    </td>
                                    <td>
                                        <?= $row->setup_guide ?>
                                    </td>
                                    <td><?= $row->date ?></td>
                                    <td>
                                        <div class="pull-right">
                                            <a href="<?= base_url('admin/addguide/' . $row->id) ?>" class="btn btn-info">편집</a>
                                            <a href="<?= base_url('admin/guides?delete=' . $row->id) ?>"  class="btn btn-danger confirm-delete">삭제</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <?= $links_pagination ?>
            </div>
            <?php
        } else {
            ?>
            <div class ="alert alert-info">자료가 없습니다!</div>
        <?php } ?>
    </div>