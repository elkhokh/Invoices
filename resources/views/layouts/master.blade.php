<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
		<meta name="Author" content="Spruko Technologies Private Limited">
		<meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4"/>
		@include('layouts.head')
	</head>

	<body class="main-body app sidebar-mini">
		<!-- Loader -->
		<div id="global-loader">
			<img src="{{URL::asset('assets/img/loader.svg')}}" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->
		@include('layouts.main-sidebar')
		<!-- main-content -->
		<div class="main-content app-content">
			@include('layouts.main-header')
			<!-- container -->
			<div class="container-fluid">
				@yield('page-header')
				@yield('content')
				@include('layouts.sidebar')
				@include('layouts.models')
            	@include('layouts.footer')
				@include('layouts.footer-scripts')
	</body>
</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
function loadNotifications() {
    $.get("{{ route('notifications.unread') }}", function(data) {
        $("#notifications_count").text("لديك " + data.count + " إشعار غير مقروء");
        let list = $("#unreadNotifications");
        list.empty();
        if (data.count > 0) {
            data.notifications.forEach(function (n) {
                let item = `
                    <a class="d-flex p-3 border-bottom"
                    href="/invoices/${n.id}">
                        <div class="notifyimg bg-pink">
                            <i class="la la-file-alt text-white"></i>
                        </div>
                        <div class="mr-3">
                            <h5 class="notification-label mb-1">
                                ${n.title} - ${n.user}
                            </h5>
                            <div class="notification-subtext">${n.time}</div>
                        </div>
                    </a>`;
                list.append(item);
            });
        } else {
            list.html('<div class="p-3 text-center text-muted">لا توجد إشعارات جديدة</div>');
        }
    });
}

loadNotifications();
setInterval(loadNotifications, 5000);
</script>

