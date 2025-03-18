<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">   
    <meta name="csrf-token" content="{{ csrf_token() }}">                   
    <link rel="stylesheet" href = "/css/alterar_venda.css">            
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">        
    <script src="https://kit.fontawesome.com/b9092d7591.js" crossorigin="anonymous"></script>       
    <title>Nova venda</title>
</head>

<body>             

<?php     

session_start();       

?>      

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
 
    <p class="title3">Alterar venda</p>

    </div>
        
    <form id = "form">          

    @csrf

    <input type="text" name="" id="nome" placeholder = "Nome">         
    <input type="text" name="" id="preco" placeholder = "Preço">        
    <input type="text" name="" id="custo" placeholder = "Custo">     
    <input type = "number" id = "quantidade" placeholder = "Quantidade" min = "1">                      
    <button type = "submit">Atualizar</button>                 

    </form>                   

    <div class="message">     

    </div>

    </div>

    </div>                
    
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>          

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

    function consulta(){
    
    let conteudo = window.location.pathname;     
    
    let vetor = [];         

    vetor = conteudo.split("/");      

    let id =  vetor[2];          

    $.ajax({
    
    url:"{{ route('consulta') }}",   
    method:"POST",       
    dataType:"json",      
    data:{id:id},       
    beforeSend: function (xhr) {
    
    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));  

    }


    }).done(function(response){

    $("#nome").attr("placeholder","Nome : "+response["nome"]);       

    $("#preco").attr("placeholder","Preço : "+response["preco"]);            

    $("#custo").attr("placeholder","Custo : "+response["custo"]);      
    
    $("#quantidade").attr("placeholder","Quantidade : "+response["quantidade"]);         

    })

    }       

    setInterval(consulta, 1000);    

    $("#form").submit(function(event){
    
    event.preventDefault();       

    let nome = $("#nome").val();        

    let preco = $("#preco").val();      

    let custo = $("#custo").val();       

    let quantidade = $("#quantidade").val();  
    
    preco = preco.replace(".","");              

    preco = preco.replace(",","."); 
  
    custo = custo.replace(".","");              

    custo = custo.replace(",",".");  

    if(nome.length === 0 && preco.length === 0 && custo.length === 0 && quantidade.length === 0){

    $(".message").html("<p class='alert'>Realize alguma alteração !!!!</p>");             

    }else{

      $.ajax({

      url:"{{ route('editar') }}",   
      method:"POST",      
      dataType: "json",       
      data:{nome:nome,preco:preco,custo:custo,quantidade:quantidade},

      beforeSend: function (xhr) {
    
      xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));      

    }

      }).done(function(response){          

        console.log(response);   
      
      if(response == "sucesso"){

        $(".message").html("<p class='alert'>Atualização realizada !!!!</p>");     

      }else{

      if(response == "erro1"){

        $(".message").html("<p class='alert'> O preço não é superior ao custo !!!! </p> "); 

      } else{

        if(response == "erro2"){

          $(".message").html("<p class='alert'> O preço não é superior ao custo !!!! </p>"); 

        } else{

         if(response == "erro"){

          $(".message").html("<p class='alert'> Erro de atualização !!!! </p>"); 

         }else{

           if(response == "erro5"){

            $(".message").html("<p class='alert'> O preço atual é menor que o custo !!!! </p>"); 

           }

         }

        }

      }

      }

      });       

    }


    });     

    </script>     

</body>
</html>