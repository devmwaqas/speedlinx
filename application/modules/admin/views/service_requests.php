<!DOCTYPE html>
<html>

<head>

    <title>Admin | Service Requests </title>
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
                    <h2>Service Requests</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo admin_url(); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Service Requests</strong>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5 class="float-left">Service Requests list</h5>

                            </div>
                            <div class="ibox-content">

                                <div class="table-responsive">

                                    <table id="admins_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Sr#</th>
                                                <th>Full Name</th>
                                                <th>Phone</th>
                                                <th>Email</th>
                                                <th>CNIC</th>
                                                <th>Address 1&2</th>
                                                <th>Service Type</th>
                                                <th>Connection Type</th>
                                                <th>TV Service Type</th>
                                                <th>Digital Boxes</th>
                                                <th>Assign To</th>
                                                <th>Assign By</th>
                                                <th>Assign Date</th>
                                                <th>Create Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; foreach ($service_requests as $request) { ?>
                                                <tr class="gradeX">

                                                    <td>
                                                        <?php echo $i; $i++; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $request['full_name']; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $request['phone']; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $request['email']; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $request['cnic']; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $request['address_line_1']." ".$request['address_line_2']; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $request['service_name']; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $request['connection_type']; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $request['tv_service_type']; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $request['no_digital_boxes']; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $request['assigned_to']; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $request['assigned_by']; ?>
                                                    </td>

                                                    <td>
                                                        <?php if(!empty($request['assign_at'])) { echo date('Y-m-d h:i A', strtotime($request['assign_at'])); } ?>
                                                    </td>
                                                    <td>
                                                        <?php if(!empty($request['created_at'])) { echo date('Y-m-d h:i A', strtotime($request['created_at'])); } ?>
                                                    </td>

                                                    <td>
                                                       <?php if($request['status'] == 0) {
                                                        $label_class = 'primary';
                                                        $label = 'Open';
                                                    } elseif($request['status'] == 1) {
                                                        $label_class = 'info';
                                                        $label = 'Assigned';
                                                    } else {
                                                        $label_class = 'success';
                                                        $label = 'Closed';
                                                    } ?>
                                                    <span class="label label-<?php echo $label_class; ?>"><?php echo $label; ?></span>
                                                </td>

                                                <td>

                                                    <a href="javascript:void(0);" data-id="<?php echo $request['id']; ?>" class="btn btn-info btn-sm view_request"> View/Assign </a>

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