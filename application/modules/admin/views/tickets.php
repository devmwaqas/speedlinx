<!DOCTYPE html>
<html>

<head>

    <title>Admin | Tickets </title>
    <?php $this->load->view('common/admin_header'); ?>

</head>

<body>
    <div id="wrapper">

        <?php $this->load->view('common/admin_nav'); ?>
        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <?php $this->load->view('common/admin_top_nav'); ?>
            </div>

            <div class="row wrapper border-bottom white-bg page-heading">
                <div class="col-lg-10">
                    <h2>Tickets</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo admin_url(); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Tickets</strong>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5 class="float-left">Tickets list</h5>

                            </div>
                            <div class="ibox-content">

                                <div class="table-responsive">

                                    <table id="admins_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Sr#</th>
                                                <th>User</th>
                                                <th>Service Type</th>
                                                <th>Issue Type</th>
                                                <th>Availablity Time</th>
                                                <th>Assign To</th>
                                                <th>Assign By</th>
                                                <th>Assign Date</th>
                                                <th>Status</th>
                                                <th>Created Date</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; foreach ($tickets as $ticket) { ?>
                                                <tr class="gradeX">

                                                    <td>
                                                        <?php echo $i; $i++; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $ticket['created_by']; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $ticket['service_name']; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $ticket['issue_type']; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $ticket['availablity_time']; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $ticket['assigned_to']; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $ticket['assigned_by']; ?>
                                                    </td>

                                                    <td>
                                                        <?php if(!empty($ticket['assign_at'])) { echo date('Y-m-d h:i A', strtotime($ticket['assign_at'])); } ?>
                                                    </td>

                                                    <td>
                                                       <?php if($ticket['status'] == 1) {
                                                        $label_class = 'primary';
                                                        $label = 'Open';
                                                    } elseif($ticket['status'] == 2) {
                                                        $label_class = 'info';
                                                        $label = 'Assigned';
                                                    } else {
                                                        $label_class = 'success';
                                                        $label = 'Closed';
                                                    } ?>
                                                    <span class="label label-<?php echo $label_class; ?>"><?php echo $label; ?></span>
                                                </td>

                                                <td>
                                                    <?php if(!empty($ticket['created_at'])) { echo date('Y-m-d h:i A', strtotime($ticket['created_at'])); } ?>
                                                </td>

                                                <td>

                                                    <a href="javascript:void(0);" data-id="<?php echo $ticket['id']; ?>" class="btn btn-info btn-sm view_ticket"> View/Assign </a>

                                                </td>

                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('common/admin_footer'); ?>
    </div>

</div>

<?php $this->load->view('common/admin_scripts'); ?>

</body>
</html>