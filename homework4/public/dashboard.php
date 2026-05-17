<?php
include_once '../app/Students.php';
$studentNumber = count($students);

?>
<main class="dashboard container p-5 rounded  shadow ">
  <h3>Table of your students</h3>
  <div class="add-container rounded-3">
    <p class="h5"> Number Of Students:
      <?= '0' . $studentNumber; ?>
    </p>
    <a href="addstudent.php" class="btn btn-secondary" style="width:fit-content">
      <i class="fas fa-user-plus" style="margin-right: 16xp;"></i>
      <span>Add Student</span>
    </a>
  </div>
  <table class="table   table-hover">
    <thead>
      <tr class="table-dark">
        <th scope="col"><i class="fas fa-list-ol" style="margin: auto;"></i></th>
        <th scope="col"><i class="fas fa-user" style="margin-right: 16xp;"></i><span> First Name</span></th>
        <th scope="col"><i class="far fa-user" style="margin-right: 16xp;"></i><span> Last Name</span></th>
        <th scope="col"><i class="far fa-user" style="margin-right: 16xp;"></i><span> Age</span></th>
        <th scope="col"><i class="fas fa-at" style="margin-right: 16xp;"></i><span> E-mail</span></th>
        <th scope="col"><i class="fas fa-user-cog" style="margin-right: 16xp;"></i><span> Options</span></th>
      </tr>
    </thead>
    <tbody>

      <?php $n = 1;
            foreach ($students as $student => $stud): ?>
      <tr>
        <th scope="row">
          <?= $n ?>
        </th>
        <td>
          <?= $stud['prenom'] ?>
        </td>
        <td>
          <?= $stud['nom'] ?>
        </td>
        <td>
          <?= $stud['age'] ?>
        </td>
        <td>
          <?= $stud['email'] ?>
        </td>
        <td>
          <div class="options" style="display:flex;justify-content: space-evenly;">
            <a href="updatestudent.php?udpateid=<?= $stud['id'] ?>" class="btn btn-primary"
              style="width:fit-content; margin-right:40px;">
              <i class="fas fa-user-edit" style="margin-right: 16xp;"></i>
              <span>Edit</span>
            </a>
            <a href="../app/Students.php?deleteid=<?= $stud['id'] ?>" class="btn btn-danger"
              style="width:fit-content; ">
              <i class="fas fa-user-minus" style="margin-right: 16xp;"></i>
              <span>Delete</span>
            </a>
          </div>
        </td>
      </tr>
      <?php $n++; endforeach; ?>
    </tbody>
  </table>

</main>
<div class="push" style="height: 16px; margin: 16px;"></div>