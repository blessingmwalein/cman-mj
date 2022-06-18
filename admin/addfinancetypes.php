<div class="row-fluid">
    <!-- block -->
    <div class="block">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left"><i class="icon-plus-sign icon-large"> Add New Finance Type</i></div>
        </div>
        <div class="block-content collapse in">
            <div class="span12">

                <!--------------------form------------------->
                <form method="post">
                    <div class="control-group">
                        <div class="controls">
                            <p>
                                <input class="input focused" name="name" id="focusedInput" type="text" placeholder="Name" required>
                            </p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <p>
                                <textarea name="description" class="form-control" id="" cols="" rows="3"></textarea>
                            </p>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <p>
                                <select class="input focused" name="type" id="focusedInput" required="required" type="text">
                                    <option value="">Select type</option>
                                    <option value="income">Income</option>
                                    <option value="expense">Expense</option>
                                </select>
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
    $name = $_POST['name'];
    $description = $_POST['description'];
    $type = $_POST['type'];

    mysqli_query($conn, "insert into finance_type (name, description, type) 
values('$name','$description','$type')") or die(mysqli_error());

    mysqli_query($conn, "insert into activity_log (date,username,action) values(NOW(),'','Added finance type')") or die(mysqli_error());
?>
    <script>
        window.location = "finance_types.php";
        $.jGrowl("Finance type successfully added", {
            header: 'Finance type add'
        });
    </script>
<?php

}
?>