<?php
session_start();
include_once 'layout.php';
?>
<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" type="text/css" href="dboard.css">
<?=page_header("View Contact Details")?>


<!-- Content for Page Here -->
<div class="col py-3 pt-4 page-content">
    <!-- insert here -->
    <div class="container">
        <!-- contact header info -->
        <?php
        $item_id = $_GET['contact_id'];
        $contact = getContactById($item_id);
        $created_by = getUserById($contact['assigned_to']); 
        ?>
        <div class = "d-flex">
            <div class="flex-shrink-0">
            <i class="fa-solid fa-circle-user" style="font-size:50px; color:gray;"></i>
            </div>
            <div class="flex-grow-1 ms-3">
                <h2 class="text-start fw-bold mb-0">
                    <?php echo "" . $contact['title'] . ". " . $contact['firstname'] . " " . $contact['lastname']?>
                </h2>
                <p class="text-start text-body-secondary lh-sm">

                    <?php
                        $creation_date = date_create($contact['created_at']);
                        $update_date = date_create($contact['updated_at']);
                        echo "Created on " . date_format($creation_date,'F d, Y') . " by " . $created_by['firstname'] . " " . $created_by['lastname']
                    ?>

                    <br>
                    <?php echo "Updated on " . date_format($update_date, 'F d, Y')?>
                </p>
            </div>
            <div>
                <?php
                    if (isset($_POST['switch-type'])) {
                        $result = switchType($contact['id']);
                        if ($result['success']) {
                            echo "<div class='alert alert-success'>$result[message]</div>";
                        } else {
                            echo "<div class='alert alert-danger'>$result[message]</div>";
                        }
        
                        $_POST = array();
                    }
                ?>
                
                    <button type="button" class="btn self-assign" name="self-assign"><i class="fa-solid fa-hand"></i> Assign to me</button>
                    <button type="button" class="btn switch-type" name="switch-type">
                        <i class='fas fa-exchange-alt fa-lg'> </i>
                        <?php
                            echo "Switch to ";
                            switchTypeTxt($contact['id']);
                        ?>
                    </button>

            </div>
        </div>

        <!-- details card -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md">
                        <h6 class="card-title text-secondary fw-semibold">Email</h6>
                        <p class="card-text">
                            <?php echo $contact['email']?>
                        </p>
                        <h6 class="card-title text-secondary fw-semibold">Company</h6>
                        <p class="card-text">
                        <?php echo $contact['company']?>
                        </p>
                    </div>
                    <div class="col-md">
                        <h6 class="card-title text-secondary fw-semibold">Telephone</h6>
                        <p class="card-text">
                        <?php echo $contact['telephone']?>
                        </p>
                        <h6 class="card-title text-secondary fw-semibold">Assigned To</h6>
                        <p class="card-text">
                        <?php
                            $assigned = getUserById($contact['assigned_to']);
                            echo $assigned['firstname'] . " " . $assigned['lastname']?>
                        </p>
                    </div>
                </div>
            </div>    
        </div>

        <!-- PHP goes here -->
        <?php
            if (isset($_POST['add-note'])) {
                $notes = $_POST['notes'];
                $contact_id = $contact['id'];
                $current_user = $_SESSION['user']['id'];

                $result = addNote($contact_id, $notes, $current_user);
                
                if ($result['success']) {
                    echo "<div class='alert alert-success'>$result[message]</div>";
                } else {
                    echo "<div class='alert alert-danger'>$result[message]</div>";
                }

                $_POST = array();
            }
        ?>

        <div class="card mb-3">
            <div class="card-header bg-white">
                <img src="pen-to-square.svg">
                Notes
            </div>
            <div class="card-body">
                <!-- Notes -->
                <?php
                    $contact_id = $contact['id'];
                    generateNotesList($contact_id);
                ?>

            </div>
            <div class="card-footer border-top-0">
                <form id="notes-form" action="<?="http://localhost/info2180-project-2/contact-details.php?contact_id=" . $contact['id']?>" method="post" novalidate>
                    <div class="form-field">
                        <label class="form-label fw-semibold" for="notes"><?php echo "Add a note about " . $contact['firstname']?></label>
                        <textarea class="form-control" id="notes" name="notes" rows="4"></textarea>
                    </div>
                    <!-- Save Button -->
                    <div class="form-field">
                            <br>
                            <button class="btn btn-primary float-end" class="save-button" name="add-note">Add Note</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="details.js"></script>
<?=page_footer()?>


</html>             </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?=page_footer()?>


</html>