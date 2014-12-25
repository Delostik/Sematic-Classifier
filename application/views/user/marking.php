<div class='container minh'>
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Paragraph</div>
                <!-- Table -->
                <table class="table table-hover">
                    <tr>
                        <td> 
                            <?php 
                                echo $example['example'];
                            ?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Marking Panel</div>
                <!-- Table -->
                <table class="table table-hover">
                    <?php 
                        foreach ($sentences as $row)
                        {
                            echo "<tr><td>". $row['content']. "</td></tr>";
                            echo "<tr><td style='text-align:right'>
                                        <button type='button' class='btn btn-success'>Subjective</button>
                                        <button type='button' class='btn btn-info'>Neutral</button>
                                        <button type='button' class='btn btn-warning'>Objective</button>
                                  </td></tr>";
                        }
                    ?>
                </table>
            </div>
        </div>
    </div>
</div>