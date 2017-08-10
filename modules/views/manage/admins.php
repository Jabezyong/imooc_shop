
	<!-- main container -->
    <div class="content">
      
        <div class="container-fluid">
            <div id="pad-wrapper" class="users-list">
                <div class="row-fluid header">
                    <h3>Users</h3>
                    <div class="span10 pull-right">
                        <input type="text" class="span5 search" placeholder="Type a user's name..." />
                        
                        <!-- custom popup filter -->
                        <!-- styles are located in css/elements.css -->
                        <!-- script that enables this dropdown is located in js/theme.js -->
                        <div class="ui-dropdown">
                            <div class="head" data-toggle="tooltip" title="Click me!">
                                Filter users
                                <i class="arrow-down"></i>
                            </div>  
                            <div class="dialog">
                                <div class="pointer">
                                    <div class="arrow"></div>
                                    <div class="arrow_border"></div>
                                </div>
                                <div class="body">
                                    <p class="title">
                                        Show users where:
                                    </p>
                                    <div class="form">
                                        <select>
                                            <option />Name
                                            <option />Email
                                            <option />Number of orders
                                            <option />Signed up
                                            <option />Last seen
                                        </select>
                                        <select>
                                            <option />is equal to
                                            <option />is not equal to
                                            <option />is greater than
                                            <option />starts with
                                            <option />contains
                                        </select>
                                        <input type="text" />
                                        <a class="btn-flat small">Add filter</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <a href="<?php echo yii\helpers\Url::to(['add'])?>" class="btn-flat success pull-right">
                            <span>&#43;</span>
                            NEW ADMIN
                        </a>
                    </div>
                </div>

                <!-- Users table -->
                <div class="row-fluid table">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="span4 sortable">
                                    Admin ID
                                </th>
                                <th class="span3 sortable">
                                    <span class="line"></span>Acc
                                </th>
                                <th class="span2 sortable">
                                    <span class="line"></span>Email
                                </th>
                                <th class="span3 sortable align-right">
                                    <span class="line"></span>Last Login
                                </th>
                                 <th class="span3 sortable align-right">
                                    <span class="line"></span>Last ip
                                </th>
                                 <th class="span3 sortable align-right">
                                    <span class="line"></span>Signup Time
                                </th>
                                <th class="span3 sortable align-right">
                                    <span class="line"></span>Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                        <!-- row -->
                        <?php foreach ($admins as $admin): ?>
                        <tr class="first">
                            <td>
                                <?php echo $admin->adminid;?>
                            </td>
                            <td>
                               <?php echo $admin->adminuser;?>
                            </td>
                            <td>
                                <?php echo $admin->adminemail;?>
                            </td>
                            <td>
                                <?php echo date('Y-m-d H:i:s',$admin->logintime)?>
                            </td>
                            <td>
                                <?php echo long2ip($admin->loginip)?>
                            </td>
                            <td>
                                <?php echo  date('Y-m-d H:i:s',$admin->createtime)?>
                            </td>
                            
                            <td class="align-right">
                                <a href="<?php echo yii\helpers\Url::to(['manage/del','adminid'=>$admin->adminid])?>">Delete</a>
                            </td>
                        </tr>
                        
                        <!-- row -->
                        <?php endforeach ;?>
                        </tbody>
                    </table>
                    <?php
                        if(Yii::$app->session->hasFlash('info')){
                            echo Yii::$app->session->getFlash('info');
                        }
                    ?>
                </div>
                <div class="pagination pull-right">
                    <?php echo yii\widgets\LinkPager::widget(['pagination'=>$pager,'prevPageLabel'=>'&#8249;','nextPageLabel'=>'&#8250;']);?>
                    
                </div>
                <!-- end users table -->
            </div>
        </div>
    </div>
    <!-- end main container -->


	<!-- scripts -->
    <script src="js/jquery-latest.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/theme.js"></script>

</body>
</html>