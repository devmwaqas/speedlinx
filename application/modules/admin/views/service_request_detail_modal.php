<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title">Service Request Detail</h4>
</div>
<div class="modal-body" id="employeeModal">

    <div class="row">

        <div class="col-md-6">

            <p><strong>Status: </strong> <?php if($request_detail['status'] == 0) {
                $label_class = 'primary';
                $label = 'Open';
            } elseif($request_detail['status'] == 1) {
                $label_class = 'info';
                $label = 'Assigned';
            } else {
                $label_class = 'success';
                $label = 'Closed';
            } ?>
            <span class="label label-<?php echo $label_class; ?>"><?php echo $label; ?></span> </p>

            <p><strong>Full Name: </strong> <?php echo $request_detail['full_name'] ?> </p>
            <p><strong>Phone: </strong> <?php echo $request_detail['phone'] ?> </p>
            <p><strong>Email: </strong> <?php echo $request_detail['email'] ?> </p>
            <p><strong>CNIC: </strong> <?php echo $request_detail['cnic'] ?> </p>
            <p><strong>Address 1&2: </strong> <?php echo $request_detail['address_line_1']." ".$request_detail['address_line_2'] ?></p>
            <p><strong>Service Type: </strong> <?php echo $request_detail['service_name'] ?> </p>

        </div>

        <div class="col-md-6">

            <p><strong>Connection Type: </strong> <?php echo $request_detail['connection_type'] ?> </p>
            <p><strong>TV Service Type: </strong> <?php echo $request_detail['tv_service_type'] ?> </p>
            <p><strong>Digital Boxes: </strong> <?php echo $request_detail['no_digital_boxes'] ?> </p>
            <p><strong>Assign To: </strong> <?php echo $request_detail['assigned_to'] ?> </p>
            <p><strong>Assign By: </strong> <?php echo $request_detail['assigned_by'] ?> </p>
            <p><strong>Assign Date: </strong> <?php if(!empty($request['assign_at'])) { echo date('Y-m-d h:i A', strtotime($request['assign_at'])); } ?> </p>
            <p><strong>Create Date: </strong> <?php if(!empty($request_detail['created_at'])) { echo date('Y-m-d h:i A', strtotime($request_detail['created_at'])); } ?> </p>

        </div>

    </div>

    <?php if($request_detail['status'] == 0) { ?>

        <div class="row">

            <div class="col-md-12">

                <h3> Assign Request </h3>

                <form action="" method="post" id="assign_request_form">

                    <input type="hidden" name="request_id" value="<?php echo $request_detail['id']; ?>">

                    <div class="form-group">
                        <label for="employee">Employee</label> <br>
                        <select class="form-control" id="employee_id" name="employee_id" style="width: 30%;">
                          <option value=""> Select </option>
                          <?php foreach ($employees as $emp) { ?>
                            <option value="<?php echo $emp['id']; ?>" title="<?php echo "Email: ".$emp['email'].", Mobile #: ".$emp['mobile']; ?>">
                                <?php echo $emp['first_name']." ".$emp['last_name']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <button type="button" class="btn btn-success" id="assign_request_btn"> Assign </button>
                </div>

            </form>
        </div>

    </div>

<?php } ?>

</div>

<script type="text/javascript">

    $('#employee_id').select2({
        dropdownParent: $('#employeeModal')
    });

</script>