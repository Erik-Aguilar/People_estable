<style media="screen">
  html {
    position: relative;
    min-height: 100%;
  }
  body {
    /* Margin bottom by footer height */
    margin-bottom: 60px;
  }
  .footer {
    position: absolute;
    bottom: 0;
    width: 100%;
    /* Set the fixed height of the footer here */
    height: 60px;
    #background-color: gray;
    color: : white
  }
</style>

<footer class="footer" >
<div class="container">
  <small>
  <ul class="nav nav-pills" role="tablist">
    <!--<li role="presentation" class="active"><a >Home <span class="badge">42</span></a></li>
    <li role="presentation" class="active"><a >Home <span class="badge">42</span></a></li>
    <li role="presentation"><a >Messages <span class="badge">3</span></a></li>
    <li role="presentation"><a >Messages <span class="badge">3</span></a></li>-->

<?php foreach($geshoy as $key => $value): ?>
  <li role="presentation" class="active">
    <a ><?php echo e($value->estatus); ?>

      <span class="badge"><?php echo e($value->total); ?></span>
    </a></li>
<?php endforeach; ?>
</ul>
</small>
</div>
</footer>
