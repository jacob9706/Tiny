<p style="color: red;"><?php if (!empty($error)) { echo $error; } ?></p>

<?php
$form->setup("login");
$form->add("TextElement", array('username', 'username', '', 'Username'));
$form->add("PasswordElement", array('password', 'password', '', 'Password'));
$form->add("SubmitElement", array('login', 'login', '', 'Login'));
$form->render('', '', '', '<br>');

echo $html->create_a('post', 'index', 'Home');
?>