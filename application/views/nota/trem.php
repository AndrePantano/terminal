<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <?php $this->load->view("layout/head"); ?>  
  <title><?=$main['name']?></title>
  <script type="text/javascript">
    $(document).ready(function(){
            
      $("tr").click(function(){
        var id = $(this).data("id");
        $(".idnota").val(id);
        $("#edit_texto_nota").val($(".texto_nota"+id).text());
        $("#del_texto_nota").text($(".texto_nota"+id).text());
        $("#modal_edit_nota").modal({show:true});
      });

      $("#btn-excluir").click(function(){
        $("#modal_edit_nota").modal().hide();       
        $("#modal_del_nota").modal({
          show:true,
          backdrop:'static'
        });
      });

      $(".close-del").click(function(){
        $("#modal_edit_nota").modal().show();
      });

    });
  </script>
</head>
<body>
  <div class="container">
    <?php if($this->session->userdata('idperfil')!=3):?>
      <?php $this->load->view("nota/insert"); ?>
      <?php $this->load->view("nota/edit"); ?>
      <?php if($this->session->userdata('idperfil')==1){ $this->load->view("nota/delete"); }?>
    <?php endif; ?>
    <?php $this->load->view("layout/nav_bar"); ?>
    <?php $this->load->view("layout/page_header"); ?>
    <?php $this->load->view("layout/message"); ?>
    <?php $this->load->view("layout/nav_tab"); ?>


    <!-- CABECALHO -->
    <div class="row">
      <div class="col-sm-12">
        <h3>
          <i class="fa fa-info-circle"></i> Notas de Atividades
          <?php if($this->session->userdata('idperfil')!=3):?>
            <button type="button" data-toggle="modal" data-target="#modal_add_nota" class="btn btn-default btn-sm pull-right" role="button">Adicionar</button>
          <?php endif; ?>
        </h3>     
      </div>
    </div>

    <!-- PANEL -->
    <div class="row">
      <div class="col-sm-12">
            
          <div class="panel panel-default">
            <div class="panel-heading"></div>
            <div class="panel-body">
                
                <?php if($notas && count($notas) > 0):?>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th width="150px">Data</th>
                          <th>Atividade</th>
                          <?php if($this->session->userdata('idperfil')==1):?>
                            <th>Alterado por:</th>
                          <?php endif; ?>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach ($notas as $nota): ?>
                          <tr data-id="<?=$nota['idnota']?>">
                            <td><?= date("d/m H:i",strtotime($nota['atualizado_em']))?></td>
                            <td class="texto_nota<?=$nota['idnota']?>"><?= $nota['texto_nota']?></td>
                            <?php if($this->session->userdata('idperfil')==1):?>
                               <td width="120px"><?= ucwords($nota["nome"])?></td>
                            <?php endif; ?>
                          </tr>
                        <?php endforeach;?> 
                      </tbody>            
                    </table>
                  </div>
                <?php else: ?>
                  <p>Não há notas lançadas</p>
                <?php endif; ?>
              
            </div>
            <div class="panel-footer"></div>
          </div>

      </div>
    </div>
    
    <?php $this->load->view("layout/rodape"); ?>

  </div>   
</body>
</html>

