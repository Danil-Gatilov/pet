<?php
/**
 * @var \App\View $view
 * @var \App\session\Session $session
 */
$view->start();
?>
<body>
<div style="display: flex; height:100%; width: 100%; position: fixed; top: 0; left: 0; background-color: ghostwhite">
    <div style="width: 400px; height: 300px; border: #262626 1px solid; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4); margin: auto; " >
        <div style="margin-left: 25px;">
            <form class="row g-3" action="/blog/auth" method="post">

                <div class="row" style="margin-top: 15%">
                    <div class="col">
                        <label for="validationDefaultUsername" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroupPrepend2">@</span>
                            <input type="text" <?php if ($session->checkValue('email')){?> value="<?php echo $session->getRemove('email') ?>" <?php } ?> name="email" class="form-control <?php if ($session->has('email')) {?> is-invalid <?php }?>" id="validationDefaultUsername"
                                   aria-describedby="inputGroupPrepend2" placeholder="<?php
                            if ($session->has('email')){
                                foreach ($session->getRemove('email') as $error) {
                                    echo $error; break;
                                }
                            }
                            ?>">

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="validationDefault02" class="form-label">Password</label>
                        <input type="password" <?php if ($session->checkValue('password')){?> value="<?php echo $session->getRemove('password') ?>" <?php } ?> name="password" class="form-control <?php if ($session->has('password')) {?> is-invalid <?php }?>" id="validationDefault02" placeholder="<?php
                        if ($session->has('password')){
                            foreach ($session->getRemove('password') as $error) {
                                echo $error; break;
                            }
                        }
                        ?>">
                    </div>
                </div>

                <div>
                    <?php if ($session->has('false')) { ?>
                        <p style="color: red"><?php echo $session->getRemove('false') ?></p>
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="col">
                        <button class="btn btn-primary" type="submit">Auth</button>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px">
                    <div class="col">
                        <a href="/blog/register" style="text-decoration: none">Зарегистрироваться</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>