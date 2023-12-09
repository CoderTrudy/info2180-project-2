<?php
include_once 'layout.php';
?>
<!DOCTYPE html>
<html lang="en">
<?= page_header("Dashboard") ?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="dboard.css">
<!-- Content for Page Here -->
<div class="col py-3 pt-4 page-content">
    <!-- insert here -->
    <h2 class="text-start fw-bold mb-4">Dashboard</h2>
    <div class="card">
        <div class="card-body">
            
            <hr />
            <!-- filter -->

            <!-- html table -->
            <?= generateContactsTable() ?>
            
        </div>


    </div>
</div>
<script src="dboard.js"></script>
<?= page_footer() ?>

</html>