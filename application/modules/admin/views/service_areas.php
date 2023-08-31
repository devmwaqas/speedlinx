<!DOCTYPE html>
<html>

<head>

    <title>Admin | Service Areas </title>
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
                    <h2>Service Areas</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo admin_url(); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Service Areas</strong>
                        </li>
                    </ol>
                </div>
                <div class="col-lg-2">
                    <a href="<?php echo admin_url(); ?>service_areas/add" class="btn btn-primary mt-4"> Add Service Area </a>
                </div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5 class="float-left">Service Areas list</h5>

                            </div>
                            <div class="ibox-content">

                                <div class="table-responsive">

                                    <table id="admins_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Sr#</th>
                                                <th>Title</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; foreach ($service_areas as $area) { ?>
                                                <tr class="gradeX">

                                                    <td>
                                                        <?php echo $i; $i++; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $area['area_title']; ?>
                                                    </td>

                                                    <td>
                                                        <a href="<?php echo admin_url(); ?>service_areas/edit/<?php echo $area['id']; ?>" class="btn btn-primary btn-sm"> Edit </a>

                                                        <a href="javascript:void(0);" data-id="<?php echo $area['id']; ?>" data-model="service_areas" class="btn btn-danger btn-sm delete-btn"> Delete </a>
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