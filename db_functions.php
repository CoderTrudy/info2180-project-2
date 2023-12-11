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
function addContact($title, $firstname, $lastname, $email, $company, $telephone, $assignedto, $type, $created_by)
{
    global $connection;

    $query = "INSERT INTO contacts (title, firstname, lastname, email, telephone, company, type, assigned_to, created_by) VALUES ('$title', '$firstname', '$lastname', '$email', '$telephone', '$company', '$type', '$assignedto', '$created_by')";
    $result = mysqli_query($connection, $query);

    if ($result) {
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
function addNote($contact_id, $comment, $created_by)
{
    global $connection;

    $query = "INSERT INTO notes (contact_id, comment, created_by) VALUES ('$contact_id', '$comment','$created_by')";
    $result = mysqli_query($connection, $query);
    $created_by_user = getUserById($created_by);

    if ($result) {
        return array(
            'success' => true,
            'message' => 'Added note from: ' . $created_by_user['firstname'] . " " . $created_by_user['lastname'] . '.'
        );
        updateTime($contact_id);
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
function getUserById($id)
{
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

function getContactsTypeSupport()
{
    global $connection;
    $query = "SELECT * FROM contacts where type ='Support'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        return $result;
    } else {
        return array();
    }
}
function getContactsTypeSalesLead()
{
    global $connection;
    $query = "SELECT * FROM contacts where type ='Sales Lead'";
    $result = mysqli_query($connection, $query);

    if ($result) {
        return $result;
    } else {
        return array();
    }
}
function getContactsTypeAssigned()
{
    global $connection;
    $id = $_SESSION["user"]['id'] ?? 0;
    $query = "SELECT * FROM contacts where assigned_to =$id";
    $result = mysqli_query($connection, $query);

    if ($result) {
        return $result;
    } else {
        return array();
    }
}

//get contact by id number
function getContactById($id)
{
    global $connection;
    $query = "SELECT * FROM contacts WHERE id = '$id'";
    $result = mysqli_query($connection, $query);
    if ($result) {
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

function formatPhone($telephone)
{

    // Pass phone number in preg_match function 
    if (
        preg_match(
            '/^\+[0-9]([0-9]{3})([0-9]{3})([0-9]{4})$/',
            $telephone, $value)
    ) {

        // Store value in format variable 
        $format = $value[1] . '-' .
            $value[2] . '-' . $value[3];
    } else {
        return $telephone;
    }
    // Print the given format 
    return $format;

}


//generate html table for contacts
function generateContactsTable()
{
    // Add the filter row above the table headings
  
    //filter function here
    $filterKey = $_GET['filter'] ?? "All";

    switch ($filterKey) {
       
        case 'Sales':
            //filter the contacts array by sales lead type
            $contacts = getContactsTypeSalesLead();
            break;
        case 'Support':
            //filter the contact array by support type
            $contacts = getContactsTypeSupport();
            break;
        case 'Assigned':
            //filter the contact array by assign id
            $contacts = getContactsTypeAssigned();
            break;
        default:
             $contacts = getContacts();
            break;


    }



    

    $table = "<table class='table table-striped table-hover'>
    <thead>
        <tr>
            <th scope='col'>Name</th>
            <th scope='col'>Email</th>
            <th scope='col'>Company</th>
            <th scope='col'>Type</th>
            <th scope ='col'>    </th>

        </tr>
    </thead>
    <tbody>";

    $count = 1;
    while ($row = mysqli_fetch_assoc($contacts)) {


        
        $fullName = $row['title'] . ". " . $row['firstname'] . " " . $row['lastname'];

        if ($row['type'] == "Sales Lead" )
            $style = "'padding:5px; color:black; text-transform:uppercase; font-weight:600; background-color:#fcd34d; border-radius:5px; white-space:nowrap;'";
        else
            $style = "'padding:5px; color:white; text-transform:uppercase; font-weight:600; background-color: #6366f1; border-radius: 5px'";

        $table .= "<tr>
        <td><b>$fullName</b></td>
        <td>" . $row['email'] . "</td>
        <td>" . $row['company'] . "</td>
        <td><span style= ". $style .">" . $row['type'] . "</span></td>
        <td> <a href= contact-details.php?contact_id=" . $row['id'] . ">View</a></td>
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
            <a href='?filter=All'><li>All</li></a>
            <a href='?filter=Sales'><li>Sales Leads</li></a>
            <a href='?filter=Support'><li>Support</li></a>
            <a href='?filter=Assigned'><li>Assigned to me</li></a>
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
function getNoteByContact($contact_id)
{
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
function generateNotesList($contact_id)
{
    $notes = getNoteByContact($contact_id);
    $note = "";
    

    while ($row = mysqli_fetch_assoc($notes)) {
        $created_by = $row['created_by'];

        $created_by_user = getUserById($created_by);

        $date = date_create($row['created_at']);

        $date = date_create($row['created_at']);

        $note .= "<div class=''>
                    <b><h8>" . $created_by_user['firstname'] . " " . $created_by_user['lastname'] . "</h8></b>
                        <p>
                            " . $row['comment'] . "
                            <br>
                            " . date_format($date,'F d, Y') . " at " . date_format($date,'ga') . "
                        </p>
                
                </div>";
    }
    echo $note;
}

//return the opposite type based on contact's current type
function switchTypeTxt($contact_id) {

    $contact = getContactById($contact_id);
    $result = $contact['type'];

    switch ($result) {
        case "Sales Lead":
            echo "Support";
            break;
        case "Support":
            echo "Sales Lead";
            break;
        default:
            echo "Something is wrong.";
    }
}

//updates contact's type
function switchType($contact_id)
{
    global $connection;

        $type = switchTypeTxt($contact_id);
        $query = "UPDATE contacts SET type = '$type' WHERE id = '$contact_id'";
        $result = mysqli_query($connection, $query);

    if ($result) {
        return array(
            'success' => true,
            'message' => 'Switched to ' . $type . "."
        );
    } else {
        return array(
            'success' => false,
            'message' => 'Failed to switch to' . $type . '.'
        );
    }
}

function updateTime($contact_id) {
    global $connection;
    // 2023-12-08 18:58:13
    $newdate = date('Y-m-d H:i:s');

    $query = "UPDATE contacts SET updated_at = '$newdate' WHERE id = '$contact_id'";
    $result = mysqli_query($connection, $query);

    if($result)
        return true;
    else
        return false;
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