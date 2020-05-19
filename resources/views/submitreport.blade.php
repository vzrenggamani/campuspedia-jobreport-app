<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <title>Daily Reports App</title>

</head>

<body>

    <div class="container" style="margin-top: 50px;">

        <h4 class="text-center">Daily Job Reporting</h4><br>

        <h5>Add new reports</h5>
        <div class="card card-default">
            <div class="card-body">
                <form id="addReport" class="users-update-record-model form-horizontal" method="POST" action="">
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
                        <textarea id="today_jobs_problems" type="text" name="today_jobs_desc" class="form-control"
                            form="addCustomer" value="Masalah hari ini">Coba ceritain kendala hari ini dong...</textarea>
                    </div>

                    <div class="form-group">
                        <label for="workingtime_start" class="col-md-12 col-form-label">Hari ini, kamu mulai kerja jam
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
                        <input type="checkbox" id="breaktime-afternoon" class="breaktimes" value="Sore">
                        <label for="breaktime-afternoon" class="">Break Sore (15:00 - 16:00)</label>
                        <br>
                        <input type="checkbox" id="breaktime-night" class="breaktimes" value="Malam">
                        <label for="breaktime-night" class="">Break Malam (18:00 - 19:00)</label>

                    </div>

                    <button id="sendReport" type="button" class="btn btn-primary mb-2">Add New Reports</button>
                </form>
            </div>
        </div>

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

        // Add Data
        $('#sendReport').on('click', function () {

            var start = Date.parse($("input#workingtime_start").val());
            var end = Date.parse($("input#workingtime_end").val());

            let breaktime = 0
            $('.breaktimes').each(function() {
                if (this.checked) {
                    breaktime += 1
                }
            });
            console.log("Total Breaktime used is " + breaktime)

            totalHours = 0;
            nettHours = 0;
            if (start < end) {
                totalHours = Math.floor((end - start) / 1000 / 60 / 60);
                nettHours = totalHours - breaktime;
            }
            
            var name = $("#name").val();
            var uid = $("#uid").val();
            var today_jobs = $("#today_jobs").val();
            var today_jobs_problems = $("#today_jobs_problems").val();
            var workingtime_start = $("#workingtime_start").val();
            var workingtime_end = $("#workingtime_end").val();
            var breaktimes = breaktime;
            var workhour_total = totalHours;
            var workhour_net = nettHours;

            var userID = lastIndex + 1;
            firebase.database().ref('reporting/').push({
                name: name,
                uid: uid,
                today_jobs: today_jobs,
                today_jobs_problems: today_jobs_problems,
                workingtime_start: workingtime_start,
                workingtime_end: workingtime_end,
                breaktimes: breaktimes,
                wokrhour_total: workhour_total,
                workhour_net: workhour_net,
                timestamp: Date()
            }, function(error){
                if (error) {
                    alert("Could not send the report! Please try again")
                } else {
                    alert("Report Submitted. Thank you")
                }
            });

            // Reassign lastID value
            lastIndex = userID;
            $("#addReport input").val("");
        });

    </script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>
