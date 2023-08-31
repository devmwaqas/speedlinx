<!DOCTYPE html>
<html>

<head>

    <title>Admin | Feedbacks </title>
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
                    <h2>Feedbacks</h2>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="<?php echo admin_url(); ?>">Dashboard</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <strong>Feedbacks</strong>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="wrapper wrapper-content animated fadeInRight">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox">
                            <div class="ibox-title">
                                <h5 class="float-left">Feedbacks list</h5>

                            </div>
                            <div class="ibox-content">

                                <div class="table-responsive">

                                    <table id="admins_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Sr#</th>
                                                <th>Mobile</th>
                                                <th>Message</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; foreach ($feedbacks as $feedback) { ?>
                                                <tr class="gradeX">

                                                    <td>
                                                        <?php echo $i; $i++; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $feedback['mobile']; ?>
                                                    </td>

                                                    <td>
                                                        <?php echo $feedback['message']; ?>
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