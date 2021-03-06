<?php
    //help to creat form 
    use yii\bootstrap\ActiveForm;
    //used for submit button;
    use yii\helpers\Html;
?>
<!DOCTYPE html>
<html class="login-bg">
<head>
	<title>慕课商城 - 后台管理</title>
    
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
    <!-- bootstrap -->
    <link href="assets/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/bootstrap/bootstrap-responsive.css" rel="stylesheet" />
    <link href="assets/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="assets/css/layout.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/elements.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/icons.css" />

    <!-- libraries -->
    <link rel="stylesheet" type="text/css" href="assets/css/lib/font-awesome.css" />
    
    <!-- this page specific styles -->
    <link rel="stylesheet" href="assets/css/compiled/signin.css" type="text/css" media="screen" />

    <!-- open sans font -->
    <!--<link href='http://fonts.useso.com/css?family=Open+Sans:300italic,400italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css' />-->

    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /></head>
<body>


    <div class="row-fluid login-wrapper">
        <a class="brand" href="index.html"></a>

        <div class="span4 box">
            
            <?php $form = ActiveForm::begin([
                'fieldConfig' => [
                    'template' => '{error}{input}'
                ]
            ]); ?>
            
            <div class="content-wrap">
                <h6>Imooc Login</h6>
                <h4>
            <?php
                                if (Yii::$app->session->hasFlash('info')) {
                                    echo Yii::$app->session->getFlash('info');
                                }
            ?>
            </h4>
                <?php echo $form->field($model, 'adminuser')->textInput(["class"=>"span12","placeholder"=>"id"]) ?>
                <?php echo $form->field($model, 'adminpass')->passwordInput(["class"=>"span12","placeholder"=>"password"]) ?>
                <a href="<?php echo yii\helpers\Url::to(['public/seekpassword'])?>" class="forgot">Forgot Password?</a>
                <!--remember me now in the database, $model will direct take attribute from database
                hence have to declare this variable in model-->
                <?php echo $form->field($model,'rememberMe')->checkbox([
                    'id'=>"remember-me",
                    'template' => '<div class="remember">{input}<label for="remember-me">Remember Me</label></div>'
                ]); ?>
                <?php echo Html::submitButton('Login',["class"=>"btn-glow primary login"]) ?>
                
            </div>
        </div>
        <?php        ActiveForm::end() ?>
        
    </div>

	<!-- scripts -->
    <script src="assets/js/jquery-latest.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/theme.js"></script>

    <!-- pre load bg imgs -->
    <script type="text/javascript">
        $(function () {
            // bg switcher
            var $btns = $(".bg-switch .bg");
            $btns.click(function (e) {
                e.preventDefault();
                $btns.removeClass("active");
                $(this).addClass("active");
                var bg = $(this).data("img");

                $("html").css("background-image", "url('assets/img/bgs/" + bg + "')");
            });

        });
    </script>

</body>
</html>