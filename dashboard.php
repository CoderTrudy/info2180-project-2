<?php
include_once 'layout.php';
?>
<!DOCTYPE html>
<html lang="en">
<?= page_header("Dashboard") ?>

<!-- Content for Page Here -->
<div class="col py-3 pt-4 page-content">
    <!-- insert here -->
    <div class="row">
        <div class="col">
            <h2 class="text-start fw-bold mb-4">Dashboard</h2>
        </div>
        <div class="col text-end">
            <a href="add-contact.php"class="btn btn-primary"><i class ="fa-solid fa-plus"></i> Add Contact</a>
        </div>
    <hr />
            <!-- filter -->
            <!-- html table -->
            <?= generateContactsTable() ?>
            
    


    </div>
</div>

<?= page_footer() ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function handleAdd() {
        // Get form data
        var formData = $('#sign-up-form').serialize();

        // AJAX form submission
        $.ajax({
            url: 'dashboard.php', 
            method: 'POST',
            data: formData,
            success: function(response) {
                // Handle success response
                $('#responseMessage').html(response); // Display response message
                $('#sign-up-form')[0].reset(); // Reset the form after successful submission
            },
            error: function(xhr, status, error) {
                // Handle error response
                $('#responseMessage').html('<div class="alert alert-danger">Error occurred.</div>');
            }
        });
    }
</script>

</html>