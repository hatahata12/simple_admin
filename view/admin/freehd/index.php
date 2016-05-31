<?php
    $this->setLayoutVal('title', '管理画面');
?>
<div class="row">
<div class="col-md-12 panel-warning">
    <div class="content-box-header panel-heading">
        <div class="panel-title big-font">空き容量確認</div>
        <div class="panel-options">
            <a data-rel="collapse" href=""><i
                class="glyphicon glyphicon-refresh"></i></a>
        </div>
    </div>
    <div class="content-box-large box-with-header">
        <p style="font-size:30pt"><?php
        $size = str_replace("\t", '', $data[1]);
        $size = str_replace(array("\n", "\r\n", "\r"), '', $size);
        $size = preg_replace('/\s+/', ' ', $size);
        echo explode(' ', $size)[4];
        ?></p>
    </div>
</div>
</div>
<script type="text/javascript">
$(function(){

});
</script>
