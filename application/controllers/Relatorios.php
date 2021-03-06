<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Relatorios extends CI_Controller {

  public function __construct(){  

    parent::__construct();

    // SE NÃO HOUVER SESSÃO O USUARIO É REDIRECIONADO PARA A ÁREA DE LOGIN
    $this->load->model("Relatorio_Model");
    $this->load->model("Message_Model");

    if(!$this->session->has_userdata("idusuario")){
      redirect("auth/entrar");
    }    
    
    if($this->session->userdata("ver_relatorios") != "sim" ){
      $this->Message_Model->message("danger","Você não tem permissão para acessar a página requisitada!");
      redirect("/");
    }

  }
     
  // RELATÓRIO DE OPERAÇÕES
  public function rel_01(){

    $relatorio = array();
    
    $inicio = date("Y-m-")."01";
    $fim = date("Y-m-d");

    if($this->input->post("inicio") && $this->input->post("fim")){
      $inicio =  $this->input->post("inicio");
      $fim = $this->input->post("fim");
    }

    // VERIFICA SE A DATA INICIO É MAIOR QUE A DATA FIM;
    if(strtotime($inicio) > strtotime($fim)){
      $this->Message_Model->message("danger","A data início do período não pode ser maior que a data término!");
    }else{
      // REALIZA DA PESQUISA
      $relatorio = $this->Relatorio_Model->rel_01($inicio,$fim);
    }

    $dados = array(
      "main" => array(
      	"name" => "Rel. Painel Operações",
      	"icon" => "fa fa-bar-chart"
      ),
      "titulo" => "Rel. Painel Operações",
      "relatorio" => $relatorio,
      "tipo_relatorio" => "rel_01",
      "inicio" => $inicio,
      "fim" => $fim
    );

    $this->load->view("relatorios/rel_01",$dados);
  }

  // RELATÓRIO DE TRENS
  public function rel_02(){

    $relatorio = array();
    
    $inicio = date("Y-m-")."01";
    $fim = date("Y-m-d");

    if($this->input->post("inicio") && $this->input->post("fim")){
      $inicio =  $this->input->post("inicio");
      $fim = $this->input->post("fim");
    }

    // VERIFICA SE A DATA INICIO É MAIOR QUE A DATA FIM;
    if(strtotime($inicio) > strtotime($fim)){
      $this->Message_Model->message("danger","A data início do período não pode ser maior que a data término!");
    }else{
      // REALIZA DA PESQUISA
      $relatorio = $this->Relatorio_Model->rel_02($inicio,$fim);
    }

    $dados = array(
      "main" => array(
        "name" => "Rel. Painel Trens",
        "icon" => "fa fa-bar-chart"
      ),
      "titulo" => "Rel. Painel Trens",
      "relatorio" => $relatorio,
      "tipo_relatorio" => "rel_02",
      "inicio" => $inicio,
      "fim" => $fim
    );

    $this->load->view("relatorios/rel_02",$dados);
  }

  // RELATÓRIO DE TRENS
  public function rel_03(){

    $relatorio = array();
    
    $inicio = date("Y-m-")."01";
    $fim = date("Y-m-d");

    if($this->input->post("inicio") && $this->input->post("fim")){
      $inicio =  $this->input->post("inicio");
      $fim = $this->input->post("fim");
    }

    // VERIFICA SE A DATA INICIO É MAIOR QUE A DATA FIM;
    if(strtotime($inicio) > strtotime($fim)){
      $this->Message_Model->message("danger","A data início do período não pode ser maior que a data término!");
    }else{
      // REALIZA DA PESQUISA
      $relatorio = $this->Relatorio_Model->rel_03($inicio,$fim);
    }

    $dados = array(
      "main" => array(
        "name" => "Rel. Prev. Chegadas",
        "icon" => "fa fa-bar-chart"
      ),
      "titulo" => "Rel. Prev. Chegadas",
      "relatorio" => $relatorio,
      "tipo_relatorio" => "rel_03",
      "inicio" => $inicio,
      "fim" => $fim
    );

    $this->load->view("relatorios/rel_03",$dados);
  }
}