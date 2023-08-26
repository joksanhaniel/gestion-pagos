<?php include('db_connect.php'); ?>
<style>
	input[type=checkbox] {
		/* Double-sized Checkboxes */
		-ms-transform: scale(1.3);
		/* IE */
		-moz-transform: scale(1.3);
		/* FF */
		-webkit-transform: scale(1.3);
		/* Safari and Chrome */
		-o-transform: scale(1.3);
		/* Opera */
		transform: scale(1.3);
		padding: 10px;
		cursor: pointer;
	}
</style>

<div class="container-fluid">

	<div class="col-lg-12">
		<div class="row mb-4 mt-4">
			<div class="col-md-12">

			</div>
		</div>
		<div class="row">
			<!-- FORM Panel -->

			<!-- Table Panel -->
			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<b>Lista de Clientes </b>
						<span class="float:right"><a class="btn btn-primary col-sm-6 col-md-2 float-right" href="javascript:void(0)" id="new_clients">
								<i class="fa fa-plus"></i> Agregar
							</a></span>
					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">DNI</th>
									<th class="">Nombre</th>
									<th class="">Información</th>
									<th class="text-center">Acción</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								$clients = $conn->query("SELECT * FROM clients order by name asc ");
								while ($row = $clients->fetch_assoc()) :
								?>
									<tr>
										<td class="text-center"><?php echo $i++ ?></td>
										<td>
											<?php echo $row['id_no'] ?>
										</td>
										<td>
											<?php echo ucwords($row['name']) ?>
										</td>
										<td class="">
											<p>Correo: <?php echo $row['email'] ?></p>
											<p># Móvil: <?php echo $row['contact'] ?></p>
											<p>Dirección: <?php echo $row['address'] ?></p>
										</td>
										<td class="text-center">
											<button class="btn btn-primary edit_clients" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></button>
											<button class="btn btn-danger delete_clients" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash-alt"></i></button>
										</td>
									</tr>
								<?php endwhile; ?>
							</tbody>

						</table>
					</div>
				</div>
			</div>
			<!-- Table Panel -->
		</div>
	</div>

</div>
<style>
	td {
		vertical-align: middle !important;
	}

	td p {
		margin: unset
	}

	img {
		max-width: 100px;
		max-height: :150px;
	}
</style>

<script>
	$(document).ready(function() {
		$('table').dataTable()
	})
	$('#new_clients').click(function() {
		uni_modal("Nuevo Cliente ", "manage_clients.php", "mid-large")

	})
	$('.edit_clients').click(function() {
		uni_modal("Gestionar Información del cliente", "manage_clients.php?id=" + $(this).attr('data-id'), "mid-large")

	})
	$('.delete_clients').click(function() {
		_conf("Deseas eliminar este Cliente? ", "delete_clients", [$(this).attr('data-id')])
	})

	function delete_clients($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_clients',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Datos eliminados exitósamente", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}
</script>