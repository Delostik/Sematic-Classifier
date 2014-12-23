
<script>
    $(document).ready(function() {
    	var data = [
    	            ['Heavy Industry', 12],['Retail', 9], ['Light Industry', 14], 
    	            ['Out of home', 16],['Commuting', 7], ['Orientation', 9]
    	          ];
        $.jqplot ('chart', [data], { 
            seriesDefaults: {
         	   renderer: $.jqplot.PieRenderer, 
         	   rendererOptions: {
          		   showDataLabels: true
        	   }
            }, 
        	legend: { 
            	show:true,
            	location: 'e' 
            }
        });
        
    });
</script>

<div class="container minh">
    <div class="row">
        <div class="col-md-5">
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Percentage</div>
                <!-- Table -->
                <table class="table table-hover">
                    <tr>
                        <td> 
                            <div id="chart" style="margin: 0 auto;"></div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-md-7">
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Latest news</div>
                <!-- Table -->
                <table class="table table-hover">
                </table>
            </div>
        </div>
    
    </div>
</div>
