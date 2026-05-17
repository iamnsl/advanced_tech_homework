<?php 
    include_once 'includes/header.php';
    include_once '../app/helpers/session_helper.php';
?>



<div class="container-xxl ">
    <section class=" connect  shadow  row  ">
        <div class="login mx_auto p-5 col">

            <h2>Log In</h2>
            <form method="post" action="../app/Users.php">
                <input type="hidden" name="type" value="login">
                <?php flash('login') ?>
                <div class="form-floating mb-3">
                    <input type="text" name="user" class="form-control" id="floatingInput" placeholder="Exapmle_1"
                        autofocus>
                    <label for="floatingInput">Username</label>
                </div>
                <div class="form-floating mb-5">
                    <input type="password" name="password" class="form-control" id="floatingPassword"
                        placeholder="Password">
                    <label for="floatingPassword">Password</label>
                </div>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button type="submit" class="btn btn-primary">Log In</button>
                    <span class="hint">if you dont have acount please sign up!</span>
                    <a href="signup.php" class="btn btn-success" style="width:100%">
                        Sign Up</a>
                </div>
            </form>

        </div>
        <div class="illustration col p-5">
            <img src="assets/illustrations/login.svg" alt="login man">
        </div>
    </section>
    <div class="push"></div>
</div>

<?php 
    include_once 'includes/footer.php'
?>
