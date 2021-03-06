<?php
    use yii\bootstrap\ActiveForm;
    use yii\helpers\Html;
    ?>

<link rel="stylesheet" href="assets/admin/css/compiled/new-user.css" type="text/css" media="screen" />
    <!-- main container -->
    <div class="content">
        
        <div class="container-fluid">
            <div id="pad-wrapper" class="new-user">
                <div class="row-fluid header">
                    <h3>Change Password</h3>
                </div>

                <div class="row-fluid form-wrapper">
                    <!-- left column -->
                    <div class="span9 with-sidebar">
                        <div class="container">
                            <?php
                            if(Yii::$app->session->hasFlash('info')){
                                echo Yii::$app->session->getFlash('info');
                            }
                            $form = ActiveForm::begin([
                                'options' => ['class'=>'new_user_form inline-input'],
                                'fieldConfig'=>[
                                    'template'=>'<div class="span12 field-box">{label}{input}{error}</div>'
                                ],
                            ]);
                                    ?>
                            <?php echo $form->field($model,'adminuser')->textInput(['class'=>'span9','disabled'=>true]);?>
                            <?php echo $form->field($model,'currentpass')->passwordInput(['class'=>'span9']);?>
                            <?php echo $form->field($model,'adminpass')->passwordInput(['class'=>'span9']);?>
                            <?php echo $form->field($model,'repass')->passwordInput(['class'=>'span9']);?>

                                
                                
                                <div class="span11 field-box actions">
                                    <?php echo Html::submitButton('Save',['class'=>'btn-glow primary']);?>
                                    
                                    <span>或者</span>
                                    <?php echo Html::resetButton('Reset',['class'=>'reset']);?>
                                    
                                </div>
                            <?php ActiveForm::end()?>
                        </div>
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
    <!-- end main container -->
