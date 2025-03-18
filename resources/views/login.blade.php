<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">   
    <meta name="csrf-token" content="{{ csrf_token() }}">      
    <title>Página de login</title>          
    <link rel = "stylesheet" href = "/css/login.css">   
</head>
<body>
  <div class="content">       

  <div class="form">       

  <div class="topo">      
   
  <p class = "title">Área de login</p>    
   
  </div>        

  <form id = "form">      
    
  @csrf      
   
  <input type="email" placeholder = "E-mail" id = "email">             
  
  <input type = "password" placeholder = "Senha" id = "senha">             

  <button type = "submit" style = "cursor:pointer;">Entrar</button>       

  </form>           

  <div class="message">     
  

  </div>

  </div>

  </div>              
  
  <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>       
  
  <script src="http://jqueryvalidation.org/files/dist/jquery.validate.js"></script>    

  <script>         
  
  $("#form").submit(function(e){

  e.preventDefault();            

  let email = $("#email").val();      

  let senha = $("#senha").val();            

  if(email.length === 0 || senha.length === 0){

  $(".message").html("<p class = 'aviso'>Prencha todos os campos !!!</p>");      

  }else{

     if($("#email").validate()){

      $.ajax({

        url:"{{ route('login') }}",    
        method:"POST",    
        dataType:"json",    
        data:{email:email,senha:senha},    

        beforeSend: function (xhr) {
    
        xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));      

      }


      }).done(function(response){        

        console.log(response);    
       
        if(response){
         
          window.location.href = "/inicio";               

        }else{
         
          $(".message").html("<p class = 'aviso'>E-mail ou senha inválidos !!!</p>");         
          
        }  

      });   

     }

  }

  });      
  

  </script>  

</body>
</html>
