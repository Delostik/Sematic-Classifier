<div class='container minh'>
    <div class="row">
        <div class="col-md-2"></div>   
        <div class="col-md-8">
            <div class="panel panel-default">
                <!-- Table -->
                <style>
                    td, th {
                    	text-overflow: ellipsis;
                    	overflow: hidden;
                    	white-space:nowrap;
                    }
                </style>
                <table class="table table-hover" style="table-layout:fixed;">
                    <thead>
                            <th width="70%" class='center'>Summary (<?php echo $contribution?>)</th>   
                            <th width="30%" class='center'>Mark Date</th>
                    </thead>
                    <?php 
                        if ($markRecord)
                        {
                            foreach ($markRecord as $row)
                            {
                                echo "<tr><td>". $row['content']. "</td><td class='center'>". $row['time']. "</td></tr>";
                            }
                        }
                    ?>
                </table>
            </div>
        </div>
     </div>
</div>