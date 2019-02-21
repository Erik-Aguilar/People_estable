@extends('layout.operaciones.PruebaAudio')
@section('content')


<script type="text/javascript" language="javascript" src="jquery.js"></script>
<script type="text/javascript" src="jquery.js"></script>
<script src= "Scripts/jquery-1.5.2.js" type="text/javascript"></script>
<script src="js/bootstrap.min.js"></script>



<code><script src="jquery.js"></script>
<script src="mediaelement-and-player.min.js"></script>
<link rel="stylesheet" href="mediaelementplayer.css" /></code>




<div class="">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title"> Pueba de Audio </h3>
      </div>
      <div class="panel-body" style="overflow: auto;" >  

        
      <div>
        <audio controls>
          <source src="http://192.168.10.14:1234/assets/audio/red.mp3" type="audio/mpeg">
        </audio>

        <a href="http://192.168.10.14:1234/assets/audio/love.mp3" type="button" class="glyphicon btn-lg glyphicon-download-alt" download="AudioPrueba.mp3"></a>
        


      </div>





      </div>

    </div>
  </div>
</div>




@stop

<script type="text/javascript" language="javascript" src="jquery.js"></script>
<script type="text/javascript" src="jquery.js"></script>
