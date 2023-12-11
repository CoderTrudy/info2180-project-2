<?php
include_once 'layout.php';
?>
<!DOCTYPE html>
<html lang="en">
<?= page_header("Add User") ?>

<!-- Content for Page Here -->
<div class="col py-3 pt-4 page-content">
    <!-- insert here -->
    <h2 class="text-start fw-bold mb-4">New User</h2>
    <div class="card">
        <div class="card-body">
            <!-- information -->
            <?php

            if (isset($_POST['sign-up'])) {
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $email = $_POST['email'];
                $role = $_POST['role'];
                $psw = $_POST['psw'];
                $result = addUser($email, $psw, $firstname, $lastname, $role);
                if ($result['success']) {
                    echo "<div class='alert alert-success'>$result[message]</div>";
                } else {
                    echo "<div class='alert alert-danger'>$result[message]</div>";
                }

                //clear post
                $_POST = array();

            }

            ?>

            <form id="sign-up-form" action="<?=base_url("new-user")?>" method="post">
            <div class="row">
                <div class="col-md">
                    <div class="form-field">
                        <div class="form-field">
                            <label class="form-label" for="firstname">First name</label>
                            <input class="form-control" type="text" id="firstname" name="firstname" placeholder="Jane" required>
                        </div>
                        <div class="form-field">
                            <label class="form-label" for="lname">Last name</label>
                            <input class="form-control" type="text" id="lastname" name="lastname" placeholder="Doe" required>
                        </div>
                        <div class="form-field">
                            <label class="form-label" for="email">Email</label>
                            <input class="form-control" type="text" id="email" name="email" placeholder="something@example.com" required>
                        </div>
                    </div>
                </div>
                <div class="col-md">
                    <div class="form-field">
                        <label class="form-label" for="role">Role</label>
                        <select class="form-select" id="role" name="role">
                            <option value="admin">Admin</option>
                            <option value="member">Member</option>
                        </select>
                    </div>
                    <div class="form-field">
                        <label class="form-label" for="psw" required>Password</label>
                        <input class="form-control" type="text" id="psw" name="psw" required>
                    </div>
                    <div class="form-field ">
                        <br>
                        <button class="btn btn-primary float-end" class="save-button" onclick="handleAdd()" name="sign-up">Save</button>
                    </div>
                </div>
            </div>
            </form>
        </div>


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
            url: 'new-user.php', // Replace 'process.php' with your backend endpoint
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