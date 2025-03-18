<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">         
    <meta name="csrf-token" content="{{ csrf_token() }}">       
    <link rel="stylesheet" href = "/css/alterar_senha.css">            
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">        
    <script src="https://kit.fontawesome.com/b9092d7591.js" crossorigin="anonymous"></script>       
    <title>Nova venda</title>
</head>
<body>      

    <div class="sidebar">           
        
    <div class="topo">
    
    <span class = "icon">      
     
    <i class="fa-solid fa-store" style = "font-size:40px;"></i>    

    </span>    

    </div>

      <ul>           
        <li><a href = "/inicio"><span class = "icon"><i class="fa-solid fa-house"></i></span><span class = "title">Início</span></a></li>        
        <li><a href = "/nova_venda"><span class = "icon"><i class='fas fa-handshake'></i></span><span class = "title">Nova venda</span></a></li>     
        <li><a href = "/alterar_senha"><span class = "icon"><i class='fas fa-key'></i></span><span class = "title">Alterar senha</span></a></li>      
        <li><a href = "{{ route('sair') }}"><span class = "icon"> <i class="fa fa-sign-out" aria-hidden="true"></i>  </span><span class = "title">Sair</span></a></li>     
     </ul>

    </div>      

    <div class="main">     
    
    <div class="topbar">     

    <i class="fa-solid fa-bars" id = "icone"></i>   
    
    
    <i class="fa fa-user" id = "icone"></i>          

    </div>      

    <div class="content">            
        
    <div class="form">           

    <div class="txt">     
 
    <p class="title3">Alterar senha</p>

    </div>
        
    <form id = "form">        

    <input type="email" name="" id="email" placeholder = "E-mail">         

    <input type="password" name="" id = "senha" placeholder = "Senha atual"> 

    <input type="password" name="" id = "senha2" placeholder = "Nova senha"> 
                        
    <button type = "submit" style = "cursor:pointer;">Atualizar senha</button>               

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

  let senha2 = $("#senha2").val();         

  if(email.length === 0 || senha.length === 0 || senha2.length === 0){

  $(".message").html("<p class='alert'>Preencha todos os campos !!!!</p>");      

  }else{

   if($("#email").validate()){

   $.ajax({

   url:"{{ route('update_senha') }}",   
   method:"POST",    
   dataType:"json",   
   data:{email:email,senha:senha,senha2:senha2},      

   beforeSend: function (xhr) {
    
   xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));      

  }

   }).done(function(response){        

    if(response){

      $(".message").html("<p class='alert'>Senha atualizada com sucesso !!!</p>");  

    }else{

      $(".message").html("<p class='alert'>Erro ao atualizar !!!</p>");     

    }

   });     

   }

  }

  });          

  $(document).ready(function(){

    let email = "verificar";    

$.ajax({       

url:"{{ route('verificar') }}",   
method:"POST",      
dataType:"json",       
data:{email:email},

beforeSend: function (xhr) {

xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));  

}

}).done(function(response){

 if(!response){
  
 window.location.href = "http://127.0.0.1:8000/";     

 }

});           

  });     

  </script>       

</body>
</html>