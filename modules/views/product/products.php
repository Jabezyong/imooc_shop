    <link rel="stylesheet" href="assets/admin/css/compiled/user-list.css" type="text/css" media="screen" />
    <!-- main container -->
    <div class="content">
        
        <div class="container-fluid">
            <div id="pad-wrapper" class="users-list">
                <div class="row-fluid header">
                    <h3>Product List</h3>
                    <div class="span10 pull-right">
                        <a href="<?php echo yii\helpers\Url::to(['product/add']) ?>" class="btn-flat success pull-right">
                            <span>&#43;</span>
                            New product
                        </a>
                    </div>
                </div>

                <!-- Users table -->
                <div class="row-fluid table">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="span6 sortable">
                                    <span class="line"></span>Name
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>Quantity
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>Single Price
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>Hot Sales
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>Promotion
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>Pro Price
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>OnShelf
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>Recommended
                                </th>

                                <th class="span3 sortable align-right">
                                    <span class="line"></span>Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <!-- row -->
                        <?php foreach($products as $product): ?>
                        <tr class="first">
                            <td>
                                <img src="<?php echo 'pics  /'.$product->productid .'/'. $product->cover ?>" class="img-circle avatar hidden-phone" />
                                <a href="<?php echo yii\helpers\Url::to(['product/mod', 'productid' => $product->productid]); ?>"><?php echo $product->title; ?></a>
                            </td>
                            <td>
                                <?php echo $product->num; ?>
                            </td>
                            <td>
                                <?php echo $product->price; ?>
                            </td>
                            <td>
                                <?php $hot = ['No', 'Yes'] ?>
                                <?php echo $hot[$product->ishot]; ?>
                            </td>
                            <td>
                                <?php $sale = ['No', 'Yes']?>
                                <?php echo $sale[$product->issale]; ?>
                            </td>
                            <td>
                                <?php echo $product->saleprice; ?>
                            </td>
                            <td>
                                <?php $on = ['No', 'Yes'] ?>
                                <?php echo $on[$product->ison]; ?>
                            </td>
                            <td>
                                <?php $on = ['No', 'Yes']?>
                                <?php echo $on[$product->istui]; ?>
                            </td>

                            <td class="align-right">
                            <a href="<?php echo yii\helpers\Url::to(['product/mod', 'productid' => $product->productid]); ?>">Mod</a>
    <!--                            <a href="<?php echo yii\helpers\Url::to(['product/on', 'productid' => $product->productid]); ?>">OnShelf</a>
                                <a href="<?php echo yii\helpers\Url::to(['product/off', 'productid' => $product->productid]); ?>">OffShelf</a>-->
                            <a href="<?php echo yii\helpers\Url::to(['product/del', 'productid' => $product->productid]); ?>">Del</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="pagination pull-right">
                    <?php echo yii\widgets\LinkPager::widget([
                        'pagination' => $pager,
                        'prevPageLabel' => '&#8249;',
                        'nextPageLabel' => '&#8250;',
                    ]); ?>
                </div>
                <!-- end users table -->
            </div>
        </div>
    </div>
    <!-- end main container -->
