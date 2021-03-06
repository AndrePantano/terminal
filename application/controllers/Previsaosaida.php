<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Previsaosaida extends CI_Controller {

  private $main = array();

  public function __construct(){  

    parent::__construct();

    // SE NÃO HOUVER SESSÃO O USUARIO É REDIRECIONADO PARA A ÁREA DE LOGIN
    if(!$this->session->has_userdata("idusuario")){
      redirect("auth/entrar");
    }  

    $this->load->model("Previsao_Saida_Model");
    $this->load->model("Trem_Model");
    $this->load->model("Message_Model");
    
  }
  
  public function delete(){
    
    $this->validar_formulario('delete');

    $dados = array("idprevisao" => $this->input->post("idprevisao"));

    $this->Previsao_Saida_Model->delete($dados);

    $this->Message_Model->message('success','Previsão excluída com sucesso');        
           
    $this->redireciona();
    
  }

  public function update(){
    
    $this->validar_formulario('update');
    
    $dados = $this->montar_dados();
    
    $this->Previsao_Saida_Model->update($dados);

    $this->Message_Model->message('success','Previsão atualizada com sucesso');        
  
    $this->redireciona($idtrem);
    
  }

  public function montar_dados(){

    $dados = array(
      "idtrem" => $this->input->post("idtrem"),      
      "data_previsao" => $this->input->post("previsao"),
      "motivo_previsao" => $this->input->post("motivo"),
      "idusuario" => $this->session->userdata("idusuario")
    );
    
    if($this->input->post("idprevisao")){
      $dados["idprevisao"] = $this->input->post("idprevisao");
      $dados["atualizado_em"] = date("Y-m-d H:i:s");
    }else{
      $dados["criado_em"] = date("Y-m-d H:i:s");
    }

    return $dados;
  }

  public function create(){
    
    $this->validar_formulario('create');
    
    $dados = $this->montar_dados();

    $this->Previsao_Saida_Model->create($dados);

    // RETORNA A MENSAGEM
    $this->Message_Model->message('success','Previsão adicionada com sucesso');        
       
    $this->redireciona();
    
  }

  public function trem($id){
    
    $trem = $this->Trem_Model->trem($id);
    
    if($trem){

      $previsoes_saida = $this->Previsao_Saida_Model->previsoes_saida("idtrem",$trem["idtrem"]);
     
      $dados = array(
        "main" => array("name" => "Trem ".$trem["prefixo_trem"],"icon" => "fa fa-train"),
        "trem" => $trem,
        "previsoes_saida" => $previsoes_saida
      );

      $this->load->view('previsaosaida/trem',$dados);

    }else{
      $this->Message_Model->trem_inexistente();
    }

  }

  public function check_post(){
    if(!$this->input->post()){
      $this->Message_Model->message('danger','Nenhum formulário foi recebido!'); 
      $this->redireciona($idtrem);
    }
  }

  public function validar_formulario($tipo){

    // VERIFICA SE HOUVE UM POST
    $this->check_post();

    switch ($tipo) {
      case 'create':
        $this->form_validation->set_rules('idtrem','Trem','required');    
        $this->form_validation->set_rules('previsao','Previsão','required');   
        $this->form_validation->set_rules('motivo','Motivo','required');   
        break;
      case 'update':
        $this->form_validation->set_rules('idtrem','Trem','required');    
        $this->form_validation->set_rules('previsao','Previsão','required');   
        $this->form_validation->set_rules('motivo','Motivo','required'); 
        break;
      case 'delete':
        $this->form_validation->set_rules('idtrem','Trem','required');    
        $this->form_validation->set_rules('idprevisao','previsao','required'); 
        break;
    }

    if(!$this->form_validation->run()){

      $this->Message_Model->message('danger','Ocorreum erro na validação dos dados.<br/>'.validation_errors());

      $this->redireciona();
    }
  }

  public function redireciona(){
    
    redirect("previsaosaida/trem/".$this->input->post("idtrem"));
  }
}

