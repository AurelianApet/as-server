<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="<?= $description ?>">
        <title><?= $title ?></title>
        <link href="<?= base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?= base_url('assets/css/font-awesome.min.css') ?>">
        <link rel="stylesheet" href="<?= base_url('assets/bootstrap-select-1.12.1/bootstrap-select.min.css') ?>">
        <link href="<?= base_url('assets/css/custom-admin.css') ?>" rel="stylesheet">
        <!-- <link href='https://fonts.googleapis.com/css?family=Inconsolata' rel='stylesheet' type='text/css'> -->
        <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
        <style>
            #messages { list-style-type: none; margin: 0; padding: 0; }
            #messages li { padding: 5px 10px; font-size: 18px; color: #46b8da; /*text-align: right;*/}
            #messages li:nth-child(odd) { background: #eee; font-size: 18px; color:#2e6da4; }
        </style>
     </head>
    <body>
        <div id="wrapper">
            <div id="content">
                <?php if ($this->session->userdata('logged_in')) { ?>
                    <nav class="navbar navbar-default">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                                <i class="fa fa-lg fa-bars"></i>
                            </button>
                        </div>
                        <div id="navbar" class="collapse navbar-collapse">
                            <ul class="nav navbar-nav">
                                <li><a href="<?= base_url('admin') ?>"><i class="fa fa-home"></i> 첫페지</a></li>
                                <li>
                                    <a href="javascript:void(0);" class="h-settings"><i class="fa fa-key" aria-hidden="true"></i>비번변경</a>
                                    <div class="relative">
                                        <div class="settings">
                                            <div class="panel panel-primary" >
                                                <div class="panel-heading">
                                                    <div class="panel-title">보안</div>
                                                </div>     
                                                <div class="panel-body">
                                                    <label>비번변경</label> <span class="bg-success" id="pass_result">변경!</span>
                                                    <form class="form-inline" role="form">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control new-pass-field" placeholder="New password" name="new_pass">
                                                        </div>
                                                        <a href="javascript:void(0);" onclick="changePass()" class="btn btn-sm btn-primary">변경</a>
                                                        <hr>
                                                        <span>비번등급:</span>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 0;">
                                                            </div>
                                                        </div>
                                                        <button type="button" class="btn btn-default generate-pwd">비번생성</button> 
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="<?= base_url('admin/logout') ?>"><i class="fa fa-sign-out"></i> 로그아웃</a></li>
                            </ul>
                        </div>
                    </nav>
                <?php } ?>
                <div class="container-fluid">
                    <div class="row">
                        <?php if ($this->session->userdata('logged_in')) { ?>
                            <div class="col-sm-3 col-md-3 col-lg-2 left-side navbar-default">
                                <div class="show-menu">
                                    <a id="show-xs-nav" class="visible-xs" href="javascript:void(0)">
                                        <span class="show-sp">
                                            Show menu
                                            <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i>
                                        </span>
                                        <span class="hidde-sp">
                                            Hide menu
                                            <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i>
                                        </span>
                                    </a>
                                </div>
                                <ul class="sidebar-menu">
                                    <li class="header">설치가이드관리</li>
                                    <li>
                                        <a href="<?= base_url('admin/addguide') ?>" <?= urldecode(uri_string()) == 'admin/addguide' ? 'class="active"' : '' ?>><i class="fa fa-plus" aria-hidden="true"></i> 설치가이드추가</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('admin/guides') ?>" <?= urldecode(uri_string()) == 'admin/guides' ? 'class="active"' : '' ?>><i class="fa fa-book" aria-hidden="true"></i> Guides</a>
                                    </li>

                                    <li class="header">자주하는질문관리</li>
                                    <li>
                                        <a href="<?= base_url('admin/addquestion') ?>" <?= urldecode(uri_string()) == 'admin/addquestion' ? 'class="active"' : '' ?>><i class="fa fa-plus" aria-hidden="true"></i> 자주하는질문추가</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('admin/questions') ?>" <?= urldecode(uri_string()) == 'admin/questions' ? 'class="active"' : '' ?>><i class="fa fa-question" aria-hidden="true"></i> 자주하는질문</a>
                                    </li>

                                    <li class="header">수리접수관리</li>
                                    <li>
                                        <a href="<?= base_url('admin/repairs') ?>" <?= urldecode(uri_string()) == 'admin/repairs' ? 'class="active"' : '' ?>><i class="fa fa-gears" aria-hidden="true"></i> 수리접수</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('admin/orders') ?>" <?= urldecode(uri_string()) == 'admin/orders' ? 'class="active"' : '' ?>>
                                            <i class="fa fa-money" aria-hidden="true"></i> 주문 
                                            <?php if ($numNotPreviewOrders > 0) { ?>
                                                <img src="<?= base_url('assets/imgs/exlamation-hi.png') ?>" style="position: absolute; right:10px; top:7px;" alt="">
                                            <?php } ?>
                                        </a>
                                    </li>

                                    <li class="header">부품관리</li>
                                    <li>
                                        <a href="<?= base_url('admin/attachs') ?>" <?= urldecode(uri_string()) == 'admin/attachs' ? 'class="active"' : '' ?>><i class="fa fa-files-o" aria-hidden="true"></i> 부품목록</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('admin/attachCategories') ?>" <?= urldecode(uri_string()) == 'admin/attachCategories' ? 'class="active"' : '' ?>><i class="fa fa-list-alt" aria-hidden="true"></i> 카테고리</a>
                                    </li>
                                    <li class="header">특가상품관리</li>
                                    <li>
                                        <a href="<?= base_url('admin/products') ?>" <?= urldecode(uri_string()) == 'admin/products' ? 'class="active"' : '' ?>><i class="fa fa-files-o" aria-hidden="true"></i> 특가상품</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('admin/categories') ?>" <?= urldecode(uri_string()) == 'admin/categories' ? 'class="active"' : '' ?>><i class="fa fa-list-alt" aria-hidden="true"></i> 카테고리</a>
                                    </li>

                                    <li class="header">문의관리</li>
                                    <li>
                                        <a href="<?= base_url('admin/questionlist') ?>" <?= urldecode(uri_string()) == 'admin/questionlist' ? 'class="active"' : '' ?>><i class="fa fa-warning" aria-hidden="true"></i> 문의</a>
                                    </li>

                                    <li class="header">유저관리</li>
                                    <li>
                                        <a href="<?= base_url('admin/adminusers') ?>" <?= urldecode(uri_string()) == 'admin/adminusers' ? 'class="active"' : '' ?>><i class="fa fa-user" aria-hidden="true"></i> 관리자</a>
                                    </li>
                                    <li>
                                        <a href="<?= base_url('admin/users') ?>" <?= urldecode(uri_string()) == 'admin/users' ? 'class="active"' : '' ?>><i class="fa fa-user" aria-hidden="true"></i> 유저</a>
                                    </li>

                                    <li class="header">설정</li>
                                    <li><a href="<?= base_url('admin/settings') ?>" <?= urldecode(uri_string()) == 'admin/settings' ? 'class="active"' : '' ?>><i class="fa fa-wrench" aria-hidden="true"></i> 푸쉬설정</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-9 col-md-9 col-lg-10 col-sm-offset-3 col-md-offset-3 col-lg-offset-2">
                                <?php if ($warnings != null) { ?>
                                    <div class="alert alert-danger">
                                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                        There are some errors that you must fix!
                                        <ol>
                                            <?php foreach ($warnings as $warning) { ?>
                                                <li><?= $warning ?></li>
                                            <?php } ?>
                                        </ol>
                                    </div>
                                    <?php
                                }
                            } else {
                                ?>
                                <div>
                            <?php } ?>

