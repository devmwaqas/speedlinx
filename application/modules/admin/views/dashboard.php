<!DOCTYPE html>
<html>

<head>
    <title>Admin | Dashboard </title>
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
                <h2>Summary</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?php echo admin_url(); ?>">Dashboard</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Summary</strong>
                    </li>
                </ol>
            </div>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight">

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5 class="float-left">Summary of oline requests/tickets/feedback</h5>

                        </div>
                        <div class="ibox-content">

                            <div class="table-responsive">

                                <table id="admins_table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th> Logo </th>
                                            <th> Service Requests </th>
                                            <th> Tickets </th>
                                            <th> Feedback </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> <b>Received</b></td>
                                            <td> <?php echo service_requests('received'); ?> </td>
                                            <td> <?php echo tickets('received'); ?></td>
                                            <td> <?php echo feedbacks('received'); ?></td>
                                        </tr>
                                        <tr>
                                            <td> <b>Resolved</b></td>
                                            <td> <?php echo service_requests('resolved'); ?> </td>
                                            <td> <?php echo tickets('resolved'); ?></td>
                                            <td> N/A </td>
                                        </tr>
                                        <tr>
                                            <td> <b>In progress</b></td>
                                            <td> <?php echo service_requests('inprogress'); ?> </td>
                                            <td> <?php echo tickets('inprogress'); ?></td>
                                            <td> N/A </td>
                                        </tr>
                                        <tr>
                                            <td> <b>Pending due to approval</b></td>
                                            <td> <?php echo service_requests('pending_approval'); ?> </td>
                                            <td> <?php echo tickets('pending_approval'); ?></td>
                                            <td> N/A </td>
                                        </tr>
                                        <tr>
                                            <td> <b>Pending with team</b></td>
                                            <td> <?php echo service_requests('pending_by_team'); ?> </td>
                                            <td> <?php echo tickets('pending_by_team'); ?></td>
                                            <td> N/A </td>
                                        </tr>
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