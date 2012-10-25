<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <?php echo $html->create_a('index', 'index', 'Logo Here', '', 'class="brand" style="color: #00cc33;"'); ?>
            
            <?php if (!$users->get_status()): ?>
                <div class="nav-collapse collapse pull-right">
                    <button class="btn btn-success" data-toggle="modal" data-target="#nav-register">Register</button>
                    <button class="btn btn-info" data-toggle="modal" data-target="#nav-login">Sign In</button>
                </div><!--/.nav-collapse -->
            <?php else: ?>
                <div class="nav-collapse collapse pull-right">
                    <?php echo $html->create_a('dashboard', 'home', 'Dashboard', '', 'class="btn btn-success"'); ?>
                    <?php echo $html->create_a('admin', 'logout', 'Logout', '', 'class="btn btn-danger"'); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<div id="nav-login" class="modal hide fade">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Login</h3>
    </div>
    <div class="modal-body">

        <?php
        $login_error = empty($GLOBALS['getVars']['login_error']) ? null : $GLOBALS['getVars']['login_error'];
        if (!empty($login_error)): ?>
        <p style="color: red;"><?php echo $login_error; ?></p>
        <?php endif;

        $login_form->setup('login', 'admin/login');
        $login_form->add('TextElement', array('username', 'username', '', 'Username'));
        $login_form->add('PasswordElement', array('password', 'password', '', 'Password'));
        $login_form->add('SubmitElement', array('login', 'login', 'btn btn-success', 'Login'));
        echo $login_form->render('', '', '', '<br>');
        ?>
    </div>
</div>

<div id="nav-register" class="modal hide fade">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3>Register</h3>
    </div>
    <div class="modal-body">
        <?php
        $register_error = empty($GLOBALS['getVars']['register_error']) ? null : $GLOBALS['getVars']['register_error'];
        if (!empty($register_error)): ?>
        <p style="color: red;"><?php echo $register_error; ?></p>
        <?php endif;

        $register_form->setup('register', 'admin/register');
        $register_form->add("TextElement", array('username', 'username', '', 'Username'));
        $register_form->add("TextElement", array('email', 'email', '', 'Email'));
        $register_form->add("PasswordElement", array('pass1', 'pass1', '', 'Password'));
        $register_form->add("PasswordElement", array('pass2', 'pass2', '', 'Password Again'));
        $register_form->add("SubmitElement", array('submit', 'submit', '', 'Submit'));
        $register_form->render('', '', '', '<br>');
        ?>
    </div>
</div>