<div class="row-fluid">
    <!-- block -->
    <div class="block">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left"><i class="icon-plus-sign icon-large">Add New Semon</i></div>
        </div>
        <div class="block-content collapse in">
            <div class="span12">

                <!--------------------form------------------->
                <form method="post">
                    <div class="control-group">
                        <p>
                        <div class="controls">
                            <p>
                                <input class="input focused" name="title" id="focusedInput" type="text" placeholder="Title" required>
                            </p>
                        </div>
                    </div>
                    </p>
                    <div class="control-group">
                        <p>
                        <div class="controls">
                            <p>
                                <textarea name="description" id="" class="form-control" rows="4"></textarea>
                            </p>
                        </div>
                    </div>


            </div>



            <div class="control-group">
                <div class="controls">
                    <button name="save" class="btn btn-info" id="save" data-placement="right" title="Click to Save"><i class="icon-plus-sign icon-large"> Save</i></button>
                    <script type="text/javascript">
                        $(document).ready(function() {
                            $('#save').tooltip('show');
                            $('#save').tooltip('hide');
                        });
                    </script>
                </div>
            </div>
            </form>

        </div>
    </div>
</div>
<!-- /block -->

<?php
if (isset($_POST['save'])) {
    $title = $_POST['title'];
    $description = $_POST['description'];

    mysqli_query($conn, "insert into semons (title,description) 
values('$title','$description')") or die(mysqli_error());

    mysqli_query($conn, "insert into activity_log (date,username,action) values(NOW(),'$admin_username','Added semon $mobile')") or die(mysqli_error());
?>
    <script>
        window.location = "semons.php";
        $.jGrowl("Semon Successfully added", {
            header: 'Semon add'
        });
    </script>
<?php

}
?>