<!DOCTYPE html>
<html>

<head>

    <title>Admin | Edit User </title>
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
                <h2>Edit User</h2>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="<?php echo admin_url(); ?>users">Users</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <strong>Edit User</strong>
                    </li>
                </ol>
            </div>
            <div class="col-lg-2">
                <a href="<?php echo admin_url(); ?>users" class="btn btn-primary mt-4"> Back to Users </a>
            </div>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight">

            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox">
                        <div class="ibox-title">
                            <h5 class="float-left">Edit User</h5>

                        </div>
                        <div class="ibox-content">


                            <form id="update_user_form" action="" method="post" class="form-horizontal">
                                <input type="hidden" name="user_id" value="<?php echo $user_detail['id']; ?>">
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">First Name</label>
                                    <div class="col-sm-10">
                                        <input type="text" name="first_name" id="first_name" class="form-control" required="required" value="<?php echo $user_detail['first_name']; ?>" placeholder="First Name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Last Name</label>

                                    <div class="col-sm-10">
                                        <input type="text" name="last_name" id="last_name" class="form-control" required="required" value="<?php echo $user_detail['last_name']; ?>" placeholder="Last Name">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Mobile</label>

                                    <div class="col-sm-10">
                                        <input type="text" name="mobile" id="mobile" class="form-control" required="required" value="<?php echo $user_detail['mobile']; ?>" placeholder="Mobile">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="email" name="email" id="email" class="form-control" required="required" value="<?php echo $user_detail['email']; ?>" placeholder="Email">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Confirm Password</label>
                                    <div class="col-sm-10">
                                        <input type="password" name="c_password" id="c_password" class="form-control" placeholder="Confirm Password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">User Role</label>
                                    <div class="col-sm-10">

                                        <div class="radio radio-info">
                                            <input type="radio" class="iradio_square-green" id="inlineRadio1" value="1" name="user_type" <?php if($user_detail['user_type'] == 1) { ?> checked="" <?php } ?>>
                                            <label for="inlineRadio1"> Admin </label>
                                        </div>

                                        <div class="radio radio-info">
                                            <input type="radio" class="iradio_square-green" id="inlineRadio2" value="2" name="user_type" <?php if($user_detail['user_type'] == 2) { ?> checked="" <?php } ?>>
                                            <label for="inlineRadio2"> Employee </label>
                                        </div>

                                        <div class="radio radio-info">
                                            <input type="radio" class="iradio_square-green" id="inlineRadio3" value="3" name="user_type" <?php if($user_detail['user_type'] == 3) { ?> checked="" <?php } ?>>
                                            <label for="inlineRadio3"> Customer </label>
                                        </div>

                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-sm-4 col-sm-offset-2">
                                        <button class="btn btn-primary" type="button" id="update_user_btn">
                                            Update User
                                        </button>
                                    </div>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php $this->load->view('common/admin_footer'); ?>
    </div>

</div>

<?php $this->load->view('common/admin_scripts'); ?>

<script type="text/javascript">
    $("#update_user_form").validate();

    $(document).on("click", "#update_user_btn", function(e) {

        if($("#update_user_form").valid()){

          e.preventDefault();
          var formData = $('#update_user_form').serialize();
          var ajaxurl = '<?php echo admin_url().'users/update_user'; ?>';

          $.ajax({
            url: ajaxurl,
            type : 'post',
            dataType: "json",
            data: formData,
            success: function(data ) {
              if(data.msg =='error') {
                toastr.error(data.response);
            }else if(data.msg =='success') {
                toastr.success(data.response);
                setTimeout(function() { location.href = '<?php echo admin_url().'users'; ?>'; }, 1500);
            }
        }
    });
      }
  });

</script>

</body>
</html>