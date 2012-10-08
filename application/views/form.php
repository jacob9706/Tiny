<h2>Form</h2>

<?php
$form->setup("new_post");
$form->add("TextElement", array('title', 'title', '', 'Title'));
$form->add("TextElement", array('post', 'post', '', 'Post'));
$form->add("SubmitElement", array('submit', 'submit', '', 'Submit'));
$form->render('', '', '', '<br>');

echo $html->create_link('post', 'index', 'Home');
?>