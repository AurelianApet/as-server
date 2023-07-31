<div id="products">
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
    <h1><i class="fa fa-files-o"></i> 특가상품</h1>
    <a href="<?= base_url('admin/publish') ?>" class="btn btn-primary btn-xs pull-right" style="margin-top:-36px;"><h5><b>+</b>특가상품추가</h5></a>
    <hr>
    <div class="row">
        <div class="col-xs-12">
            <div class="well hidden-xs"> 
                <div class="row">
                    <form method="GET" id="searchProductsForm" action="">
                        <div class="col-sm-4">
                            <label>정렬:</label>
                            <select name="order_by" class="form-control selectpicker change-products-form">
                                <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'id=desc' ? 'selected=""' : '' ?> value="id=desc">Newest</option>
                                <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'id=asc' ? 'selected=""' : '' ?> value="id=asc">Latest</option>
                                <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'quantity=asc' ? 'selected=""' : '' ?> value="quantity=asc">Low Quantity</option>
                                <option <?= isset($_GET['order_by']) && $_GET['order_by'] == 'quantity=desc' ? 'selected=""' : '' ?> value="quantity=desc">High Quantity</option>
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label>상품명:</label>
                            <div class="input-group">
                                <input class="form-control" placeholder="Product Title" type="text" value="<?= isset($_GET['search_title']) ? $_GET['search_title'] : '' ?>" name="search_title">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit" value="">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <label>카테고리:</label>
                            <select name="category" class="form-control selectpicker change-products-form">
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
            if ($products) {
                ?>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>번호</th>
                                <th>화상</th>
                                <th>상품명</th>
                                <th>설명</th>
                                <th>가격</th>
                                <th>SN</th>
                                <th>수량</th>
                                <th>카테고리</th>
                                <th class="text-right">활동</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($products as $row) {
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
                                        <img src="<?= $image ?>" alt="No Image" class="img-thumbnail" style="height:80px;">
                                    </td>
                                    <td>
                                        <?= $row->title ?>
                                    </td>
                                    <td>
                                        <?= $row->description ?>
                                    </td>
                                    <td>
                                        <?= $row->price ?>
                                    </td>
                                    <td>
                                        <?= $row->serial_number ?>
                                    </td>
                                    <td>
                                        <?php
                                        if ($row->quantity > 5) {
                                            $color = 'label-success';
                                        }
                                        if ($row->quantity <= 5) {
                                            $color = 'label-warning';
                                        }
                                        if ($row->quantity == 0) {
                                            $color = 'label-danger';
                                        }
                                        ?>
                                        <span style="font-size:12px;" class="label <?= $color ?>">
                                            <?= $row->quantity ?>
                                        </span>
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
                                    <td>
                                        <div class="pull-right">
                                            <a href="<?= base_url('admin/publish/'.$row->id) ?>" class="btn btn-info">편집</a>
                                            <a href="<?= base_url('admin/products?delete='.$row->id) ?>"  class="btn btn-danger confirm-delete">삭제</a>
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