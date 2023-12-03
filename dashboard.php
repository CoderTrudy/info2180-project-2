<?php
include_once 'layout.php';
?>
<!DOCTYPE html>
<html lang="en">
<?= page_header("Dashboard") ?>

<!-- Content for Page Here -->
<div class="col py-3 pt-4 page-content">
    <!-- insert here -->
    <div class="card">
        <div class="card-body">
            <h2 class="text-start fw-bold mb-4">Dashboard</h2>
            <hr />
            <!-- filter -->

            <!-- html table -->
            <?= generateContactsTable() ?>
            
        </div>


    </div>
</div>

<?= page_footer() ?>

</html>