<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php $this->load->view("layout/head"); ?> 
	<script src="<?php echo base_url('assets/data-table/js/data-table-o.js')?>"></script>
	<script src="<?php echo base_url('assets/data-table/js/dataTables.bootstrap.js')?>"></script>
	<link rel="stylesheet" href="<?php echo base_url('assets/data-table/css/jquery.dataTables.css')?>"/>
	<link rel="stylesheet" href="<?php echo base_url('assets/data-table/css/dataTables.bootstrap.css')?>"/>
	<link rel="stylesheet" href="<?php echo base_url('assets/data-table/css/andre_dataTable.css')?>"/>

	<script type="text/javascript">
		$("document").ready(function(){
			$('#table').DataTable({
				//order: [[ 2, "asc" ]],
				paging: true,
        		select: true
			});

			$("#table > tbody > tr").hover(function(){
				$(this).css("cursor","pointer");
			});

		});
	</script>
	<title><?=$main['name']?></title>
</head>
<body>
	<div class="container"> 		
	<?php $this->load->view("usuario/insert"); ?>
	<?php $this->load->view("layout/nav_bar"); ?>

	<div class="row">
		<div class="col-sm-12">			
			<h1 class="page-header"><i class="<?=$main['icon']?>"></i> <?=$main['name']?>
				<button class="btn btn-default pull-right" type="button" data-target="#modal_add" data-toggle="modal">Adicionar Usuário</button>
			</h1>
		</div>
	</div>

	<div class="row">
		
		<div class="col-sm-12">

			<!-- LAYOUT DE MENSAGENS -->
			<?php $this->load->view("layout/message"); ?>
		
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading"></div>
						<div class="panel-body">
					<?php if(count($usuarios) > 0 ): ?>				
					
							<table class="table table-hover" id="table">
								<thead>
									<tr>
										<th>Cód.</th>
										<th>Nome</th>
										<th>Email</th>
										<th>Ativo</th>
										<th>Perfil</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach ($usuarios as $value): ?>
										<tr onclick="javascript:window.location.href = '<?=base_url('usuario/usuario/'.$value['idusuario'])?>'" class="<?= $value['ativo']?'':'danger'?>">
											<td><?= $value['idusuario']?></td>
											<td><?= ucwords($value['nome'])?></td>
											<td><?= $value['email']?></td>
											<td><?= $value['ativo']?"Sim":"Não"?></td>
											<td><?= $value['nome_perfil']?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>						
							</table>
						
					<?php else: ?>
						<div class="jumbotron">
						  <h1>Não há usuários!</h1>
						  <p>Para adicionar um clique no botão abaixo.</p>
						  <p><a class="btn btn-primary btn-lg" href="<?= base_url('ads/insert') ?>" role="button">Adicionar Usuário</a></p>
						</div>
					<?php endif; ?>
					</div>
					<div class="panel-footer"></div>
					</div>
				</div>
			</div>

		</div>

	</div>

	<?php $this->load->view("layout/rodape"); ?>

</div>    
</body>
</html>