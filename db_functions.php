<!-- connect to db  -->
<?php include_once 'config.php';

// Connect to the database
$connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
// Check for errors
if ($connection === false) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

//Function to add a new user to the database
function addUser($email, $password, $firstname, $lastname, $role)
{
    global $connection;

    //unique email
    $user = getUserByEmail($email);
    if ($user) {
        return array(
            'success' => false,
            'message' => 'Email ' . $email . ' already exists. Please use a different email.'
        );
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $query = "INSERT INTO users (email, password, firstname, lastname,role) VALUES ('$email', '$hashedPassword', '$firstname', '$lastname','$role')";
    $result = mysqli_query($connection, $query);

    if ($result) {
        return array(
            'success' => true,
            'message' => 'User ' . $firstname . ' ' . $lastname . ' added successfully.'
        );
    } else {
        return array(
            'success' => false,
            'message' => 'Something went wrong. Please try again later.'
        );
    }


}

//function to add contact to database
function addContact($title, $firstname, $lastname, $email, $company, $telephone, $assignedto, $type, $created_by) {
    global $connection;

    $query = "INSERT INTO contacts (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by) VALUES ('$title', '$firstname', '$lastname', '$email', '$telephone', '$company', '$type', '$assignedto', '$created_by')";
    $result =  mysqli_query($connection, $query);

    if($result) {
        return array(
            'success' => true,
            'message' => '' . $firstname . ' ' . $lastname . ' added to ' . $assignedto . 's contact list.'
        );
    } else {
        return array(
            'success' => false,
            'message' => "Something went wrong. Try again later."
        );
    }
}

//Function to add notes to database
function addNote($contact_id, $comment, $created_by) {
    global $connection;

    $query = "INSERT INTO notes (contact_id, comment, created_by) VALUES ('$contact_id', '$comment','$created_by')";
    $result = mysqli_query($connection, $query);
    $created_by_user = getUserById($created_by);

    if($result) {
        return array(
            'success' => true,
            'message' => 'Added note to contact: ' . $created_by_user['firstname'] . " " . $created_by_user['lastname'] . '.'
        );
    } else {
        return array(
            'success' => false,
            'message' => "Unable to add note. Try again later."
        );
    }
}

//Function to log in a user
function login($email, $password)
{
    global $connection;
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $row;
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}
//removed getcurrentuser function

//get user by email
function getUserByEmail($email)
{
    global $connection;
    $query = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($connection, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row;
    } else {
        return false;
    }
}

//get user by id
function getUserById($id) {
    global $connection;
    $query = "SELECT * FROM users WHERE id = '$id'";
    $result = mysqli_query($connection, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row;
    } else {
        return false;
    }
}

//users table
function getUsers()
{
    global $connection;
    $query = "SELECT * FROM users";
    $result = mysqli_query($connection, $query);

    if ($result) {
        return $result;
    } else {
        return array();
    }
}

//contacts table
function getContacts()
{
    global $connection;
    $query = "SELECT * FROM contacts";
    $result = mysqli_query($connection, $query);

    if ($result) {
        return $result;
    } else {
        return array();
    }
}

//get contact by id number
function getContactById($id) {
    global $connection;
    $query = "SELECT * FROM contacts WHERE id = '$id'";
    $result = mysqli_query($connection, $query);
    if($result) {
        $row = mysqli_fetch_assoc($result);
        return $row;
    } else {
        return false;
    }
}

//generate html table for users
function generateUsersTable()
{
    $users = getUsers();

    $table = "<table class='table table
    -striped table-hover'>
    <thead>
    <tr>
    <th scope='col'>#</th>
    <th scope='col'>Name</th>
    <th scope='col'>Email</th>
    <th scope='col'>Role</th>
    <th scope='col'>Created At.</th>
    </tr>
    </thead>
    <tbody>";

    $count = 1;
    while ($row = mysqli_fetch_assoc($users)) {
        $table .= "<tr>
        <th scope='row'>$count</th>
        <td>" . $row['firstname'] . " " . $row['lastname'] . "</td>
        <td>" . $row['email'] . "</td>
        <td>" . $row['role'] . "</td>
        <td>" . $row['created_at'] . "</td>
        </tr>";

        $count++;

    }

    //if no users
    if ($count == 1) {
        $table .= "<tr>
        <td colspan='5' class='text-center'>No users found.</td>
        </tr>";
    }

    echo $table;
}


//generate html table for contacts
function generateContactsTable()
{
    // Add the filter row above the table headings

    $contacts = getContacts();

    $table = "<table class='table table-striped table-hover'>
    <thead>
        <tr>
            <th scope='col'>Name</th>
            <th scope='col'>Email</th>
            <th scope='col'>Company</th>
            <th scope='col'>Type</th>
            <th scope ='col'>   </th>

        </tr>
    </thead>
    <tbody>";

    $count = 1;
    while ($row = mysqli_fetch_assoc($contacts)) {
        $fullName = $row['title'] . ". " . $row['firstname'] . " " . $row['lastname'];

        $table .= "<tr>
        <td><b>$fullName</b></td>
        <td>" . $row['email'] . "</td>
        <td>" . $row['company'] . "</td>
        <td>" . $row['type'] . "</td>
        <td> <a href= details.php?contact_id=" . $row['id'] . ">View</a></td>
        </tr>";

        $count++;
    }

    //if no contacts
    if ($count == 1) {
        $table .= "<tr>
        <td colspan='6' class='text-center'>No contacts found.</td>
        </tr>";
    }
    
    $caption = "
    <div class='caption'>
        <ul class = 'list-inline'>
            <b><i class='fas fa-filter'></i> Filter By: </b>
            <li> All</li>
            <li>Sales Leads</li>
            <li>Support</li>
            <li>Assigned to me</li>
        </ul>
    </div>
    ";

    // Wrap the table in a card
    $card = "
    <div class='card'>
        <div class='card-body'>
            $caption
            $table
        </div>
    </div>
    ";

    echo $card;
}

//get notes
function getNoteByContact($contact_id) {
    global $connection;
    $query = "SELECT * FROM notes WHERE contact_id = '$contact_id'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        return $result;
    } else {
        return array();
    }
}

//generate notes list
function generateNotesList($contact_id) {
    $notes = getNoteByContact($contact_id);
    $note = "";

    while ($row = mysqli_fetch_assoc($notes)) {
        $created_by = $row['created_by'];

        $created_by_user = getUserById($created_by);

        $note .= "<div class=''>
                    <h5>" . $created_by_user['firstname'] . " " . $created_by_user['lastname']  . "</h5>
                        <p>" . $row['comment'] . "</p>
                </div>";
    }
    echo $note;
}


function switchType($contact_id) {
    global $connection;

    $query = "SELECT type FROM contacts WHERE id = '$contact_id'";
    $result = mysqli_query($connection, $query);

    if (mysqli_fetch_assoc($result) == "Sales Lead")
        $query = "UPDATE contacts SET type = 'Support' WHERE id = '$contact_id'";
    else
        $query = "UPDATE contacts SET type = 'Sales Lead' WHERE id = '$contact_id'";
    $result = mysqli_query($connection, $query);

    if($result) {
        return array(
            'success' => true,
            'message' => 'Added note to contact.'
        );
    } else {
        return array(
            'success' => false,
            'message' => "Unable to add note. Try again later."
        );
    }
}


function Filter(){

}





//close db
function close_db()
{
    global $connection;
    try {
        mysqli_close($connection);
    } catch (Exception $e) {
        echo 'Caught exception: ', $e->getMessage(), "\n";
    }
}





// Close the connection
// mysqli_close($connection);


?>





