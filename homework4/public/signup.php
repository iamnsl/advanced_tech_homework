<?php 
  include_once 'includes/header.php';
  include_once '../app/helpers/session_helper.php';
?>

<div class="container-xxl page-body">
    <section class="connect  shadow  row">
        <div class="signup mx_auto p-5 col">

            <h2>Sign Up</h2>
            <?php flash('register') ?>
            <form method="post" action="../app/Users.php">
                <input type="hidden" name="type" value="register">
                <?php flash('register') ?>
                <div class="form-floating mb-3">
                    <input type="text" name="user" class="form-control" id="floatingInput" placeholder="Example_1"
                        autofocus>
                    <label for="floatingInput">Username</label>
                </div>

                <div class="form-floating mb-3">
                    <input type="password" name="password" class="form-control" id="floatingPassword"
                        placeholder="Password">
                    <label for="floatingPassword">Password</label>
                </div>

                <div class="form-floating mb-5">
                    <input type="password" name="pwdRepeat" class="form-control" id="floatingPassword"
                        placeholder="Password">
                    <label for="floatingPassword">Password</label>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" name="submit" class="btn btn-success">Sign Up</button>
                    <a href="login.php" class="btn btn-outline-danger">
                        Cancel</a>
                </div>

            </form>

        </div>
        <div class="illustration col p-5">
            <img src="assets/illustrations/login.svg" alt="" style="max-width: 100%;min-width:350px;">
        </div>
    </section>
    <div class="push"></div>
</div>
<?php 
    include_once 'includes/footer.php'
?>
