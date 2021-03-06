<!-- INCLUI A MODAL DE ADICIONAR O TREM -->
<?php if($this->session->userdata('idperfil')!=3):?>
  <?php $this->load->view("trem/insert"); ?>
<?php endif; ?>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>      
      <ul class="nav navbar-nav navbar-left">
        <li class="dropdown">
          <a href="#" class="navbar-brand" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-industry"></i>  
            <?php if($this->session->has_userdata("idterminal")):?>
              Você está na <?= $this->session->userdata("nome_terminal")?>
            <?php else:?>
              Terminais  
            <?php endif;?>
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">           
            <?php foreach($this->session->userdata("terminais") as $value):?>
              <li <?= $this->session->userdata("idterminal") == $value["idterminal"]?"class='active'":"" ?> ><a href="<?=base_url('home/terminal/'.$value['idterminal'])?>"><i class="fa fa-industry"></i> <?=$value['nome_terminal']?></a></li>
            <?php endforeach;?>            
          </ul>
        </li>
      </ul>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">      
      <?php if($this->session->has_userdata("idterminal")):?>
        <ul class="nav navbar-nav navbar-left">
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-train"></i> Trens <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <?php if($this->session->userdata('idperfil')!=3):?>
              <li><a href="#" data-target="#modal_add_trem" data-toggle="modal" role="button"><i class="fa fa-plus"></i> Adicionar Trem</a></li>
            <li class="divider"></li>
            <?php endif; ?>
            <li><a href="<?= base_url('trens/em_transito')?>"><i class="fa fa-road"></i> Em Trânsito</a></li>
            <li><a href="<?= base_url('trens/em_operacao')?>"><i class="fa fa-square-o"></i> Em operação</a></li>
            <li><a href="<?= base_url('trens/operados')?>"><i class="fa fa-check-square-o"></i> Operados</a></li>
          </ul>
        </li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-truck"></i> Rodoviário <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="#"><i class="fa fa-road"></i> Opção 1</a></li>
          </ul>
        </li>
        <?php if($this->session->userdata('ver_relatorios') == "sim"):?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-bar-chart"></i> Relatórios <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="<?= base_url('relatorios/rel_01')?>"><i class="fa fa-bar-chart"></i> Painel Operações</a></li>
              <li><a href="<?= base_url('relatorios/rel_02')?>"><i class="fa fa-bar-chart"></i> Painel Trens</a></li>
              <li><a href="<?= base_url('relatorios/rel_03')?>"><i class="fa fa-bar-chart"></i> Painel Prev. Chegadas</a></li>
            </ul>
          </li>
        <?php endif;?>
        </ul>
      <?php endif; ?>



      <!-- NAVBAR RIGHT -->
      <ul class="nav navbar-nav navbar-right">
        <?php if($this->session->userdata('idperfil')==1):?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-wrench"></i> Configurações <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="<?= base_url('usuario/')?>"><i class="fa fa-wrench"></i> Usuários</a></li>
              <li><a href="<?= base_url('terminal/')?>"><i class="fa fa-industry"></i> Terminais</a></li>
              <li><a href="<?= base_url('tipoparada/')?>"><i class="fa fa-hand-paper-o"></i> Tipos de Paradas</a></li>
            </ul>
          </li>                                    
        <?php endif; ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> <?=ucwords($this->session->userdata("nome"))?> <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="<?= base_url('auth/logout')?>"><i class="fa fa-sign-out"></i> Sair</a></li>
          </ul>
        </li>        
      </ul>

    </div><!-- /.navbar-collapse -->

  </div><!-- /.container-fluid -->
</nav>