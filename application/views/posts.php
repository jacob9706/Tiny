<h1>Blog posts</h1>

<?php
$form->setup('search_form');
$form->add("TextElement", array('search', 'search', '', 'Search Posts'));
$form->add("SubmitElement", array('submit', 'submit', '', 'Search'));
$form->render();
?>

<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
    </tr>

    <!-- Here is where we loop through our $posts array, printing out post info -->
    <?php foreach ($posts as $post): ?>
    <tr>
        <td><?php echo $html->create_link('post', 'show', $post['id'], array('id' =>$post['id'])); ?></td>
        <td>
            <?php echo $html->create_link('post', 'show', $post['title'], array('id' =>$post['id'])); ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php unset($post); ?>
</table>

<p><?php echo $html->create_link('post', 'new_post', 'Create New Post'); ?></p>