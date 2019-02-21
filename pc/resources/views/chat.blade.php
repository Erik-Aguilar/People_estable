@extends('layout.layout')

@section('content')
<script src="https://unpkg.com/vue"></script>

<div class="panel-body">
    <chat inline-template>

    You are logged in!

    <hr>

    <h2>Write something to all users</h2>
    <input type="text" class="form-control" placeholder="something" required="required" v-model="newMsg" @keyup.enter="press">

    <hr>
    <h3>Messages</h3>

    <ul v-for="post in posts">
    <b>@{{ post.username }} says:</b> @{{ post.message }}</li>
    </ul>

    </chat>
</div><!-- panel-body -->

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
