<?php
include_once 'routes.php';
include_once 'config.php';
include_once 'db_functions.php';



//page header
function page_header($title = "INFO2180 PROJECT 2")
{

    $home = base_url();
    $logout = base_url('logout');
    $add_contact = base_url('add-contact');
    $users = base_url('users');


    //render with php code inserted
    $header = <<<EOD
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title> {$title} </title> 
    <link rel="stylesheet" href="dash.css" />
    <script src="dash.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

</head>


<div class="container-fluid">
    <header>
        <div class="header-content">
            <h3>&#x1F42C; Dolphin CRM</h3>
        </div>
    </header>
    
    <div class="row flex-nowrap">
        <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-light">
            <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
               <!-- <a href="/" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-white text-decoration-none">
                    <span class="fs-5 d-none d-sm-inline">Menu</span>
                </a>
                -->
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                    <li class="nav-item">
                   
                        <a href="{$home}" class="nav-link align-middle px-0">
                            <i class="fas fa-house"></i> <span class="ms-1 d-none d-sm-inline text-dark">Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="{$add_contact}" data-bs-toggle="collapse"
                            class="nav-link px-0 align-middle">
                            <i class="far fa-user-circle"></i> <span class="ms-1 d-none d-sm-inline">New Contact</span>
                        </a>

                    </li>
                    <li>
                        <a href="{$users}" data-bs-toggle="collapse" class="nav-link px-0 align-middle"><i class="bi bi-people"></i><span class="ms-1 d-none d-sm-inline">Users</span>
                        </a>

                    </li>
                    <li>
                        <a href="{$logout}" class="nav-link px-0 align-middle">
                            <i class="fas fa-sign-out fa-rotate-180"></i> <span class="ms-1 d-none d-sm-inline">Logout</span></a>
                    </li>

                    <hr>

            </div>
        </div>

       

EOD;



    echo $header;
}

//page footer
function page_footer()
{
    $footer = <<<EOD

    

        <script src="script.js"></script>
    </div>
    
</div>

EOD;

    echo $footer;
}







