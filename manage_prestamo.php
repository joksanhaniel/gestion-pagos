<?php
include 'db_connect.php';
if (isset($_GET['id'])) {
    $qry = $conn->query("SELECT * FROM prestamos where id= " . $_GET['id']);
    foreach ($qry->fetch_array() as $k => $val) {
        $$k = $val;
    }
}
?>
<div class="container-fluid">
    <form action="" id="manage-prestamo">
        <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
        <div class="row">
            <div class="col-lg-6 border-right">
                <h5><b>Prestamos</b></h5>
                <hr>
                <div id="msg" class="form-group"></div>
                <div class="form-group">
                    <label for="" class="control-label">Prestamo</label>
                        <select class="form-control" name="prestamo" required>
                        <option value="Préstamo Personal"<?php echo $prestamo == 'Préstamo Personal' ? ' selected' : ''; ?>>Préstamo Personal</option>
                        <option value="Préstamo Hipotecario"<?php echo $prestamo == 'Préstamo Hipotecario' ? ' selected' : ''; ?>>Préstamo Hipotecario</option>
                        <option value="Préstamo para Automóvil"<?php echo $prestamo == 'Préstamo para Automóvil' ? ' selected' : ''; ?>>Préstamo para Automóvil</option>
                        <option value="Préstamo Estudiantil"<?php echo $prestamo == 'Préstamo Estudiantil' ? ' selected' : ''; ?>>Préstamo Estudiantil</option>
                        <option value="Préstamo Comercial"<?php echo $prestamo == 'Préstamo Comercial' ? ' selected' : ''; ?>>Préstamo Comercial</option>
                        <option value="Línea de Crédito"<?php echo $prestamo == 'Línea de Crédito' ? ' selected' : ''; ?>>Línea de Crédito</option>
                        <option value="Préstamo Garantizado"<?php echo $prestamo == 'Préstamo Garantizado' ? ' selected' : ''; ?>>Préstamo Garantizado</option>
                        <option value="Préstamo No Garantizado"<?php echo $prestamo == 'Préstamo No Garantizado' ? ' selected' : ''; ?>>Préstamo No Garantizado</option>
                        <option value="Préstamo a Plazos"<?php echo $prestamo == 'Préstamo a Plazos' ? ' selected' : ''; ?>>Préstamo a Plazos</option>
                        <option value="Préstamo a Corto Plazo"<?php echo $prestamo == 'Préstamo a Corto Plazo' ? ' selected' : ''; ?>>Préstamo a Corto Plazo</option>
                        <option value="Préstamo a Largo Plazo"<?php echo $prestamo == 'Préstamo a Largo Plazo' ? ' selected' : ''; ?>>Préstamo a Largo Plazo</option>
                        <option value="Préstamo con Tasa Fija"<?php echo $prestamo == 'Préstamo con Tasa Fija' ? ' selected' : ''; ?>>Préstamo con Tasa Fija</option>
                        <option value="Préstamo con Tasa Variable"<?php echo $prestamo == 'Préstamo con Tasa Variable' ? ' selected' : ''; ?>>Préstamo con Tasa Variable</option>
                        <option value="Préstamo de Consolidación de Deudas"<?php echo $prestamo == 'Préstamo de Consolidación de Deudas' ? ' selected' : ''; ?>>Préstamo de Consolidación de Deudas</option>
                        </select>
                </div>

                <div class="form-group">
                    <label for="" class="control-label">Descripción</label>
                    <textarea name="description" id="" cols="30" rows="4" class="form-control" required=""><?php echo isset($description) ? $description : '' ?></textarea>
                </div>
            </div>
            <div class="col-lg-6">
                <h5><b>Información de los Pagos</b></h5>
                <hr>
                <div class="">
                <div class="form-group mb-2">
    <label for="" class="control-label">Tipo de Pago</label>
    <select class="form-control" name="level" required>
        <option value="pago Semanal" <?php echo $level == 'pago Semanal' ? 'selected' : ''; ?>>Pago Semanal</option>
        <option value="Pago Quincenal" <?php echo $level == 'Pago Quincenal' ? 'selected' : ''; ?>>Pago Quincenal</option>
        <option value="Pago Mensual" <?php echo $level == 'Pago Mensual' ? 'selected' : ''; ?>>Pago Mensual</option>
    </select>
</div>

<div class="form-group mb-2">
    <label for="interes" class="control-label">% de Interes</label>
    <select class="form-control" id="interes" name="interes" required>
        <?php
        $interes = range(0, 100);
        foreach ($interes as $ints) {
            $percentage = $ints . '%';
            echo '<option value="' . $ints . '">' . $percentage . '</option>';
        }
        ?>
    </select>
</div>

                    <div class="form-group">
                        <label for="" class="control-label">Monto</label>
                        <input type="number" step="any" min="0" id="amount" class="form-control text-right">
                    </div>
                    <div class="form-group pt-1">
    <label for="" class="control-label">&nbsp;</label>
    <button class="btn btn-primary btn-sm" type="button" id="add_fee">Agregar a la Lista</button>
