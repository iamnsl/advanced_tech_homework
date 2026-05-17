<?php 
    include_once 'includes/header.php';
    include_once '../app/Students.php';
    $studentNumber= count($students);
?>

<section class="profile container-xxl p-5 shadow">
    <a href="index.php" style="font-size: 1.5rem;">
        <i class="fas fa-chevron-circle-left"></i>
    </a>
    <p class="avatar text-center"><i class="fas fa-user-tie"></i></p>
    <h2 class="text-center my-4"><?php echo $username ?>'s Profile</h2>

    <div class="content p-2 rounded text-center" style="background-color: #f8f7f7;">
        <h4>Your Informations</h4>
        <span>
            <p class="h5">Username</p> <?php echo $username ?>
        </span>
        <span>
            <p class="h5">Number of students</p> <?php echo $studentNumber ?> students
        </span> <br>
        <a href="../app/Users.php?q=logout" style="margin-top: 32px;
    display: inherit;">
            <span class="btn btn-dark">Log Out</span>
        </a>
    </div>
</section>


<?php 
    include_once 'includes/footer.php';
?>
