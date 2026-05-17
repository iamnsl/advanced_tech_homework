<?php
include_once 'includes/header.php';
include_once '../app/helpers/session_helper.php';
?>

<section class="add container-xxl shadow">
  <a href="index.php" style="font-size: 1.5rem;">
    <i class="fas fa-chevron-circle-left"></i>
  </a>
  <h2 class="text-center my-4">Adding A New Student</h2>
  <form class="row g-3" method="post" action="../app/Students.php">
    <input type="hidden" name="type" value="add">
    <?php flash('add') ?>
    <div class="col-12">
      <label for="inputAddress" class="form-label">First Name</label>
      <input type="text" class="form-control" id="inputAddress" name="prenom" placeholder="M'hamed">
    </div>
    <div class="col-12">
      <label for="inputAddress2" class="form-label">Last Name</label>
      <input type="text" class="form-control" id="inputAddress2" name="nom" placeholder="Bouguerra">
    </div>
    <div class="col-md-6">
      <label for="inputEmail4" class="form-label">Age</label>
      <input type="number" min="18" class="form-control" name="age" id="inputEmail4" placeholder="18">
    </div>
    <div class="col-md-6">
      <label for="inputEmail4" class="form-label">Email</label>
      <input type="email" class="form-control" name="email" id="inputEmail4" placeholder="email_1@example.com">
    </div>
    <div class="col-12 d-grid gap-2 d-md-flex my-5">
      <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus" style="margin-right: 16xp;"></i>
        <span>Add Student</span> </button>
      <a href="index.php" class="btn btn-outline-danger" style="font-size: 1.2rem !important;">
        <i class="fas fa-times" style="margin-right: 16xp;"></i> Cancel</a>
    </div>
  </form>
</section>


<?php
include_once 'includes/footer.php';
?>