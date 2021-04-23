<div class="table-responsive box-table mt-3">

    <table class="table table-bordered">

        <thead>

            <tr>

                <th><?= $lang['th']['order_summary']; ?></th>
                <th>Purchased On</th>
                <th>Seller Name</th>
                <th>Progress</th>
                <th>Action</th>

            </tr>

        </thead>

        <tbody>
            <tr>
                <th scope="row">Learn PSD to HTML : Responsive Portfolio Website Design</th>
                <td>March 15, 2021</td>
                <td><a href="#">Ayan Mukhopadhyay</a></td>
                <td>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 49%;" aria-valuenow="49"
                            aria-valuemin="0" aria-valuemax="100">49%</div>
                    </div>
                </td>
                <td><a class="btn btn-success" href="manage_orders/start-class.php" role="button">Resume Class</a></td>
            </tr>
            <tr>
                <th scope="row">Learn PSD to HTML : Responsive Portfolio Website Design</th>
                <td>March 15, 2021</td>
                <td><a href="#">Ayan Mukhopadhyay</a></td>
                <td>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 49%;" aria-valuenow="49"
                            aria-valuemin="0" aria-valuemax="100">49%</div>
                    </div>
                </td>
                <td><a class="btn btn-success" href="manage_orders/start-class.php" role="button">Resume Class</a></td>
            </tr>
            <tr>
                <th scope="row">Learn PSD to HTML : Responsive Portfolio Website Design</th>
                <td>March 15, 2021</td>
                <td><a href="#">Ayan Mukhopadhyay</a></td>
                <td>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 49%;" aria-valuenow="49"
                            aria-valuemin="0" aria-valuemax="100">49%</div>
                    </div>
                </td>
                <td><a class="btn btn-success" href="manage_orders/start-class.php" role="button">Resume Class</a></td>
            </tr>
            <tr>
                <th scope="row">Learn PSD to HTML : Responsive Portfolio Website Design</th>
                <td>March 15, 2021</td>
                <td><a href="#">Ayan Mukhopadhyay</a></td>
                <td>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 49%;" aria-valuenow="49"
                            aria-valuemin="0" aria-valuemax="100">49%</div>
                    </div>
                </td>
                <td><a class="btn btn-success" href="manage_orders/start-class.php" role="button">Resume Class</a></td>
            </tr>
            <tr>
                <th scope="row">Learn PSD to HTML : Responsive Portfolio Website Design</th>
                <td>March 15, 2021</td>
                <td><a href="#">Ayan Mukhopadhyay</a></td>
                <td>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 49%;" aria-valuenow="49"
                            aria-valuemin="0" aria-valuemax="100">49%</div>
                    </div>
                </td>
                <td><a class="btn btn-success" href="manage_orders/start-class.php" role="button">Resume Class</a></td>
            </tr>


        </tbody>
    </table>

    <?php
         
   if($count_orders == 0){             
      echo "<center>
      <h3 class='pb-4 pt-4'>
         <i class='fa fa-meh-o'></i> {$lang['buying_orders']['no_all']}
      </h3>
      </center>";
   }

?>

</div>