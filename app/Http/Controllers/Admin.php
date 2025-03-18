<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;   

use Illuminate\Support\Facades\DB;          

class Admin extends Controller    

{
    public function login(Request $form){        

        header("Content-Type: application/json");               
        
        $dados = $form->all();          

        $email = $dados["email"];         

        $senha = $dados["senha"];        

        if(DB::table('usuario')->where('email', $email)->count() > 0) {

         $response = DB::table('usuario')->where('email', $email)->first();  

        $hash = $response->senha;                
         
         if(password_verify($senha,$hash)){    

            session_start();   

            $_SESSION["email"] = $email;     
         
            return json_encode(true);     

         }else{

        return json_encode(false); 

         }   
        
        }else{

       return json_encode(false);     

        }

        

    }       

    public function update_senha(Request $form){

        header("Content-Type: application/json");            

        $dados = $form->all();          

        $email = $dados["email"];         

        $senha = $dados["senha"];        
        
        $senha2 = $dados["senha2"];      

        if(DB::table('usuario')->where('email', $email)->count() != 0){
         
          $response = DB::table('usuario')->where('email', $email)->first();     

          $hash = $response->senha;      

            if(password_verify($senha,$hash)){            
             
               $senha2 = password_hash($senha2, PASSWORD_DEFAULT);  
               
               if(DB::table('usuario')->where('email', $email)->update(['senha' => $senha2])){      
                
                return json_encode(true);          
                  
               }else{
  
                return json_encode(false);         
   
               }
       
            }else{   

                return json_encode(false);   
            }    

        }else{

        return json_encode(false);         

        }

    }       

    public function verificar(Request $dado){
     
     header("Content-Type: application/json");         
     
     session_start();      

     if(isset($_SESSION["email"])){

     return json_encode(true);      

     }else{

     return json_encode(false);   

     }

    }      

    public function sair(){

    session_start();      

    unset($_SESSION["email"]);          

    return view("login");    

    }
}
