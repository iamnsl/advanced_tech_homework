<?php 
    include_once 'includes/header.php';
?>

<?php if(isset($_SESSION['id'])){
        require 'dashboard.php';
    }else{
        require 'home.php';
    }
    ?>


<?php 
    include_once 'includes/footer.php'
?>
