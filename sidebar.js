function dashboard(){
    document.getElementById("home-btn").addEventListener("click", function(event){
        event.preventDefault();
        window.location = "dashboard.php";
    })
}

function AddContact(){
    document.getElementById("add-contact-btn").addEventListener("click", function(event){
        event.preventDefault();
        window.location = "add-contact.php";
    })
}

function users(){
    document.getElementById("users-btn").addEventListener("click", function(event){
        event.preventDefault();
        window.location = "users.php";
    })
}

function logout(){
    document.getElementById("logout-btn").addEventListener("click", function(event){
        event.preventDefault();
        window.location = "logout.php";
    })
}

window.addEventListener("DOMContentLoaded", function(){
    dashboard();
    AddContact();
    users();
    logout();
})