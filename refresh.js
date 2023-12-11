document.addEventListener('DOMContentLoaded',function(){
    var addUserButton = document.getElementById('addUser');
  
    addUserButton.addEventListener('click',function(){
       window.location.href = 'new-user.php';
    });
  });
  
  function makeRequest(url,method,callback){
     var xhr = new XMLHttpRequest();
     xhr.onreadystatechange = function(){
         if (xhr.readyState === 4 ){
             if (xhr===200){
                callback(xhr.responseText)
              }else{
                console.error('Error loading users. Status:',xhr.status);
             }
          }
        };
        xhr.open(method,url,true);
        xhr.send();
  }
  
  function handleRequest(response){
      var resultDiv = document.getElementById('result');
      resultDiv.innerHTML = response;
  }
  
  document.addEventListener('DOMContentLoaded', function(){
      makeRequest('db_functions.php',GET,handleRequest);
  });