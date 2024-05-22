<?php
/**
 * @var \App\View $view
 * @var \App\session\Session $session
 */
$view->start();
?>
<body>
<div style="display: flex; height:100%; width: 100%; position: fixed; top: 0; left: 0; background-color: ghostwhite">
    <div style="width: 400px; height: 450px; border: #262626 1px solid; box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.4); margin: auto; ">
        <div style="margin-left: 25px;">
            <form class="row g-3" action="/blog/register" method="post">
                <div class="row" style="margin-top: 50px">
                    <div class="col">
                        <label for="validationDefault01" class="form-label">First name <?php echo ''?></label>
                        <input type="text" <?php if ($session->checkValue('firstName')) { ?> value="<?php echo $session->getRemove('firstName') ?>" <?php } ?>
                               name="firstName"
                               class="form-control <?php if ($session->has('firstName')) { ?> is-invalid <?php } ?>"
                               id="validationDefault01" placeholder="<?php
                        if ($session->has('firstName')) {
                            foreach ($session->getRemove('firstName') as $error) {
                                echo $error;
                                break;
                            }
                        } else {
                            echo 'Enter name';
                        }
                        ?>">

                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="validationDefault02" class="form-label">Last name</label>
                        <input type="text" <?php if ($session->checkValue('lastName')) { ?> value="<?php echo $session->getRemove('lastName') ?>" <?php } ?>
                               name="lastName"
                               class="form-control <?php if ($session->has('lastName')) { ?> is-invalid <?php } ?>"
                               id="validationDefault02" placeholder="<?php
                        if ($session->has('lastName')) {
                            foreach ($session->getRemove('lastName') as $error) {
                                echo $error;
                                break;
                            }
                        } else {
                            echo 'Enter last name';
                        }
                        ?>">

                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="validationDefaultUsername" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text" id="inputGroupPrepend2">@</span>
                            <input type="text" <?php if ($session->checkValue('email')) { ?> value="<?php echo $session->getRemove('email') ?>" <?php } ?>
                                   name="email"
                                   class="form-control <?php if ($session->has('email')) { ?> is-invalid <?php } ?>"
                                   id="validationDefaultUsername"
                                   aria-describedby="inputGroupPrepend2" placeholder="<?php
                            if ($session->has('email')) {
                                foreach ($session->getRemove('email') as $error) {
                                    echo $error;
                                    break;
                                }
                            }
                            ?>">

                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <label for="validationDefault02" class="form-label">Password</label>
                        <input type="password" <?php if ($session->checkValue('password')) { ?> value="<?php echo $session->getRemove('password') ?>" <?php } ?>
                               name="password"
                               class="form-control <?php if ($session->has('password')) { ?> is-invalid <?php } ?>"
                               id="validationDefault02" placeholder="<?php
                        if ($session->has('password')) {
                            foreach ($session->getRemove('password') as $error) {
                                echo $error;
                                break;
                            }
                        }
                        ?>">
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Register</button>
                </div>
                <div class="row" style="margin-top: 20px">
                    <div class="col">
                        <a href="/blog/auth" style="text-decoration: none">У меня есть аккаунт</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
