@extends('layout.layout')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">
				<div class="panel-heading">Home</div>

				<div class="panel-body" id="test">
					You are using bootstrap
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

<script>
if(typeof(EventSource) !== "undefined") {
    var source = new EventSource(" {{ url('/test') }}");
    source.onmessage = function(event) {
        document.getElementById("test").innerHTML = event.data + "<br>";
    };
} else {
    document.getElementById("result").innerHTML = "Sorry, your browser does not support server-sent events...";
}
</script>