</div>

                </div>
                <hr>
                <table class="table table-condensed" id="fee-list">
                    <thead>
                        <tr>
                            <th width="5%"></th>
                            <th width="20%">Interes</th>
                            <th width="50%">Prestamo</th>
                            <th width="45%">Monto</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if (isset($id)) :
                            $fees = $conn->query("SELECT * FROM fees WHERE prestamo_id = $id");
                            $total = 0;
                            while ($row = $fees->fetch_assoc()) :
                                $total += $row['amount'];
                        ?>
                                <tr>
                                    <td class="text-center"><button class="btn-sm btn-outline-danger" type="button" onclick="rem_list($(this))"><i class="fa fa-times"></i></button></td>
                                    <!-- <td>
                                        <?php echo $row['interes'] . '%' ?>
                                    </td> -->
                                    <td>
                                        <input type="hidden" name="fid[]" value="<?php echo $row['id'] ?>">
                                        <input type="hidden" name="type[]" value="<?php echo $row['prestamo_id'] ?>">
                                        <p><small><b class="ftype"><?php echo $row['prestamo_id'] ?></b></small></p>
                                    </td>
                                    <td>
                                        <input type="hidden" name="amount[]" value="<?php echo $row['amount'] ?>">
                                        <p class="text-right"><small><b class="famount"><?php echo number_format($row['amount']) ?></b></small></p>
                                    </td>
                                </tr>
                        <?php
                            endwhile;
                        endif;
                        ?>

                    </tbody>

                    <tfoot>
                        <tr>
                            <th colspan="1" class="text-center">Total</th>
                            <th colspan='2' class="text-right">
                                <input type="hidden" name="total_amount" value="<?php echo isset($total) ? $total : 0 ?>">
                                <span class="tamount"><?php echo isset($total) ? number_format($total, 2) : '0.00' ?></span>
                            </th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </form>
</div>
<div id="fee_clone" style="display: none">
    <table>
        <tr>
            <td class="text-center"><button class="btn-sm btn-outline-danger" type="button" onclick="rem_list($(this))"><i class="fa fa-times"></i></button></td>
            <td>
                <input type="hidden" name="fid[]">
                <input type="hidden" name="type[]">
                <p><small><b class="ftype"></b></small></p>
            </td>
            <td>
                <input type="hidden" name="interes[]">
                <p><small><b class="finteres"></b></small></p>
            </td>
            <td>
                <input type="hidden" name="level[]">
                <p><small><b class="flevel"></b></small></p>
            </td>
            <td>
                <input type="hidden" name="amount[]">
                <p class="text-right"><small><b class="famount"></b></small></p>
            </td>
        </tr>
    </table>
</div>



<script>
    $('#add_fee').click(function() {
        var interes = $('#interes').val(); // Obtener el valor del porcentaje seleccionado
        var level = $('[name="level"]').val(); // Obtener el valor del tipo de pago seleccionado


        var ft = $('#ft').val()
        var amount = $('#amount').val()
        if (amount == '' || interes == '' || level == '') {
        alert_toast("Complete primero los campos Tipo de tarifa, Porcentaje y Monto.", 'warning');
        return false;
        }

        

        var tr = $('#fee_clone tr').clone()
        tr.find('.finteres').text(interes + '%'); 
        tr.find('.flevel').text(level);

        tr.find('[name="type[]"]').val(ft)
        tr.find('.ftype').text(ft)
        tr.find('[name="amount[]"]').val(amount)
        tr.find('.famount').text(parseFloat(amount).toLocaleString('en-US'))
        $('#fee-list tbody').append(tr)
        $('#ft').val('').focus()
        $('#amount').val('')
        $('#interes').val(''); // Reiniciar el campo de porcentaje
        $('[name="level"]').val('');
        calculate_total()
    })

    function calculate_total() {
        var total = 0;
        $('#fee-list tbody').find('[name="amount[]"]').each(function() {
            total += parseFloat($(this).val())
        })
        $('#fee-list tfoot').find('.tamount').text(parseFloat(total).toLocaleString('en-US'))
        $('#fee-list tfoot').find('[name="total_amount"]').val(total)

    }

    function rem_list(_this) {
        _this.closest('tr').remove()
        calculate_total()
    }
    $('#manage-prestamo').submit(function(e) {
        e.preventDefault()
        start_load()
        $('#msg').html('')
        if ($('#fee-list tbody').find('[name="fid[]"]').length <= 0) {
            alert_toast("Inserte al menos 1 fila en la tabla de tarifas", 'danger')
            end_load()
            return false;
        }
        $.ajax({
            url: 'ajax.php?action=save_prestamo',
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                if (resp == 1) {
                    alert_toast("Datos guardados con éxito.", 'success')
                    setTimeout(function() {
                        location.reload()
                    }, 1000)
                } else if (resp == 2) {
                    $('#msg').html('<div class="alert alert-danger mx-2">El nombre del prestamo y el tipo ya existen.</div>')
                    end_load()
                }
            }
        })
    })

    $('.select2').select2({
        placeholder: "Seleccione aquí",
        width: '100%'
    })
</script>
