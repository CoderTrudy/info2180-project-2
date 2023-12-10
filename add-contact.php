<?php
    session_start();
 
    include_once 'layout.php'; 
?>
<!DOCTYPE html>
<html lang="en">
    
<?= page_header("Add Contact") ?>

<!-- Content for Page Here -->
<div class="col py-3 pt-4 page-content">
    <!-- insert here -->
    <div class="card">
        <div class="card-body">
            <!-- PHP goes here -->
            <?php
         
                if(isset($_POST['add-contact'])) {
                    $title = $_POST['title'];
                    $firstname = $_POST['firstname'];
                    $lastname = $_POST['lastname'];
                    $email = $_POST['email'];
                    $company = $_POST['company'];
                    $assignedto = $_POST['assignedto'];
                    $telephone = $_POST['telephone'];
                    $telephone = formatPhone($telephone);
                    $type = $_POST['type'];
                    $current_user = $_SESSION['user']['id'];
                    $result = addContact($title, $firstname, $lastname, $email, $company, $telephone, $assignedto, $type, $current_user);
                    if ($result['success']) {
                        echo "<div class='alert alert-success'>$result[message]</div>";
                    } else {
                        echo "<div class='alert alert-danger'>$result[message]</div>";
                    }

                    $_POST = array();
                }
            ?>

            <h2 class="text-start fw-bold mb-4">Add Contact</h2>
            <form id="contact-form" action="<?=base_url("add-contact")?>" method="post">
                <div class="row">
                    <!-- Title -->
                    <div class="form-field">
                        <label class="form-label" for="title">Title</label>
                        <select class="form-select" id="title" name="title" style="width:80px;" required>
                            <option value="Mr">Mr</option>
                            <option value="Ms">Ms</option>
                            <option value="Mrs">Mrs</option>
                            <option value="Dr">Dr</option>
                        </select>
                    </div>
                    <!-- Column 1 -->
                    <div class="col-md">
                        <div class="form-field">
                            <!-- First Name -->
                            <div class="form-field">
                                <label class="form-label" for="firstname">First Name</label>
                                <input class="form-control" type="text" id="firstname" name="firstname" required>
                            </div>
                            <!-- Email -->
                            <div class="form-field">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-control" type="email" id="email" name="email" required>
                            </div>
                            <!-- Company -->
                            <div class="form-field">
                                <label class="form-label" for="company">Company</label>
                                <input class="form-control" type="text" id="company" name="company" required>
                            </div>
                            <!-- Assigned to -->
                            <div class="form-field">
                                <label class="form-label" for="assignedto">Assigned To</label>
                                <select class="form-select" id="assignedto" name="assignedto" required>
                                    
                                <!-- should list the names of all the users in the system-->
                                    <?php
                                        $allusers = getUsers();
                                        while ($row = $allusers->fetch_assoc()) {
                                            echo "<option value='" . $row['id'] . "'>" . $row['firstname'] . " " . $row['lastname'] . "</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="col md">
                        <!-- Last Name -->
                        <div class="form-field">
                            <label class="form-label" for="lastname">Last Name</label>
                            <input class="form-control" type="text" id="lastname" name="lastname" required>
                        </div>
                        <!-- Telephone -->
                        <div class="form-field">
                            <label class="form-label" for="telephone">Telephone</label>
                            <input class="form-control" type="text" id="telephone" name="telephone" minlength="10" maxlength="10" required>
                        </div>
                        <!-- Type -->
                        <div class="form-field">
                            <label class="form-label" for="type">Type</label>
                            <select class="form-select" id="type" name="type" required>
                                <option value="Sales Lead">Sales Lead</option>
                                <option value="Support">Support</option>
                            </select>
                        </div>
                        <!-- Save Button -->
                        <div class="form-field">
                            <br>
                            <button class="btn btn-primary float-end" class="save-button" name="add-contact">Save</button>
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
            url: 'add-contact.php', 
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