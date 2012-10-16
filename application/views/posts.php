<h1>Blog posts</h1>

<?php
$form->setup('search_form');
$form->add("TextElement", array('search', 'search', '', 'Search Posts'));
$form->add("SubmitElement", array('submit', 'submit', '', 'Search'));
$form->render();
?>

<table class="table table-striped">
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Remove</th>
    </tr>

    <!-- Here is where we loop through our $posts array, printing out post info -->
    <?php foreach ($posts as $post): ?>
    <tr>
        <td><?php echo $html->create_a('post', 'show', $post['id'], array('id' => $post['id'])); ?></td>
        <td>
            <?php echo $html->create_a('post', 'show', $post['title'], array('id' => $post['id'])); ?>
        </td>
        <td>
            <?php echo $html->create_a('post', 'remove_post', 'Delete', array('id' => $post['id']), 'class="btn btn-warning"'); ?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php unset($post); ?>
</table>

<p><?php echo $html->create_a('post', 'new_post', 'Create New Post'); ?></p>