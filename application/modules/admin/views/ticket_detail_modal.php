<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
    <h4 class="modal-title">Service Request Detail</h4>
</div>
<div class="modal-body" id="employeeModal">

    <div class="row">

        <div class="col-md-6">

            <p><strong>Status: </strong> <?php if($ticket_detail['status'] == 1) {
                $label_class = 'primary';
                $label = 'Open';
            } elseif($ticket_detail['status'] == 2) {
                $label_class = 'info';
                $label = 'Assigned';
            } else {
                $label_class = 'success';
                $label = 'Closed';
            } ?>
            <span class="label label-<?php echo $label_class; ?>"><?php echo $label; ?></span> </p>

            <p><strong>User: </strong> <?php echo $ticket_detail['created_by'] ?> </p>
            <p><strong>Assign To: </strong> <?php echo $ticket_detail['assigned_to'] ?> </p>
            <p><strong>Assign By: </strong> <?php echo $ticket_detail['assigned_by'] ?> </p>
            <p><strong>Assign Date: </strong> <?php if(!empty($request['assign_at'])) { echo date('Y-m-d h:i A', strtotime($request['assign_at'])); } ?> </p>

        </div>

        <div class="col-md-6">

            <p><strong>Service Type: </strong> <?php echo $ticket_detail['service_name'] ?> </p>
            <p><strong>Issue Type: </strong> <?php echo $ticket_detail['issue_type'] ?> </p>
            <p><strong>Description: </strong> <?php echo $ticket_detail['description'] ?> </p>
            <p><strong>Create Date: </strong> <?php if(!empty($ticket_detail['created_at'])) { echo date('Y-m-d h:i A', strtotime($ticket_detail['created_at'])); } ?> </p>

        </div>

    </div>

    <?php if($ticket_detail['status'] == 1) { ?>

        <div class="row">

            <div class="col-md-12">

                <h3> Assign Ticket </h3>

                <form action="" method="post" id="assign_ticket_form">

                    <input type="hidden" name="ticket_id" value="<?php echo $ticket_detail['id']; ?>">

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
                    <button type="button" class="btn btn-success" id="assign_ticket_btn"> Assign </button>
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