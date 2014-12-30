<div class='container minh'>
    <div class="row">
        <div class="col-md-2"></div>   
        <div class="col-md-8">
            <div class="panel panel-default">
                <!-- Table -->
                <style>
                    td, th {
                    	text-align: center;
                    }
                </style>
                <table class="table table-hover">
                    <thead>
                            <th width="70%">Username</th>   
                            <th width="30%">Contributions</th>
                    </thead>
                    <?php 
                        foreach ($users as $row)
                        {
                            echo "<tr><td>". $row['userName']. "</td><td>". $row['contribution']. "</td></tr>";
                        }
                    ?>
                </table>
            </div>
        </div>
     </div>
</div>