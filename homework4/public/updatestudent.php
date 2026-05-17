<?php
if (isset($_GET["udpateid"])) {
    $udpateid = $_GET["udpateid"];
}
include_once 'includes/header.php';
include_once '../app/Students.php';
include_once '../app/helpers/session_helper.php';

?>
<section class="add container-xxl shadow">
  <a href="index.php" style="font-size: 1.5rem;">
    <i class="fas fa-chevron-circle-left"></i>
  </a>
  <h2 class="text-center my-4">Editing Student</h2>
  <form class="row g-3" method="post" action="../app/Students.php">
    <input type="hidden" name="type" value="update">
    <input type="hidden" name="updateid" value="<?= $udpateid ?>">
    <?php flash('update') ?>
    <div class="col-12">
      <label for="inputAddress" class="form-label">First Name</label>
      <input type="text" class="form-control" id="inputAddress" name="prenom" value="<?= $updatestud['prenom'] ?>">
    </div>
    <div class="col-12">
      <label for="inputAddress2" class="form-label">Last Name</label>
      <input type="text" class="form-control" id="inputAddress2" name="nom" value="<?= $updatestud['nom'] ?>">
    </div>
    <div class="col-12">
      <label for="inputAddress2" class="form-label">Age</label>
      <input type="number" class="form-control" id="inputAddress2" name="age" value="<?= $updatestud['age'] ?>">
    </div>
    <div class="col-md-6">
      <label for="inputEmail4" class="form-label">Email</label>
      <input type="email" class="form-control" name="email" id="inputEmail4" value="<?= $updatestud['email'] ?>">
    </div>
    <div class="col-12 d-grid gap-2 d-md-flex my-5">
      <button type="submit" class="btn btn-primary"><i class="fas fa-user-edit" style="margin-right: 16xp;"></i>
        <span>Edit Student</span> </button>
      <a href="index.php" class="btn btn-outline-danger" style="font-size: 1.2rem !important;">
        <i class="fas fa-times" style="margin-right: 16xp;"></i> Cancel</a>
    </div>
  </form>
</section>
<?php
include_once 'includes/footer.php'
    ?>