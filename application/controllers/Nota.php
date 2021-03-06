<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nota extends CI_Controller {

  public function __construct(){  

    parent::__construct();

    // SE NÃO HOUVER SESSÃO O USUARIO É REDIRECIONADO PARA A ÁREA DE LOGIN
    if(!$this->session->has_userdata("idusuario")){
      redirect("auth/entrar");
    } 

    $this->load->model("Trem_Model");
    $this->load->model("Nota_Model");
    $this->load->model("Message_Model");
    
  }
     
  public function create(){
    
    $this->validar_formulario('create');

    $dados = $this->montar_dados();
    
    $this->Nota_Model->create($dados);
    
    $this->Message_Model->message('success','Nota adicionada com sucesso');
           
    $this->redireciona();
    
  }

  public function update(){
    
    $this->validar_formulario('update');

    $dados = $this->montar_dados();

    $this->Nota_Model->update($dados);
    
    $this->Message_Model->message('success','Nota editada com sucesso');
    
    $this->redireciona();
    
  }

  public function delete(){
    
    $this->validar_formulario('delete');
        
    $dados = array("idnota" => $this->input->post("idnota"));
        
    $this->Nota_Model->delete($dados);
    
    $this->Message_Model->message('success','Nota excluída com sucesso');
  
    $this->redireciona();
    
  }

  public function validar_formulario($tipo){
    
    $this->check_post();

    switch ($tipo) {
      case 'create':
        $this->form_validation->set_rules('idtrem','Trem','required');    
        $this->form_validation->set_rules('texto','Texto','required');       
        break;
      case 'update':
        $this->form_validation->set_rules('idtrem','Trem','required');    
        $this->form_validation->set_rules('idnota','Nota','required');    
        $this->form_validation->set_rules('texto','Texto','required');       
        break;
      case 'delete':
        $this->form_validation->set_rules('idtrem','Trem','required');    
        $this->form_validation->set_rules('idnota','Nota','required');    
        break;
    }

    if(!$this->form_validation->run()){

      $this->Message_Model->message('danger','Ocorreum erro na validação dos dados.<br/>'.validation_errors());

      $this->redireciona();
    }

  }

  public function trem($id){
    
    $dados = array();
    // CARREGA O TREM
    $trem = $this->Trem_Model->trem($id);
    
    if($trem){

      // CARREGA AS NOTAS
      $this->load->model("Nota_Model");
      $notas = $this->Nota_Model->notas("idtrem",$trem["idtrem"]);

      $dados = array(
        "main" => array("name" => "Trem ".$trem["prefixo_trem"],"icon" => "fa fa-train"),
        "trem" => $trem,
        "notas" => $notas,
      );
      $this->load->view('nota/trem',$dados);
    }else{
      $this->Message_Model->trem_inexistente();
    }   
    
  }

  public function montar_dados(){

    $dados = array(
      "idtrem" => $this->input->post("idtrem"),
      "texto_nota" => $this->input->post("texto"),
      "idusuario" => $this->session->userdata("idusuario"),
      "atualizado_em" => date("Y-m-d H:i:s")
    );
    
    if($this->input->post("idnota")){
      $dados["idnota"] = $this->input->post("idnota");
    }else{
      $dados["criado_em"] = date("Y-m-d H:i:s");
    }

    return $dados;
  }

  public function check_post(){

    if(!$this->input->post()){
      $this->Message_Model->message('danger','Nenhum formulário foi recebido!'); 
      $this->redireciona();
    }

  }

  public function redireciona(){

    redirect("nota/trem/".$this->input->post("idtrem"));
  }

}

