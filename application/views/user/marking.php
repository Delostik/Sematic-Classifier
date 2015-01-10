<script>
    var res = new Array();
    $(document).ready(function (){
        $(".btn").click(function() {
            if (!$($(this).siblings('td .btn')[0]).attr('disabled')) {
         	   $(this).siblings('td .btn').attr('disabled', 'disabled').attr('class', 'btn btn-sm btn-default');
         	   res[$(this).attr('id')] = $(this).text();
            }
            else {
            	child = $(this).parent().children();
            	$(child[0]).removeAttr('disabled').attr('class', 'btn btn-sm btn-success');
            	//$(child[1]).removeAttr('disabled').attr('class', 'btn btn-sm btn-warning');
            	$(child[1]).removeAttr('disabled').attr('class', 'btn btn-sm btn-danger');
            	res[$(this).attr('id')] = '';
            }
            console.log(res);
        });

        $('#submit_btn').click(function (){
            var sum = 0, i;
            for (i = 0; i < <?=count($sentences)?>; i++)
                if (!res[i]) {
                    alert('You must mark all items!');
                    return;
                }
        	$.ajax({
        		url: '<?=base_url()?>user/do_marking',
        		type: 'POST',
        		data: {'data': res, 'rid': <?=$sentences[0]['rid']?>, 'eid': <?=$example['eid']?>},
        		dataType: 'text',
        		error: function(data) {
            		alert('Connect server failed.')},
        		success: function(data) {
        		    if (data == 'already') {
     		    	   alert('You have already marked this example!');
      		    	   window.location.assign('<?=base_url()?>user/marking');
        		    }
        		    else if (data == 'incomplete') {
            		    alert('You must mark all items!');
        		    }
        		    else {
        		    	window.location.assign('<?=base_url()?>user/marking');
        		    }
            		
                }
    		});
        })
    });
</script>

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
                        $id = 0;
                        foreach ($sentences as $row)
                        {
                            echo "<tr><td style='font-size: 18px'>". $row['content']. "</td></tr>";
                            echo "<tr><td style='text-align:right'>
                                        <button type='button' class='btn btn-sm btn-success' id=". $id. ">Subjective</button>".
                                        //<button type='button' class='btn btn-sm btn-warning' id=". $id. ">Neutral</button>
                                        "　<button type='button' class='btn btn-sm btn-danger' id=". $id. ">Objective</button>
                                  </td></tr>";
                            $id = $id + 1;
                        }
                    ?>
                </table>
                
            </div>
            <div style='text-align:right'>
                <button type='button' class='btn btn-primary btn-lg' id='submit_btn'>Submit</button>
            </div>
        </div>
    </div>
</div>
