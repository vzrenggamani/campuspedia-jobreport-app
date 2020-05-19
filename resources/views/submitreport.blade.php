<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <title>Laravel RealTime CRUD Using Google Firebase</title>

</head>

<body>

    <div class="container" style="margin-top: 50px;">

        <h4 class="text-center">Laravel RealTime CRUD Using Google Firebase</h4><br>

        <h5># Add Customer</h5>
        <div class="card card-default">
            <div class="card-body">
                <form id="addCustomer" class="users-update-record-model form-horizontal" method="POST" action="">
                    <div class="form-group">
                        <label for="name" class="col-md-12 col-form-label">Name</label>
                        <input id="name" type="text" class="form-control" name="name" placeholder="Name" required
                            autofocus>
                    </div>

                    <div class="form-group">
                        <label for="uid" class="col-md-12 col-form-label">Nomor Internship</label>
                        <input id="uid" type="text" class="form-control" name="uid" placeholder="Nomor Internship kamu" required
                            autofocus>
                    </div>

                    <div class="form-group">
                        <label for="today_jobs" class="col-md-12 col-form-label">Apa yang kamu kerjakan hari ini?</label>
                        <input id="today_jobs" type="text" class="form-control" name="today jobs"
                            placeholder="Apa aja nih....">
                    </div>

                    <div class="form-group">
                        <label for="today_jobs_problems" class="col-md-12 col-form-label">Deskripsi hari ini</label>
                        <input id="today_jobs_problems" type="text" class="textarea form-control" name="today jobs struggle"
                            placeholder="Coba ceritain kendala hari ini dong...">
                    </div>

                    <div class="form-group">
                        <label for="workingtime_start" class="col-md-12 col-form-label">Hari ini, amu mulai kerja jam
                            berapa?</label>
                        <input id="workingtime_start" type="datetime-local" class="form-control" name="workstart"
                            placeholder="HH:MM">
                    </div>

                    <div class="form-group">
                        <label for="workingtime_end" class="col-md-12 col-form-label">Selesainya jam berapa?</label>
                        <input id="workingtime_end" type="datetime-local" class="form-control" name="workend"
                            placeholder="HH:MM">
                    </div>

                    <div class="form-group">
                        <label class="col-md-12 col-form-label ">Kamu Pastinya istirahat dong? Jam berapa kalo boleh
                            tau</label>

                        <input type="checkbox" id="breaktime-noon" class="breaktimes" value="Siang">
                        <label for="breaktime-noon" class="">Break Siang (12:00 - 13:00)</label>
                        <br>
                        <input type="checkbox" id="breaktime-noon" class="breaktimes" value="Sore">
                        <label for="breaktime-afternoon" class="">Break Sore (15:00 - 16:00)</label>
                        <br>
                        <input type="checkbox" id="breaktime-noon" class="breaktimes" value="Malam">
                        <label for="breaktime-night" class="">Break Malam (18:00 - 19:00)</label>

                    </div>

                    <button id="sendReport" type="button" class="btn btn-primary mb-2">Submit</button>
                </form>
            </div>
        </div>

        <br>

        <h5># Customers</h5>
        <table class="table table-bordered">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th width="180" class="text-center">Action</th>
            </tr>
            <tbody id="tbody">

            </tbody>
        </table>
    </div>

    <!-- Update Model -->
    <form action="" method="POST" class="users-update-record-model form-horizontal">
        <div id="update-modal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1"
            role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="width:55%;">
                <div class="modal-content" style="overflow: hidden;">
                    <div class="modal-header">
                        <h4 class="modal-title" id="custom-width-modalLabel">Update</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                        </button>
                    </div>
                    <div class="modal-body" id="updateBody">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-dismiss="modal">Close
                        </button>
                        <button type="button" class="btn btn-success updateCustomer">Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Delete Model -->
    <form action="" method="POST" class="users-remove-record-model">
        <div id="remove-modal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1"
            role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered" style="width:55%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="custom-width-modalLabel">Delete</h4>
                        <button type="button" class="close remove-data-from-delete-form" data-dismiss="modal"
                            aria-hidden="true">×
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Do you want to delete this record?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect remove-data-from-delete-form"
                            data-dismiss="modal">Close
                        </button>
                        <button type="button" class="btn btn-danger waves-effect waves-light deleteRecord">Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>


    {{--Firebase Tasks--}}
    <script src="https://code.jquery.com/jquery-3.4.0.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.10.1/firebase.js"></script>
    <script>
        // Initialize Firebase
        var config = {
            apiKey: "{{ config('services.firebase.apiKey') }}",
            authDomain: "{{ config('services.firebase.authDomain') }}",
            databaseURL: "{{ config('services.firebase.databaseURL') }}",
            storageBucket: "{{ config('services.firebase.storageBucket') }}",
        };
        firebase.initializeApp(config);

        var database = firebase.database();

        var lastIndex = 0;

        // Get Data
        firebase.database().ref('customers/').on('value', function (snapshot) {
            var value = snapshot.val();
            var htmls = [];
            $.each(value, function (index, value) {
                if (value) {
                    htmls.push('<tr>\
        		<td>' + value.name + '</td>\
        		<td>' + value.email + '</td>\
        		<td><button data-toggle="modal" data-target="#update-modal" class="btn btn-info updateData" data-id="' +
                        index + '">Update</button>\
        		<button data-toggle="modal" data-target="#remove-modal" class="btn btn-danger removeData" data-id="' +
                        index + '">Delete</button></td>\
        	</tr>');
                }
                lastIndex = index;
            });
            $('#tbody').html(htmls);
            $("#submitUser").removeClass('desabled');
        });

        // Add Data
        $('#sendReport').on('click', function () {

            
            var values = $("#addCustomer").serializeArray();
            var name = values[0].value;
            var email = values[1].value;
            var todayJob = values[2].value;
            var userID = lastIndex + 1;

            console.log(values);

            firebase.database().ref('customers/' + userID).set({
                name: name,
                email: email,
            });

            // Reassign lastID value
            lastIndex = userID;
            $("#addCustomer input").val("");
        });

        // Update Data
        var updateID = 0;
        $('body').on('click', '.updateData', function () {
            updateID = $(this).attr('data-id');
            firebase.database().ref('customers/' + updateID).on('value', function (snapshot) {
                var values = snapshot.val();
                var updateData = '<div class="form-group">\
		        <label for="first_name" class="col-md-12 col-form-label">Name</label>\
		        <div class="col-md-12">\
		            <input id="first_name" type="text" class="form-control" name="name" value="' + values.name + '" required autofocus>\
		        </div>\
		    </div>\
		    <div class="form-group">\
		        <label for="last_name" class="col-md-12 col-form-label">Email</label>\
		        <div class="col-md-12">\
		            <input id="last_name" type="text" class="form-control" name="email" value="' + values.email + '" required autofocus>\
		        </div>\
		    </div>';

                $('#updateBody').html(updateData);
            });
        });

        $('.updateCustomer').on('click', function () {
            var values = $(".users-update-record-model").serializeArray();
            var postData = {
                name: values[0].value,
                email: values[1].value,
            };

            var updates = {};
            updates['/customers/' + updateID] = postData;

            firebase.database().ref().update(updates);

            $("#update-modal").modal('hide');
        });

        // Remove Data
        $("body").on('click', '.removeData', function () {
            var id = $(this).attr('data-id');
            $('body').find('.users-remove-record-model').append('<input name="id" type="hidden" value="' + id +
                '">');
        });

        $('.deleteRecord').on('click', function () {
            var values = $(".users-remove-record-model").serializeArray();
            var id = values[0].value;
            firebase.database().ref('customers/' + id).remove();
            $('body').find('.users-remove-record-model').find("input").remove();
            $("#remove-modal").modal('hide');
        });
        $('.remove-data-from-delete-form').click(function () {
            $('body').find('.users-remove-record-model').find("input").remove();
        });

    </script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>
