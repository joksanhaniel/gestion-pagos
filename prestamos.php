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
						<b>Lista de prestamos y Montos</b>
						<span class="float:right"><a class="btn btn-primary col-sm-6 col-md-2 float-right" href="javascript:void(0)" id="new_prestamo">
								<i class="fa fa-plus"></i> Agregar
							</a></span>

					</div>
					<div class="card-body">
						<table class="table table-condensed table-bordered table-hover">
							<thead>
								<tr>
									<th class="text-center">#</th>
									<th class="">Creado</th>
									<th class="">Prestamo</th>
									<th class="">Tipo de Pago</th>
									<th class="">Descripción</th>
									<th class="">Interes</th>
									<th class="">Monto Total</th>
									<th class="text-center">Acción</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$i = 1;
								$prestamo = $conn->query("SELECT * FROM prestamos  order by id desc ");
								while ($row = $prestamo->fetch_assoc()) :
								?>
									<tr>
									<td class="text-center"><?php echo $i++ ?></td>
									<td>
										<?php echo $row['date_created'] ?>
									</td>
									<td>
										<?php echo $row['prestamo'] ?>
									</td>
									<td>
										<?php echo $row['level'] ?>
									</td>
									<td class="">
										<p><?php echo $row['description'] ?></p>
									</td>
									<td>
										<?php echo $row['interes'] . '%'  ?>
									</td>
									<td class="text-right">
										<?php echo number_format($row['total_amount'], 2) ?>
									</td>
									<td class="text-center">
										<button class="btn btn-primary edit_prestamo" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-edit"></i></button>
										<button class="btn btn-danger delete_prestamo" type="button" data-id="<?php echo $row['id'] ?>"><i class="fa fa-trash-alt"></i></button>
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
	$('#new_prestamo').click(function() {
		uni_modal("Prestamos y Montos", "manage_prestamo.php", 'large')

	})

	$('.edit_prestamo').click(function() {
		uni_modal("Administrar la entrada de prestamos y Montos", "manage_prestamo.php?id=" + $(this).attr('data-id'), 'large')

	})
	$('.delete_prestamo').click(function() {
		_conf("¿Deseas eliminar este prestamo?", "delete_prestamo", [$(this).attr('data-id')])
	})

	function delete_prestamo($id) {
		start_load()
		$.ajax({
			url: 'ajax.php?action=delete_prestamo',
			method: 'POST',
			data: {
				id: $id
			},
			success: function(resp) {
				if (resp == 1) {
					alert_toast("Datos eliminados con éxito", 'success')
					setTimeout(function() {
						location.reload()
					}, 1500)

				}
			}
		})
	}
</script>