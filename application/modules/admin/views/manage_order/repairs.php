<div id="repairs">
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
    <h1><i class="fa fa-gears"></i> 수리접수 </h1>
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
                            <label>이름:</label>
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
            if ($repairs) {
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>번호</th>
                                <th>화상</th>
                                <th>이름</th>
                                <th>주소</th>
                                <th>수취인</th>
                                <th>상점</th>
                                <th>설명</th>
                                <th>날자</th>
                                <th class="text-right">활동</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($repairs as $row) {
                                $u_path = 'attachments/shop_images/';
                                if ($row->image != null && file_exists($u_path . $row->image)) {
                                    $image = base_url($u_path . $row->image);
                                } else {
                                    $image = base_url('attachments/no-image.png');
                                }
                                ?>

                                <tr>
                                    <td>
                                        <?= $row->id ?>
                                    </td>
                                    <td>
                                        <img src="<?= $image ?>" alt="No Image" class="img-thumbnail" style="height:100px;">
                                    </td>
                                    <td>
                                        <?= $row->username ?>
                                    </td>
                                    <td>
                                        <?= $row->user_address ?>
                                    </td>
                                    <td>
                                        <?= $row->sellername ?>
                                    </td>
                                    <td>
                                        <?= $row->seller_address ?>
                                    </td>
                                    <td>
                                        <?= $row->description ?>
                                    </td>
                                    <td><?= $row->sell_date ?></td>
                                    <td>
                                        <div class="pull-right">
                                            <a href="<?= base_url('admin/chat/' . $row->request_id) ?>" class="btn btn-info">대화</a>
                                            <a href="<?= base_url('admin/repairs?delete=' . $row->id) ?>"  class="btn btn-danger confirm-delete">삭제</a>
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