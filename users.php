<?php
include_once 'layout.php';
?>
<!DOCTYPE html>
<html lang="en">
<?= page_header("Users") ?>

<!-- Content for Page Here -->
<div class="col py-3 pt-4 page-content">
    <!-- insert here -->
    <!-- table with all users -->
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="text-start fw-bold mb-4">Users</h2>
                </div>
                <div class="col">
                    <!-- add btn to the right -->
                    <a href="new-user.php" class="btn btn-primary float-end">Add User</a>
                </div>
            </div>



            <!-- html table -->
            <?= generateUsersTable() ?>

        </div>
    </div>
</div>

<?= page_footer() ?>

</html>