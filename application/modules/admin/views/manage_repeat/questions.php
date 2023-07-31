<div id="repeat_questions">
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
    <h1><i class="fa fa-question"></i> 자주하는 질문</h1>
    <hr>
    <div class="row">
        <div class="col-xs-12">
            <div class="well hidden-xs"> 
                <div class="row">
                    <form method="GET" id="searchRepeatsForm" action="">
                        <div class="col-sm-4">
                            <label>정렬:</label>
                            <select name="order_by" class="form-control selectpicker change-repeats-form">
                                <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'desc' ? 'selected=""' : '' ?> value="desc">Newest</option>
                                <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'asc' ? 'selected=""' : '' ?> value="asc">Latest</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label>제목:</label>
                            <div class="input-group">
                                <input class="form-control" placeholder="Question Title" type="text" value="<?= isset($_GET['search_title']) ? $_GET['search_title'] : '' ?>" name="search_title">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit" value="">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>카테고리:</label>
                            <select name="category" class="form-control selectpicker change-repeats-form">
                                <option value="">None</option>
                                <?php foreach ($categories as $key_cat => $categorie) { ?>
                                    <option <?= isset($_GET['category']) && $_GET['category'] == $key_cat ? 'selected=""' : '' ?> value="<?= $key_cat ?>">
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
                    </form>
                </div>
            </div>
            <hr>
            <?php
            if ($repeat_questions) {
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>번호</th>
                                <th>문의</th>
                                <th>대답</th>
                                <th>카테고리</th>
                                <th>등록날자</th>
                                <th class="text-right">활동</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($repeat_questions as $row) {
                                ?>
                                <tr>
                                    <td>
                                        <?= $row->id ?>
                                    </td>
                                    <td>
                                        <?= $row->question ?>
                                    </td>
                                    <td>
                                        <?= $row->answer ?>
                                    </td>
                                    <td>
                                        <?php
                                        $category = $categories[$row->categorie];
                                        foreach ($category['info'] as $nameAbbr) {
                                            if ($nameAbbr['abbr'] == $this->config->item('language_abbr')) {
                                                echo $nameAbbr['name'];
                                            }
                                        }
                                        ?>
                                    </td>
                                    <td><?= $row->date ?></td>
                                    <td>
                                        <div class="pull-right">
                                            <a href="<?= base_url('admin/addquestion/'.$row->id) ?>" class="btn btn-info">편집</a>
                                            <a href="<?= base_url('admin/questions?delete='.$row->id) ?>"  class="btn btn-danger confirm-delete">삭제</a>
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