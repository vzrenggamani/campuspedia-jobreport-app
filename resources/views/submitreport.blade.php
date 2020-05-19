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
                        <input id="workingtime_start" type="time" class="form-control" name="workstart"
                            placeholder="HH:MM">
                    </div>

                    <div class="form-group">
                        <label for="workingtime_end" class="col-md-12 col-form-label">Selesainya jam berapa?</label>
                        <input id="workingtime_end" type="time" class="form-control" name="workend"
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

        let breaktime = 0,
            nettHour = 0,
            totalWork = 0

        // Submit Report Function
        $('#sendReport').on('click', function () {

            // Get values from the forms
            start = $("#workingtime_start").val()
            end = $("#workingtime_end").val()


            // Start Calculation for the work hours and breaktimes
            breakTimeCalculator(start, end)
            workTime_total(start, end)
            workTime_nett(totalWork, breaktime)

            /* if (breaktime != breaktime_formcheck) {
                alert("Waktu istirahat dan pilihan istirahatmu tidak cocok!")
                return;
            } */

            // Data Object to be pushed into firebase
            reportDetails = {
                name: $("name").val(),
                uid : $("#uid").val(),
                today_jobs : $("#today_jobs").val(),
                today_jobs_problems : $("#today_jobs_problems").val(),
                workingtime_start : $("#workingtime_start").val(),
                workingtime_end : $("#workingtime_end").val(),
                breaktimes : breaktime,
                workhour_total : totalHours,
                workhour_net : nettHours,
            }

            // Push data to the firebase
            //firebasePush(reportDetails)

            // Prints data to the consoles for debugging
            console.log("Mulai kerja jam: " + start)
            console.log("Berhenti kerja jam: " + end)
            console.log("Breaktime selama: " + breaktime)
            console.log("==================")
            console.log("Total Worktime: " + totalWork)
            console.log("Net Hour: " + nettHour)
            console.log(reportDetails)

            // Cleans Input Forms
            $("#addReport input").val("");
        });

        function breakTimeCalculator(startTime, endTime) {
            // Kerja sebelum jam 12AM sampai diatas jam 7PM
            if (startTime < "12:00" && endTime > "19:00") {
                breaktime = 3
            }
            // Kerja sebelum jam 12AM sampai diatas jam 5PM
            else if (startTime < "12:00" && endTime > "17:00") {
                breaktime = 2
            }
            // Kerja sebelum jam 12AM sampai diatas jam 1PM
            else if (startTime < "12:00" && endTime > "13:00") {
                breaktime = 1
            }
            // Kerja sesudah jam 1PM & jam 4PM sampai diatas jam 7 PM
            else if ((startTime > "13:00" && startTime > "16:00") && endTime > "19:00") {
                breaktime = 2
            }
            // Kerja sesudah jam 1PM & jam 4PM sampai diatas jam 5 PM
            else if ((startTime > "13:00" && startTime > "16:00") && endTime > "17:00") {
                breaktime = 2
            }
            // Kerja sesudah jam 5PM & jam 6PM sampai diatas jam 7 PM
            else if ((startTime > "17:00" && startTime > "18:00") && endTime > "19:00") {
                breaktime = 2
            }
            return breaktime;
        }

        function workTime_nett(totalWork, breaktime) {
            nettHour = totalWork - breaktime

            return nettHour;
        }

        function timeStringToFloat(time) {
            var hoursMinutes = time.split(/[.:]/);
            var hours = parseInt(hoursMinutes[0], 10);
            var minutes = hoursMinutes[1] ? parseInt(hoursMinutes[1], 10) : 0;
            return hours + minutes / 60;
        }

        function workTime_total(startTime, endTime) {
            timeWork_start = timeStringToFloat(startTime)
            timework_end = timeStringToFloat(endTime)
            totalWork = timework_end - timeWork_start

            return totalWork;
        }

        function firebasePush(reports) {
            firebase.database().ref('reporting/').push(reportsDetails,
            function (error) {
                if (error) {
                    alert("Could not send the report! Please try again")
                } else {
                    alert("Report Submitted. Thank you")
                }
            });
        }

    </script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</body>

</html>
