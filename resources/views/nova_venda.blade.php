<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">      
    <meta name="csrf-token" content="{{ csrf_token() }}">             
    <link rel="stylesheet" href = "/css/nova_venda.css">            
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
 
    <p class="title3">Nova venda</p>

    </div>
        
    <form id = "form">        
      
    @csrf

    <input type="text" name="" id="nome" placeholder = "Nome">         
    <input type="text" name="" id="preco" placeholder = "Preço">        
    <input type="text" name="" id="custo" placeholder = "Custo">     
    <input type = "number" id = "quantidade" placeholder = "Quantidade">    

    <button type = "submit">Cadastrar</button>        

    </form>                   

    <div class="message">   

    </div>

    </div>

    </div>            
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>        
    
    <script src = "/js/jquery.mask.js"></script> 

    <script>            
    
$(document).ready(function(){        

$('#custo').mask('#.##0,00', {reverse: true});    

$('#preco').mask('#.##0,00', {reverse: true});       

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

$("#form").submit(function(event){

event.preventDefault();                      

let nome = $("#nome").val();     

let preco = $("#preco").val();    

let custo = $("#custo").val();    

let quantidade = $("#quantidade").val();         

if(nome.length === 0 || preco.length === 0 || custo.length === 0 || quantidade.length === 0){

$(".message").html("<p class='alert'>Preencha todos os campos !!!!</p>");     

}else{           

  preco = preco.replace(".","");              

  preco = preco.replace(",","."); 
  
  custo = custo.replace(".","");              

  custo = custo.replace(",",".");      

  if(preco > custo){

    $.ajax({
url: "{{ route('cadastro') }}",        
method: "POST",          
dataType: "json",     
data: {
    nome: nome,
    preco: preco,
    custo: custo,
    quantidade: quantidade
},
beforeSend: function (xhr) {
    // Adicionando o token CSRF no cabeçalho da requisição
    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
}
}).done(function(response) {    

  if(response == "sucesso"){

    $(".message").html("<p class='alert'>Cadastro feito com sucesso !!!!</p>");  

  }else{

    $(".message").html("<p class='alert'>Erro ao cadastrar !!!!</p>");      

  }


}).fail(function(xhr, status, error) {       

console.error("Erro:", error);       

});

  } else{

    $(".message").html("<p class='alert'>Preço menor que o custo !!!!</p>");  

  }

}

});           



    </script>   

</body>
</html>