<?php

use Illuminate\Support\Facades\Route;        

use App\Http\Controllers\Vendas;      

use App\Http\Controllers\Admin;            

Route::get("/",[Vendas::class,"login"]);  

Route::get("/login2",function(){ return view("login"); })->name("login2");

Route::get("/inicio",[Vendas::class,"inicio"]);         

Route::post("/inicio2",[Vendas::class,"cadastrar"])->name("cadastro");         

Route::get("/alterar_senha",[Vendas::class,"alterar_senha"]);        

Route::get("/nova_venda",[Vendas::class,"nova_venda"]);    

Route::get("/alterar_venda/{id}",[Vendas::class,"alterar_venda"]);         

Route::post("/lista",[Vendas::class,"listar"])->name("listando");          

Route::post("/excluir",[Vendas::class,"excluir"])->name("excluir");      

Route::post("/limpar",[Vendas::class,"limpar"])->name("limpar");      

Route::post("/editar",[Vendas::class,"editar"])->name("editar");       

Route::post("/consulta",[Vendas::class,"consulta"])->name("consulta");        

Route::post("/login",[Admin::class,"login"])->name("login");            

Route::post("/update_senha",[Admin::class,"update_senha"])->name("update_senha");        

Route::post("/verificar",[Admin::class,"verificar"])->name("verificar");          

Route::get("/sair",[Admin::class,"sair"])->name("sair");   

?>     

  
