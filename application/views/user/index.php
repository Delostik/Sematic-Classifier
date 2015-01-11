
<script>
    $(document).ready(function() {
    	var data = [
    	            ['Marked', <?=$overall['marked']?>],['Unmarked', <?=$overall['notyet']?>], ['Processing', <?=$overall['processing']?>]
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
        <div class="col-md-4">
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
        <div class="col-md-8">
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Latest news</div>
                <!-- Table -->
                <table class="table table-hover">
                    <tr>
                        <td>
                            <h4><strong>Subjective sentence: 表达评论者主观意见或者情感的语句</strong></h3>
                                <p>(1)The phone is great for the price.</p>
                                <p>(2)You can imagine how much of a hassle and inconvenience this is as a student or even a working professional.</p>
                                <p>(3)Google has an amazing suite of applications.</p>
                                <p>(4)If it broke today, I would order a new one tomorrow.</p>
                            <h4><strong>Objective sentence : 描述商品特征(例如物流、服务、屏显等)的客观语句，描述客观事实，不包含任何个人主观情感和意见。</strong></h4>
                                <p>(1)The 3 times this has happened, the phone will not charge, will not turn on, and the battery is not removable so there's really nothing you can do about it until it decides to turn on.</p>
                                <p>(2)The battery lasted longer than the Nexus.</p>
                            <!-- <h4><strong>Neutral sentence : 与商品不相关的客观描述。</strong></h4>
                                <p>(1)As a college student, that just happens.</p>
                                <p>(2)I purchased this for my mom.</p>
                                 -->
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    
    </div>
</div>
