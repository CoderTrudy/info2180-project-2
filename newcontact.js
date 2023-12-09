window.onload = function(){

    let firstname = document.getElementById("firstname");
    let lastname = document.getElementById("lastname");
    let email = document.getElementById("email");
    let password = document.getElementById("password");
    let button = document.getElementById("button");

    button.addEventListener('click', function(event){
        event.preventDefault();
        var insertrequest = new XMLHttpRequest();
        var url = "http://localhost/info2180-project-2/info2180-project-2/add-contact.php?&firstname= " + firstname.value + "&lastname= " + lastname.value + "&email= " +  email.value + "&password= " +  password.value;
            if(insertrequest.readyState == XMLHttpRequest.DONE){
                if(insertrequest.status == 200){
                    alert("Contact successfully added!")
                }
                else{
                    alert("Contact cannot be added! Please try again!")
                }

            }
        
        insertrequest.open("GET",url,true);
        insertrequest.send();
        document.location.reload();
    }
    );
}

