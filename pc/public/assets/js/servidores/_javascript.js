var TCNWN = TCNWN || {};

(function(){
	var Notifications = window.Notification;

	if(Notifications) {
		var notification = function() {
			var nw = new Notifications("Servidor sin servicio", {
				icon: "http://www.thecssninja.com/demo/web_notifications/icon.png",
				body: "",
				tag: ''
			});

			nw.addEventListener("show", function() {
				var audio = new Audio("messenger.mp3");
				audio.play();
			}, false);

			return nw;
		};

		TCNWN.gotMail = function() {
			TCNWN.permission(notification);
		};

		TCNWN.permission = function(callback) {
			Notifications.requestPermission(function(permission){
				if(permission === "granted") {
					callback();
				} else {
					alert("");
				}
			});
		};
	} else {
		if("webkitNotifications" in window) {
			alert("");
		} else {
			alert("");
		}
	}
})();
