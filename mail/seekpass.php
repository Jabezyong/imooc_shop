<p>Dear,<?php echo $adminuser; ?>，Hello:</p>

<p>Link to get back your Password</p>

<?php $url = Yii::$app->urlManager->createAbsoluteUrl(['admin/manage/mailchangepass', 'timestamp' => $time, 'adminuser' => $adminuser, 'token' => $token]); ?>
<p><a href="<?php echo $url; ?>"><?php echo $url; ?></a></p>

<p>This link only Valid for 5minutes.！</p>

<p>This email is generated automatically. Don't reply to this sender！</p>
