<p style="color: red;"><?php if (!empty($error)) { echo $error; } ?></p>

<?php
$form->setup("register");
$form->add("TextElement", array('username', 'username', '', 'Username'));
$form->add("PasswordElement", array('pass1', 'pass1', '', 'Password'));
$form->add("PasswordElement", array('pass2', 'pass2', '', 'Password Again'));
$form->add("SubmitElement", array('submit', 'submit', '', 'Submit'));
$form->render('', '', '', '<br>');

echo $html->create_a('post', 'index', 'Home');
?>