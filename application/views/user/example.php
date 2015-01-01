<script>
    function upload() {
        $("#batch_form").submit();
        //window.location.assign("<?=base_url()?>user/example");
    }
</script>

<div class='container minh'>
    <div class="row">
        <div class="col-md-2">
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Overview</div>
                <!-- Table -->
                <table class="table table-hover center">
                    <tr>
                        <td>Total Comments</td>
                        <td><?=$overall['comments']?></td>
                    </tr>
                    <tr>
                        <td>Total Examples</td>
                        <td><?=$overall['marked']+$overall['processing']+$overall['notyet']?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="col-md-10">
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Add Examples</div>
                <!-- Table -->
                <form action="<?=base_url()?>user/do_addExample" method="post">
                    <table class="table">
                        <tr>
                            <td> 
                                <textarea class="form-control" rows="6" name='text'></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td style='text-align:right'>
                                <button type="submit" class="btn btn-primary">Add Example</button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <br />
            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Batch add</div>
                <!-- Table -->
                <form action="<?=base_url()?>user/batch" method="post" accept-charset="utf-8" enctype="multipart/form-data" id="batch_form">
                    <table class="table">
                        <tr>
                            <td> 
                                <button type="button" class="btn btn-primary">Batch Add</button>
                                <input type="file" name="userfile" size="20" style="opacity:0;position:relative;width:91px;height:34px;top:-34px;" onchange="javascript:upload();"/>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>