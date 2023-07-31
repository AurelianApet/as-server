<div id="questionlist">
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
    <h1><i class="fa fa-warning"></i> 문의</h1>
    <hr>
    <div class="row">
        <div class="col-xs-12">
            <div class="well hidden-xs"> 
                <div class="row">
                    <form method="GET" id="searchRepairsForm" action="">
                        <div class="col-sm-4">
                            <label>정렬:</label>
                            <select name="order_by" class="form-control selectpicker change-repairs-form">
                                <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'desc' ? 'selected=""' : '' ?> value="desc">Newest</option>
                                <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'asc' ? 'selected=""' : '' ?> value="asc">Latest</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label>유저:</label>
                            <div class="input-group">
                                <input class="form-control" placeholder="Username" type="text" value="<?= isset($_GET['search_user']) ? $_GET['search_user'] : '' ?>" name="search_user">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit" value="">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>상태:</label>
                            <select name="status" class="form-control selectpicker change-repairs-form">
                                <option value="">None</option>
                                <option <?= isset($_GET['status']) && $_GET['status'] == 0 ? 'selected=""' : '' ?> value="0">Open</option>
                                <option <?= isset($_GET['status']) && $_GET['status'] == 1 ? 'selected=""' : '' ?> value="1">Close</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <hr>
            <?php
            if ($questionlist) {
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>번호</th>
                                <th>유저</th>
                                <th>설명</th>
                                <th>날자</th>
                                <th>상태</th>
                                <th class="text-right">활동</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($questionlist as $row) { ?>
                                <tr>
                                    <td>
                                        <?= $row->id ?>
                                    </td>
                                    <td>
                                        <?= $row->username ?>
                                    </td>
                                    <td>
                                        Question is registerd!
                                    </td>
                                    <td><?= $row->date ?></td>
                                    <td>
                                        <?php
                                        
                                        if ($row->status == 0) {
                                            $color = 'label-success';
                                            $status = 'Open';
                                        } else{
                                            $color = 'label-warning';
                                            $status = 'Close';
                                        } ?>
                                        <span style="font-size:12px;" class="label <?= $color ?>">
                                            <?= $status ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="pull-right">
                                            <!-- <button id="go_chat" class="btn btn-info" type="submit" value="">
                                                <input type="hidden" name="admin_name" value="admin@email.com" id="admin_name">
                                                <a href="<?= base_url('admin/chat/' . $row->user_id) ?>">Chat</a>
                                            </button> -->
                                            <a href="<?= base_url('admin/chat/' . $row->user_id) ?>" class="btn btn-info">대화</a>
                                            <a href="<?= base_url('admin/questionlist?delete=' . $row->id) ?>"  class="btn btn-danger confirm-delete">삭제</a>
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