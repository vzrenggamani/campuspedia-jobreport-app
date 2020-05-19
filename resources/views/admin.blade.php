<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS-->
    <link defer rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
     
    <title>Daily Reports App</title>

</head>
<body>

<div class="container" style="margin-top: 50px;">

<h4 class="text-center">Daily Job Reporting Admin Dashboard</h4><br>

    <h5>Reports</h5>
    <table class="table table-bordered">
        <tr>
            <th>Name</th>
            <th>Date Submit</th>
            <th width="180" class="text-center">Action</th>
        </tr>
        <tbody id="tbody">

        </tbody>
    </table>
</div>

<!-- Update Model -->
<form action="" method="POST" class="users-update-record-model form-horizontal">
    <div id="update-modal" data-backdrop="static" data-keyboard="false" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="width:200%;">
            <div class="modal-content" style="overflow: hidden;">
                <div class="modal-header">
                    <h4 class="modal-title" id="custom-width-modalLabel">Informasi Pekerjaan</h4>
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">×
                    </button>
                </div>
                <div class="modal-body" id="updateBody">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light"
                            data-dismiss="modal">Close
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
    firebase.database().ref('reporting/').on('value', function (snapshot) {
        var value = snapshot.val();
        var htmls = [];
        $.each(value, function (index, value) {
            if (value) {
                htmls.push('<tr>\
        		<td>' + value.name + '</td>\
        		<td>' + value.timestamp + '</td>\
        		<td><button data-toggle="modal" data-target="#update-modal" class="btn btn-info updateData" data-id="' + index + '">View data</button>\
        	</tr>');
            }
            lastIndex = index;
        });
        $('#tbody').html(htmls);
        $("#submitUser").removeClass('disabled');
    });

    // Update Data
    var updateID = 0;
    $('body').on('click', '.updateData', function () {
        updateID = $(this).attr('data-id');
        firebase.database().ref('reporting/' + updateID).once('value', function (snapshot) {
            var values = snapshot.val();
            console.log(values)
            var updateData = '<div class="form-group">\
		        <label for="first_name" class="col-md-12 col-form-label font-weight-bold">Name</label>\
		        <div class="col-md-12">\
		            <input id="first_name" type="text" class="form-control-plaintext" name="name" value="'+ values.name +'">\
		        </div>\
            </div>\
            <div class="form-group">\
		        <label for="first_name" class="col-md-12 col-form-label font-weight-bold">Nomor Internship</label>\
		        <div class="col-md-12">\
		            <input id="first_name" type="text" class="form-control-plaintext" name="name" value="'+ values.uid + '">\
		        </div>\
            </div>\
            <div class="form-group">\
		        <label for="first_name" class="col-md-12 col-form-label font-weight-bold">Pekerjaan</label>\
		        <div class="col-md-12">\
		            <input id="first_name" type="text" class="form-control-plaintext" name="name" value="'+ values.today_jobs +'">\
		        </div>\
            </div>\
            <div class="form-group">\
		        <label for="first_name" class="col-md-12 col-form-label font-weight-bold">Deskripsi</label>\
		        <div class="col-md-12">\
		            <input id="first_name" type="text" class="form-control-plaintext" name="name" value="'+ values.today_jobs_problems +'">\
		        </div>\
            </div>\
            <div class="form-group">\
		        <label for="first_name" class="col-md-12 col-form-label font-weight-bold">Waktu Bekerja </label>\
		        <div class="col-md-12">\
		            <input id="first_name" type="text" class="form-control-plaintext" name="name" value="'+ values.workingtime_start + ' until ' + values.workingtime_end +'">\
		        </div>\
            </div>\
            <div class="form-group">\
		        <label for="first_name" class="col-md-12 col-form-label font-weight-bold">Lama Jam Kerja (bersih)</label>\
		        <div class="col-md-12">\
		            <input id="first_name" type="text" class="form-control-plaintext" name="name" value="'+ values.workhour_net +'">\
		        </div>\
            </div>\
            <div class="form-group">\
		        <label for="first_name" class="col-md-12 col-form-label font-weight-bold">Tanggal laporan dibuat</label>\
		        <div class="col-md-12">\
		            <input id="first_name" type="text" class="form-control-plaintext" name="name" value="'+ values.timestamp +'">\
		        </div>\
            </div>';

            $('#updateBody').html(updateData);
        });
    });

</script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>
</html>