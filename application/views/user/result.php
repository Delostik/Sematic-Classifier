<div class="container minh">
    <div class="row">
        <div class="col-md-9 col-md-push-3">
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Example List</div>
                <!-- Table -->
                <table class="table table-hover">
                    <?php 
                        if ($result)
                        {
                            foreach ($result as $row)
                            {
                                echo    "<tr><td>".
                                            $row['content']. 
                                        "</td></tr>";
                            }
                        }
                    ?>
                </table>
            </div>
        </div>
        <div class="col-md-3 col-md-pull-9">
            <div class="list-group">
                <a href="<?=base_url()?>user/result/0" class='list-group-item <?php echo ($type==0)?'active':'';?>' id="btn_addBook">
                    <span class="badge"><?=$overall['all']?></span>All</a>
                <a href="<?=base_url()?>user/result/1" class='list-group-item <?php echo ($type==1)?'active':'';?>' id="btn_addBook">
                    <span class="badge"><?=$overall['subj']?></span>Subjective</a>
                <a href="<?=base_url()?>user/result/2" class='list-group-item <?php echo ($type==2)?'active':'';?>' id="btn_addBook">
                    <span class="badge"><?=$overall['neutral']?></span>Neutral</a>
                <a href="<?=base_url()?>user/result/3" class='list-group-item <?php echo ($type==3)?'active':'';?>' id="btn_addBook">
                    <span class="badge"><?=$overall['obj']?></span>Objective</a>
                <a href="<?=base_url()?>user/result/4" class='list-group-item <?php echo ($type==4)?'active':'';?>' id="btn_addBook">
                    <span class="badge"><?=$overall['unknow']?></span>Unknown</a>
            </div>
            <br />

            
        </div>
    </div>
</div>
<div id="addBookPanel">
</div>
<div id="addCategoryPanel">
</div>
