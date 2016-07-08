<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Usuario extends CI_Controller {

  public function __construct(){  

    parent::__construct();

      $this->load->model("Usuario_Model");
      $this->load->model("Message_Model");

    // SE NÃO HOUVER SESSÃO OU O USUARIO FOR DIFERENTE DE ADMINISTRADOR
    // ELE SERÁ REDIRECIONADO PARA A ÁREA DE LOGIN
    if(!$this->session->has_userdata("idusuario") || $this->session->userdata("idperfil") != 1)
      redirect("/");
    
    
  }
     
  public function index(){
  
    // RETORNA TODOS OS DADOS CADASTRADOS
    $usuarios = $this->Usuario_Model->all();

    $dados = array(
      "main" => array("name" => "Usuários","icon" => "fa fa-users"),
      "usuarios" => $usuarios
    );

    // CARREGA A VIEW
    $this->load->view('usuario/index',$dados);
  
  }

  public function entrar(){

     return $this->load->view("auth/entrar");
  }

  public function login(){

    $this->validar_formulario("login");
    
    $dados = array(
      "email" => $this->input->post("usuario"),
      "senha" => $this->input->post("senha")
    );

    $usuarios = $this->Usuario_Model->check_login($dados);
    
    if($usuarios){
      
      $usuario = $usuarios[0];
      $usuario["padrao"] = md5("brado");

      // SE A SENHA FOR BRADO CHAMA A FUNÇÃO DE CADASTRAR NOVA SENHA
      if ($this->verificar_senha_padrao($usuario["senha"])){
        
        // TUDO CERTO, ARMAZENA DADOS NA SESSAO E VAI PARA A HOME
        $this->session->set_userdata("idusuario",$usuario["idusuario"]);
        $this->session->set_userdata("nome",$usuario["nome"]);
        $this->session->set_userdata("idperfil",$usuario["idperfil"]);
        redirect("/");

      }else{

        // CRIA O ARRAY DE DADOS
        $dados = array(
          "idusuario" => $usuario["idusuario"],
          "nome" => $usuario["nome"],
          "token" => $this->gerar_token()
        );
        // ATUALIZA O USUARIO COM O NOVO TOKEN;
        $this->Usuario_Model->update($dados);

        // ARMAZENA DADOS NA SESSION FLASH
        $this->session->set_flashdata($dados);
      
        // VAI PARA A PÁGINA DE CADASTRO DE NOVA SENHA
        redirect("auth/cadastrar_senha");
      }

    }else{
      
      $this->Message_Model->message("danger","Login ou senha inválidos!");
      $this->redireciona();
      
    }
    
  }

  public function verificar_senha_padrao($senha){
    if($senha != md5("brado"))
      return true;
    return false;
  }

  public function logout(){
    unset($_SESSION["idusuario"]);
    unset($_SESSION["nome"]);
    unset($_SESSION["perfil"]);
    $this->redireciona();
  }

  public function check_post(){
    if(!$this->input->post()){
      $this->Message_Model->message('danger','Nenhum formulário foi recebido!');
      $this->redireciona();
    }
  }

  public function validar_formulario($tipo){

    $this->check_post();

    switch ($tipo) {
      case 'login':
        $this->form_validation->set_rules('usuario','Usuário','required');    
        $this->form_validation->set_rules('senha','Senha','required|min_length[5]');   
        break;
      case 'nova_senha':
        $this->form_validation->set_rules('token','Token','required');    
        $this->form_validation->set_rules('senha','Senha','required');    
        $this->form_validation->set_rules('confirmar_senha','Confirmação da Senha','required');    
        break;
      case 'update':
        break;
      case 'delete':
        break;
    }

    if(!$this->form_validation->run()){
      $this->Message_Model->message('danger','Ocorreum erro na validação dos dados.<br/>'.validation_errors());
      $this->redireciona();
    }
  }

  public function redireciona(){

    redirect("auth/entrar");
  }

  
  public function gerar_token(){
      $token = md5(date("dmYHis"));  
      return $token;
  }
    
  public function cadastrar_senha(){
    if($this->session->flashdata("token")){
      $this->load->view("auth/cadastrar_senha");
    }else{
      redirect("/");
    }

  }

  public function nova_senha(){
    
    $this->validar_formulario("nova_senha");
    
    // VERIFICA SE AS SENHAS SÃO IGUAIS
    if($this->input->post("senha") == $this->input->post("confirmar_senha")){   
    
      // VERIFICA SE A SENHA É BRADO
      if($this->verificar_senha_padrao($this->input->post("senha"))){

        $usuarios = $this->Usuario_Model->check_token($this->input->post("token"));
        if($usuarios){
          $usuario = $usuarios[0];
          
          $dados = array(
            "idusuario" => $usuario["idusuario"],
            "token" => "",
            "senha" => md5($this->input->post("senha"))
          );
          $this->Usuario_Model->update($dados);

          $this->Message_Model->message("success","Parabéns ".ucwords($usuario["nome"])."!<br>Senha atualizada com sucesso.<br>Faça login para acessar o sistema.");
          redirect("auth/entrar");
        }else{
          $this->Message_Model->message("danger","Token inválido!");
          redirect("auth/entrar");
        }
      
      }else{
        $this->Message_Model->message("danger","Esta senha não pode ser utilizada!");
        redirect("auth/entrar");
      }

    }else{
      $this->Message_Model->message("danger","As senhas informadas não conferem!");
      redirect("auth/entrar");
    }
  }

}
