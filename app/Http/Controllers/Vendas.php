<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;           

use Illuminate\Support\Facades\DB;     

class Vendas extends Controller      

{
          
public function login(){         

return view("login");    

}      

public function inicio(){            

$resultados = DB::table('venda')->get();        

return view("inicio",["resultados" => $resultados]);           

}       

public function inicio2($nome){         
    
    $pesquisa = "%".$nome."%";       

    $resultados = DB::table('venda')->where('nome', 'like', $pesquisa)->get();        
    
    return view("inicio",["resultados" => $resultados]);              
    
}       

public function alterar_senha(){

return view("alterar_senha");    

}         

public function nova_venda(){

return view("nova_venda");        

}     

public function alterar_venda(){

return view("alterar_venda");   

}        

public function cadastrar(Request $dados){         

$vetor = $dados->all();          

$nome = $vetor["nome"];      

$preco = $vetor["preco"];       

$custo = $vetor["custo"];          

$quantidade = $vetor["quantidade"];     

header("Content-Type: application/json");       

if(DB::table('venda')->insert(['nome' => $nome,'preco' => $preco,'custo' => $custo,'quantidade' => $quantidade])){

return json_encode("sucesso");     

}else{

return json_encode("erro");        

}


}      

 public function listar(Request $pesquisa){           
    
    header("Content-Type: application/json");        

    $dados = $pesquisa->all();           

    $pesquisa = $dados["nome"];           

    $string = "%".$pesquisa."%";  
    
    header("Content-Type: application/json");               

    $resultados = DB::table('venda')->where('nome', 'like', $string)->get();
    
    $vetor["html"] = "";           
    
    $total_preco = 0;    

    $total_custo = 0;     
    
    foreach($resultados as $response){   

    $preco = number_format($response->preco,2,",",".");       
        
    $custo = number_format($response->custo,2,",",".");            
    
    $quantidade = $response->quantidade;         
        
    $total_preco += $quantidade * ($response->preco);      

    $total_custo += $quantidade * ($response->custo);      
    
    $id = $response->id;      

    $vetor["html"] .= "<tr>
    <td>$response->nome</td>         
    <td>$response->quantidade</td>    
    <td>$preco</td>                     
    <td>$custo</td>         
    <td><i class='fas fa-edit' style = 'font-size:20px; cursor:pointer;' data-id = '$id' id = 'editar'></i></td>     
    <td><i class='fas fa-trash' style = 'font-size:20px; cursor:pointer;' data-id = '$id' id = 'excluir'></i></td>      
    </tr>";   

    }          
    
    $vetor["lucro"] = number_format($total_preco - $total_custo,"2",",",".");                
    
    return json_encode($vetor); 
    
    

 }       
 
 public function excluir(Request $dado){

 header("Content-Type: application/json");            

 $dado = $dado->all();          
 
 $id = $dado["id"];        

 if(DB::table('venda')->where('id', '=', $id)->delete()){

 return json_encode(true);   

 }else{

return json_encode(false);   

 }


 }       

 public function limpar(Request $excluir){

 header("Content-Type: application/json");          
 
 if(DB::table('venda')->delete()){

 return json_encode(true);    

 }else{

return json_encode(false);    

 }


 }      

 public function editar(Request $dados){       
  
 session_start();    

 header("Content-Type: application/json");   

 $form = $dados->all();         
 
 $id = $_SESSION["id"];             

 $nome = $form["nome"];          

 $preco = $form["preco"];        

 $custo = $form["custo"]; 
 
 $quantidade = $form["quantidade"];           

 $cont = 0;      

 $sucesso = 0;     
 
if(!empty($preco) && !empty($custo)){             

    $cont++;  

if($preco > $custo){

    if(DB::table('venda')->where('id', $id)->update(['preco' => $preco])){
     
        if(DB::table('venda')->where('id', $id)->update(['custo' => $custo])){       

        $sucesso++;    

        }else{

          return json_encode("erro_sql2");             
               
        }

    }else{

        return json_encode("erro_sql");      
  
    }

 } else{

return json_encode("erro1");    

}



 } else{

 if(!empty($preco)){               

    $cont++;        

    if($retorno = DB::table('venda')->where('id', '=', $id)->first()){     
    
    $custo_atual = $retorno->custo;                   

    if($preco > $custo_atual){

        if(DB::table('venda')->where('id', $id)->update(['preco' => $preco])){

        $sucesso++;         

        }else{

        return json_encode("erro_sql3"); 

        }

    }else{

    return json_encode("erro2");   

    }          

  }else{

    return json_encode("erro_sql3");    

  }   

 }     

 if(!empty($custo)){
    
    $cont++;       

    if($retorno = DB::table('venda')->where('id', '=', $id)->first()){        
    
    $preco_atual = $retorno->preco;                  

    if($preco_atual > $custo){

        if(DB::table('venda')->where('id', $id)->update(['custo' => $custo])){

        $sucesso++;    

        }else{

        return json_encode("erro_sql4"); 

        }

    }else{

    return json_encode("erro5");   

    }          

  }else{

    return json_encode("erro_sql3");    

  }   
 

 }              
 
}
 
 if(!empty($quantidade)){             

    $cont++;     
   
    if(DB::table('venda')->where('id', $id)->update(['quantidade' => $quantidade])){ 
        
    $sucesso++;    

    }else{

    return json_encode("erro_sql7");   

    }

 }       

 if(!empty($nome)){           

    $cont++;     
   
    if(DB::table('venda')->where('id', $id)->update(['nome' => $nome])){ 
        
    $sucesso++;    

    }else{

    return json_encode("erro_sql8");   

    }

    

 } 

  if($sucesso == $cont){
  
  return json_encode("sucesso");     

  }else{

  return json_encode("erro");    

  }

 }       

 public function consulta(Request $form){       

 session_start();        
 
 header("Content-Type: application/json"); 
 

 $dados = $form->all();        
 
 $_SESSION["id"] = $dados["id"];     
 
 $id = $dados["id"];     

 $retorno = DB::table('venda')->where('id', $id)->get();                          
    

 $vetor = [
   
"nome" => $retorno[0]->nome,      
"preco" => number_format($retorno[0]->preco,"2",",","."),       
"custo" => number_format($retorno[0]->custo,"2",",","."),      
"quantidade" => $retorno[0]->quantidade     

 ];       
 
 return json_encode($vetor);    


 }




}      

?>        
