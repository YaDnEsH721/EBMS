<?php 
    require_once('head_html.php'); 
    require_once('../Includes/config.php'); 
    require_once('../Includes/session.php'); 
    require_once('../Includes/user.php'); 
    if ($logged==false) {
         header("Location:../index.php");
    }
?>
<style>
    h1 {
        border-bottom: 1px solid lightgrey !important;
    }
    th {
        padding: 2rem .5rem !important;
    }
</style>
<body>
    <div id="wrapper">
        <?php 
            require_once("nav.php");
            require_once("sidebar.php");
        ?>
        <!-- Page Content -->
        <div id="page-content-wrapper">
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">Bills</h1>
                        <!-- Pills Tabbed HISTORY | DUE -->
                        <ul class="nav nav-pills nav-justified">
                            <li class="active"><a href="#history" data-toggle="pill">History</a>
                            </li>
                            <li class=""><a href="#due" data-toggle="pill">Due</a>
                            </li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="history">
                                <!-- <h4>{User} Bills(ALL UP TO DATE) goes here{Table form}</h4> -->
                                <!-- DB RETRIEVAL search db where id is his and status is processed -->
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <th>Bill No.</th>
                                                <th>Bill Date</th>
                                                <th>UNITS Consumed</th>
                                                <th>Amount</th>
                                                <th>Due Date</th>
                                                <th>STATUS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $id=$_SESSION['uid'];
                                            $query1 = "SELECT COUNT(*) FROM bill where uid={$id}";
                                            $result1 = mysqli_query($con,$query1);
                                            $row1 = mysqli_fetch_row($result1);
                                            $numrows = $row1[0];
                                            include("paging1.php");

                                            $result = retrieve_bills_history($_SESSION['uid'],$offset, $rowsperpage);
                                            // Initialising #
                                            while($row = mysqli_fetch_assoc($result)){
                                            ?>
                                                <tr>
                                                    <td height="50"><?php echo 'EBS_'.$row['id'] ?></td>
                                                    <td height="50"><?php echo $row['bdate'] ?></td>
                                                    <td><?php echo $row['units'] ?></td>
                                                    <td><?php echo  $row['amount'] ?></td>
                                                    <td><?php echo $row['ddate'] ?></td>
                                                    <td><?php echo $row['status'] ?></td>
                                                </tr>
                                            <?php  } ?>
                                        </tbody>
                                    </table>     
                                    <?php include("paging2.php");  ?>                     
                                </div>
                                <!-- .table-responsive -->
                            </div>
                            <div class="tab-pane fade" id="due">
                                <!-- <h4>{User} due bill info goes here and each linked to a transaction form </h4> -->
                                <div class="table-responsive">
                                    <table class="table table-hover table-striped table-bordered table-condensed">
                                        <thead>
                                            <tr>
                                                <!-- <th>#</th> -->
                                                <th>Bill Date</th>
                                                <th>UNITS Consumed</th>
                                                <th>Due Date</th>
                                                <th>Amount</th>
                                                <th>DUES</th>
                                                <th>Payable</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 

                                            $id=$_SESSION['uid'];
                                            $query1 = "SELECT COUNT(*) FROM bill where uid={$id} AND status='PENDING' ";
                                            $result1 = mysqli_query($con,$query1);
                                            $row1 = mysqli_fetch_row($result1);
                                            $numrows = $row1[0];
                                            include("paging1.php");

                                            $result = retrieve_bills_due($_SESSION['uid'],$offset, $rowsperpage);
                                            // Initialising #
                                            $counter = 1;
                                            while($row = mysqli_fetch_assoc($result)){
                                            ?>
                                                <tr>
                                                    <form action="transact_bill.php" method="post">
                                                    <!-- <td height="40"><?php echo $counter ?></td> -->

                                                    <input type="hidden" name="bdate" value=<?php echo $row['bdate'] ?> >
                                                    <td td height="50"><?php echo $row['bdate'] ?></td>

                                                    <input type="hidden" name="units" value=<?php echo $row['units'] ?> >
                                                    <td><?php echo $row['units'] ?></td>

                                                    <input type="hidden" name="ddate" value=<?php echo $row['ddate'] ?> >
                                                    <td><?php echo $row['ddate'] ?></td>

                                                    <input type="hidden" name="amount" value=<?php echo $row['amount'] ?> >
                                                    <td><?php echo $row['amount'] ?></td>

                                                    <!-- <input type="hidden" name="" value=<?php echo $row[''] ?> > -->
                                                    <td><?php echo $row['dues'] ?></td>

                                                    <input type="hidden" name="payable" value=<?php echo $row['payable'] ?> >
                                                    <td><?php echo $row['payable'] ?></td>

                                                    <td>
                                                    <button class="btn btn-success form-control" data-toggle="modal"  data-target="#PAY">PAY</button>
                                                    <!--TRANSACT BILL MODAL -->
                                                    <div class="modal fade" id="PAY" tabindex="-1" role="dialog"  aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-sm">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                                                                    <h3 class="modal-title text-centre"><b>Bills Transaction</b></h3>
                                                                </div>
                                                                <div class="modal-body text-center">
                                                                <div class="row">
                                <input type="number" name="cardnumber" class="form-control form-group" placeholder="Enter Card Number" min="1000000000000000" max="9999999999999999" required >
                            </div>
                            <span class="row">
                                <label for="select" class="form-control col-md-6">Expiry Date
                                    <select name="month">
                                        <option>01</option>
                                        <option>02</option>
                                        <option>03</option>
                                        <option>04</option>
                                        <option>05</option>
                                        <option>06</option>
                                        <option>07</option>
                                        <option>08</option>
                                        <option>09</option>
                                        <option>10</option>
                                        <option>11</option>
                                        <option>12</option>
                                    </select>
                                    <select name="year">
                                        
                                        <option>23</option>
                                        <option>24</option>
                                        <option>25</option>
                                        <option>26</option>
                                        <option>27</option>
                                        <option>28</option>
                                        
                                    </select>
                                </label>
                                <input type="text" name="cvv" class="form-control form-group col-md-6" placeholder="CVV"  required>
                                 
                            </span>
                                                                    <h4>ARE YOU SURE?</h4>
                                                                    <p>Do it before <?php echo $row['ddate']; ?> or DUES will served!!</p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">LATER</button>
                                                                        <button type="submit" id="pay_bill" name="pay_bill" class="btn btn-success ">PAY</button>
                                                    </form> 
                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                </td>
                                                </tr>
                                            <?php 
                                                $counter=$counter+1;
                                            }
                                            ?>
                                        </tbody>

                                    </table>

                                <?php include("paging2.php");  ?>

                                </div><!-- ./table-responsive -->

                            </div> <!-- .tab-pane -->
                           
                        </div><!-- .tab-content -->

                    </div><!-- /.col-lg-12 -->
                    
                </div> <!-- /.row -->
               
            </div><!-- /.container-fluid -->
            

        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php 
    require_once("footer.php");
    require_once("js.php");
    ?>

</body>

</html>
