<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">   
    <meta name="csrf-token" content="{{ csrf_token() }}">              
    <link rel="stylesheet" href = "/css/inicio.css">       
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">        
    <script src="https://kit.fontawesome.com/b9092d7591.js" crossorigin="anonymous"></script>       
    <title>Início</title>
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
        <li><a href = "#" id = "limpar"><span class = "icon"><i class="fa fa-trash" aria-hidden="true"></i></span><span class = "title">Limpar tudo</span></a></li>      
        <li><a href = "/alterar_senha"><span class = "icon"><i class='fas fa-key'></i></span><span class = "title">Alterar senha</span></a></li>      
        <li><a href = "{{ route('sair') }}"><span class = "icon"> <i class="fa fa-sign-out" aria-hidden="true"></i>  </span><span class = "title">Sair</span></a></li>    
     </ul>

    </div>      

    <div class="main">     
    
    <div class="topbar">     

    <i class="fa-solid fa-bars" id = "icone"></i>   
     
    
    <div class="pesquisa"><form>@csrf<input type = "text" id = "nome" placeholder = "Pesquise pelo nome"><button type = "submit"><i class="fa-solid fa-magnifying-glass"></i></button></form></div>
    
    
    <i class="fa fa-user" id = "icone"></i>          

    </div>      

    <div class="content">              

    <div class="title2">      
     
    <p>Vendas realizadas</p>

    </div>           

   <div class="table">   

    <table>                

    <thead>       
        <tr>
            <td class = "header"><p class = "atributo">Nome</p></td>        
            <td class = "header"><p class = "atributo">Quantidade</p></td>    
            <td class = "header"><p class = "atributo">Preço</p></td>        
            <td class = "header"><p class = "atributo">Custo</p></td>        
            <td class = "header"><p class = "atributo">Editar</p></td>       
            <td class = "header"><p class = "atributo">Excluir</p></td>      
        </tr>  
</thead>           

<tbody class = "corpo">         



</tbody>        

</table>    

</div>        

<div class="lucro">       
   
<p class="dinheiro"></p>             

</div>


    </div>

    </div>               
    
    <script src = "https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>       

    <script>           
    
    $(document).on("click","#excluir",function(){      

    let id = $(this).attr("data-id");      
    
    let resposta = confirm("Deseja mesmo excluir essa venda ????? ");              

    if(resposta){
    
    $.ajax({
    
    url:"{{ route('excluir') }}",        
    method:"POST",       
    dataType:"json",    
    data:{id:id},
    
    beforeSend: function (xhr) {
    
    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));  

    }    


    }).done(function(response){
      
        if(response){     

        alert("Venda excluída com sucesso !!!");       


        }else{

        alert("Erro ao excluir venda !!!");    

        }

    });    

    }

    });     
    
    $(document).on("click","#editar",function(){

    let id = $(this).attr("data-id");         
    
    window.location.href = "alterar_venda/"+id;                

    }); 
    
    function listar(){

    let nome = $("#nome").val();         

    $.ajax({       

    url:"{{ route('listando') }}",           
    method:"POST",        
    dataType:"json",            
    data:{nome:nome},

    beforeSend: function (xhr) {
    
    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));  

    }

    }).done(function(response){      

    $(".corpo").html(response["html"]);       
    
    $(".dinheiro").html("Lucro - R$ : "+response["lucro"]); 

    });      

    }      

    setInterval(listar,1000);              
    
    $(document).on("click","#limpar",function(){

    let resposta = confirm("Deseja mesmo limpar todas as vendas ???? ");          

    if(resposta){        

    let excluir = "1";    
    
    $.ajax({
    
    url:"{{ route('limpar') }}",        
    method:"POST",       
    dataType:"json",      
    data:{excluir:excluir},

    beforeSend: function (xhr) {
    
    xhr.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));  

    }

    }).done(function(response){
     
    if(response){

    alert("Limpeza realizada com sucesso !!!");     

    }else{

    alert("Erro de processamento !!!");    

    }

    });    

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