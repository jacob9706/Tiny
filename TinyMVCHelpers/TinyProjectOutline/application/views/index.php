<h1>Welcome</h1>

<p>This is a view called by a controller</p>
<p>This page can be viewed by going to:</p>
<ul>
	<li>yoursite.com</li>
	<li>yoursite.com/index.php</li>
	<li>yoursite.com/index.php/index</li>
	<li>yoursite.com/index.php/index/index</li>
</ul>
<p>This is possible because by default the index.php page is loaded by your browser if you visit a directory.</p>
<p>The third is possible because the controller index is being requested and by default the index method is called.</p>
<p>The last is possible because the controller index is being called and the index method is being called.</p>
<p>Url structure is as follows: yoursite.com/index.php/controller/method/var1/var2/var3</p>
<p>The vars passed through the url can be as above and will be passed to the method as an indexed array starting at 0 for var1.</p>
<p>Variables can also be passed as the following: yoursite.com/index.php/controller/method/var1=hello/var2=world</p>
<p>This will create an associative array. if our method defines the incoming array as $getVars you could access var1 as follows: $getVars['var1'].</p>
<p>You can also mix them as follows: yoursite.com/index.php/controller/method/hello/var2=world</p>
<p>Try this yourself by passing vars into the current url, They will be displayed below.</p>

<pre><?php if (!empty($getVars)) print_r($getVars); ?></pre>