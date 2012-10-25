
            <hr>

            <footer>
                <p>&copy; Company 2012</p>
            </footer>

        </div> <!-- /container -->

        <?php echo $html->create_script('static/js/vendor/jquery-1.8.2.min.js'); ?>
        <!--
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.8.2.min.js"><\/script>')</script>
        -->

        <?php echo $html->create_script('static/js/vendor/bootstrap.min.js'); ?>

        <script type="text/javascript">
        $(function() {
        <?php 
            if (!empty($login_error)): ?>
                $('#nav-login').modal();
                $('#nav-login').modal('show');
            <?php endif; ?>

            <?php 
            if (!empty($register_error)): ?>
                $('#nav-register').modal();
                $('#nav-register').modal('show');
            <?php endif; ?>
        });
        </script>

        <?php echo $html->create_script('static/js/main.js'); ?>
    </body>
</html>
