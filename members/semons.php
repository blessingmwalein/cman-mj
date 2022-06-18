<?php include('header.php'); ?>
<?php include('session.php'); ?>

<body>
    <?php include('navbar.php'); ?>
    <div class="container-fluid">
        <div class="row-fluid">
            <?php include('sidebar.php'); ?>

            <div class="span9" id="">
                <div class="row-fluid">
                    <!-- block -->
                    <div class="empty">
                        <div class="alert alert-success alert-dismissable">
                        </div>
                    </div>

                    <?php
                    $count_semons = mysqli_query($conn, "select * from semons");
                    $count = mysqli_num_rows($count_semons);
                    ?>
                    <div id="block_bg" class="block">
                        <div class="navbar navbar-inner block-header">
                            <div class="muted pull-left"></i><i class="icon-members"></i>Semons (s) List</div>
                            <div class="muted pull-right">
                                Number of semons: <span class="badge badge-info"><?php echo $count; ?></span>
                            </div>
                        </div>
                        <div class="block-content collapse in">
                            <div class="span12">
                                <form action="delete_memberss.php" method="post">
                                    <table cellpadding="0" cellspacing="0" border="0" class="table" id="example">

                                        <thead>
                                            <tr>
                                                <th>Title</th>
                                                <th>Description</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $members_query = mysqli_query($conn, "select * from semons") or die(mysqli_error());
                                            while ($row = mysqli_fetch_array($members_query)) {
                                                $id = $row['id'];
                                            ?>

                                                <tr>

                                                    <td><?php echo $row['title'] ?> </td>

                                                    <td><?php echo $row['description']; ?></td>
                                                    <td><?php echo $row['date']; ?></td>



                                                </tr>
                                            <?php } ?>
                                        </tbody>
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