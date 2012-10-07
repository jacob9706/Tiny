<html>
    <head></head>
    <body>
        <h1>Welcome to Our Website!</h1>
        <hr/>
        <h2>News</h2>
        <h4><?php echo $article['title']; ?></h4>
        <p><?php echo $article['content']; ?></p>

        <hr>
        <?php $form->render(); ?>
    	
    	
    	<pre><?php print_r($database_data); ?></pre>