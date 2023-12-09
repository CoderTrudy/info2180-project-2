<!-- connect to db  -->
<?php
include_once 'config.php';

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
    $filterRow = "
    <thead>
        <tr>
            <th colspan='2'></th> <!-- Empty cells for spacing -->
            <th colspan='4' class='text-start'>
                <form class='form-inline' id='filterForm'>
                    <div class='form-group mb-2'>
                        <label for='filter' class='mr-2'> <i class='fas fa-filter'></i> Filter By: </label>
                        <label for='filterAll' class='filter-option' data-value='all'>All</label>
                        <label for='filterSalesLeads' class='filter-option' data-value='sales_leads'>Sales Leads</label>
                        <label for='filterSupport' class='filter-option' data-value='support'>Support</label>
                        <label for='filterAssignedToMe' class='filter-option' data-value='assigned_to_me'>Assigned to Me</label>
                    </div>
                </form>
            </th>
            <th colspan='2'></th> <!-- Empty cells for spacing -->
        </tr>
    </thead>
    ";

    $contacts = getContacts();

    $table = "<table class='table table-striped table-hover'>
    <thead class='thead-dark'>
        <tr>
            <th scope='col'>Name</th>
            <th scope='col'>Email</th>
            <th scope='col'>Company</th>
            <th scope='col'>Type</th>
            <th scope='col'>View</th>
        </tr>
    </thead>
    <tbody>";

    $count = 1;
    while ($row = mysqli_fetch_assoc($contacts)) {
        $fullName = $row['title'] . " " . $row['firstname'] . " " . $row['lastname'];

        $table .= "<tr>
        <th scope='row'>$count</th>
        <td>$fullName</td>
        <td>" . $row['email'] . "</td>
        <td>" . $row['company'] . "</td>
        <td>" . $row['type'] . "</td>
        <td><a href='view-contact/" . $row['id'] . "' class='btn btn-primary btn-sm'>View</a></td>
        </tr>";

        $count++;
    }

    //if no contacts
    if ($count == 1) {
        $table .= "<tr>
        <td colspan='6' class='text-center'>No contacts found.</td>
        </tr>";
    }

    echo $table;
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





