<div class="row-fluid">
    <!-- block -->
    <div class="block">
        <div class="navbar navbar-inner block-header">
            <div class="muted pull-left"><i class="icon-plus-sign icon-large"> Add New Currency</i></div>
        </div>
        <div class="block-content collapse in">
            <div class="span12">

                <!--------------------form------------------->
                <form method="post">
                    <div class="control-group">
                        <p>
                        <div class="controls">
                            <p>
                                <input class="input focused" name="code" id="focusedInput" type="text" placeholder="Currency Code" required>
                            </p>
                        </div>
                    </div>
                    </p>

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
    $code = $_POST['code'];


    mysqli_query($conn, "insert into  currencies (code) 
values('$code')") or die(mysqli_error());

    mysqli_query($conn, "insert into activity_log (date,username,action) values(NOW(),'','Added currency')") or die(mysqli_error());
?>
    <script>
        window.location = "currencies.php";
        $.jGrowl("Currency Successfully added", {
            header: 'Currency add'
        });
    </script>
<?php

}
?>