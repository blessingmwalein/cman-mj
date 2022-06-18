<?php include('header.php'); ?>
<?php include('session.php'); ?>

<body>
    <?php include('navbar.php'); ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <?php include('sidebar.php'); ?>
            <div class="span3" id="addmembers">
                <?php include('addfinances.php'); ?>
            </div>
            <div class="span6" id="">
                <div class="row-fluid">
                    <!-- block -->
                    <div class="empty">
                        <div class="alert alert-success alert-dismissable">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <i class="icon-info-sign"></i> <strong>Status!:</strong> <?php if (isset($_GET['x_result'])) {
                                                                                            if ($_GET['x_result'] == 'completed') {
                                                                                                echo "Transaction was successfull";
                                                                                            } else {
                                                                                                echo "Transaction failed try again";
                                                                                            }
                                                                                        } ?>
                        </div>
                    </div>

                    <?php

                    echo $user_row['keyu'];
                    $count_finances = mysqli_query($conn, "select * from  finance where member_id=" . $user_row['keyu']);
                    $count = mysqli_num_rows($count_finances);
                    ?>
                    <div id="block_bg" class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left"></i><i class="icon-members"></i> Finance (s) List</div>
                            <div class="muted pull-right">
                                Number of Finance: <span class="badge badge-info"><?php echo $count; ?></span>
                            </div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                <form action="delete_memberss.php" method="post">
                                    <table cellpadding="0" cellspacing="0" border="0" class="table" id="example">
                                        <a data-placement="right" title="Click to Delete check item" data-toggle="modal" href="#members_delete" id="delete" class="btn btn-danger" name=""><i class="icon-trash icon-large"> Delete</i></a>
                                        <script type="text/javascript">
                                            $(document).ready(function() {
                                                $('#delete').tooltip('show');
                                                $('#delete').tooltip('hide');
                                            });
                                        </script>
                                        <?php include('modal_delete.php'); ?>
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Name</th>
                                                <th>Description</th>
                                                <th>Type</th>
                                                <th>Amount</th>
                                                <th>Curreny</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $cashIncome = 0;
                                            $cashExpenses = 0;

                                            $rtgsIncome = 0;
                                            $rtgsExpenses = 0;

                                            $usdIncome = 0;
                                            $usdExpenses = 0;


                                            $finances_query = mysqli_query($conn, "select finance.id, finance.name As finance_name , finance.amount, finance.description AS finance_description,finance.currency_code, finance_type.name AS finance_type_name,finance_type.description as finance_type_description, finance_type.type from finance INNER JOIN finance_type ON finance.finance_type_id=finance_type.id where member_id=" . $user_row['keyu']) or die(mysqli_error());
                                            while ($row = mysqli_fetch_array($finances_query)) {
                                                $id = $row['id'];
                                                if (strtolower($row['currency_code']) == 'cash') {
                                                    if (strtolower($row['type']) == 'income') {
                                                        $cashIncome += $row['amount'];
                                                    } else {
                                                        $cashExpenses += $row['amount'];
                                                    }
                                                } else if (strtolower($row['currency_code']) == 'rtgs') {
                                                    if (strtolower($row['type']) == 'income') {
                                                        $rtgsIncome += $row['amount'];
                                                    } else {
                                                        $rtgsExpenses += $row['amount'];
                                                    }
                                                } else if (strtolower($row['currency_code']) == 'usd') {
                                                    if (strtolower($row['type']) == 'income') {
                                                        $usdIncome += $row['amount'];
                                                    } else {
                                                        $usdExpenses += $row['amount'];
                                                    }
                                                }
                                            ?>

                                                <tr>
                                                    <td width="30">
                                                        <input id="optionsCheckbox" class="uniform_on" name="selector[]" type="checkbox" value="<?php echo $id; ?>">
                                                    </td>
                                                    <td><?php echo $row['finance_name']; ?></td>
                                                    <td><?php echo $row['finance_description']; ?></td>
                                                    <td><?php echo $row['type']; ?></td>
                                                    <td><?php echo $row['amount']; ?></td>
                                                    <td><?php echo $row['currency_code']; ?></td>
                                                    <?php include('toolttip_edit_delete.php'); ?>
                                                    <td width="120">
                                                        <a rel="tooltip" title="Edit Finance" id="e<?php echo $id; ?>" href="edit_finance.php<?php echo '?id=' . $id; ?>" data-toggle="modal" class="btn btn-success"><i class="icon-pencil icon-large"> Edit</i></a>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>Income</th>
                                                <th>Expenses</th>
                                                <th>Net</th>

                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <th>Cash</th>
                                                <td><?php echo $cashIncome ?></td>
                                                <td><?php echo $cashExpenses  ?></td>
                                                <td><?php echo $cashIncome - $cashExpenses ?></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>

                                                <th>Rtgs</th>
                                                <td><?php echo $rtgsIncome ?></td>
                                                <td><?php echo $rtgsExpenses  ?></td>
                                                <td><?php echo $rtgsIncome - $rtgsExpenses ?></td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <th>Usd</th>
                                                <td><?php echo $usdIncome ?></td>
                                                <td><?php echo $usdExpenses  ?></td>
                                                <td><?php echo $usdIncome - $usdExpenses ?></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /block -->
                </div>
            </div>
        </div>
        <?php include('footer.php'); ?>
    </div>
    <?php include('script.php'); ?>
</body>

</html>