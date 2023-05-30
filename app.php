<!DOCTYPE html>
<html>
<head>
    <!-- Other head elements -->

    <!-- Include Moment.js library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

    <!-- Your custom JavaScript code -->
<!--    <script src="your-script.js"></script>-->
</head>
<body>
<?php

if( $_GET['setting']){


?>
<!-- HTML content -->
<label for="startDate">Start Date:</label>
<input type="date" id="startDate" onchange="saveStartDate()">


<?php

}else{
    echo '<input type="hidden" id="startDate" onchange="saveStartDate()">';
}
?>
<label for="askDate">Ask Date:</label>
<input type="date" id="askDate" value="" onchange="Run()" " >

<!-- add a button abd call generateSchedule when clicked-->
<!--<button onclick="Run()">Generate Schedule</button>-->
<br>
<br>
<br>
<label for="status"  id="status" style="color: red;"></label>

<!-- Your JavaScript code -->
<script>

    function saveStartDate() {
        var startDateInput = document.getElementById('startDate');
        var startDateValue = startDateInput.value;
        localStorage.setItem('startDate', startDateValue);
    }


    function generateSchedule(startDate) {
        // Convert start date string to Moment.js object
        var startDateObj = moment(startDate, 'DD-MM-YYYY');

        // Initialize a list to hold the schedule
        var schedule = [];

        // Initialize a flag for working weekend
        var isWorkingWeekend = false;

        // Loop through each day of the year
        for (var i = 0; i < 365; i++) {
            // Calculate the current date
            var currentDate = startDateObj.clone().add(i, 'days');

            // Check if the current date is a weekend day
            if (currentDate.weekday() === 6 || currentDate.weekday() === 0) {
                // Check if the current week is a working week
                if (currentDate.isoWeek() % 2 === 0) {
                    // Set flag for working weekend
                    isWorkingWeekend = true;
                    schedule.push([currentDate.format('DD-MM-YYYY'), 'Δεν Δουλεύεις']);
                } else {
                    // Reset flag for working weekend
                    isWorkingWeekend = false;
                    schedule.push([currentDate.format('DD-MM-YYYY'), 'Δουλεύεις']);
                }
            } else {
                // If it's a weekday
                // If it's a working weekend, add the schedule accordingly
                if (isWorkingWeekend) {
                    if (
                        currentDate.weekday() === 0 ||
                        currentDate.weekday() === 2 ||
                        currentDate.weekday() === 4
                    ) {
                        schedule.push([currentDate.format('DD-MM-YYYY'), 'Πρωί']);
                    } else {
                        schedule.push([currentDate.format('DD-MM-YYYY'), 'Απόγευμα']);
                    }
                } else {
                    // If it's a non-working weekend, add the schedule accordingly
                    if (

                        currentDate.weekday() === 1 ||
                        currentDate.weekday() === 3
                    ) {
                        schedule.push([currentDate.format('DD-MM-YYYY'), 'Πρωί']);
                    } else {
                        schedule.push([currentDate.format('DD-MM-YYYY'), 'Απόγευμα']);
                    }
                }
            }
        }

        return schedule;
    }

    function main(askDate, startDate) {
        var schedule = generateSchedule(startDate);

        for (var i = 0; i < schedule.length; i++) {
            var day = schedule[i][0];
            var status = schedule[i][1];

            if (day === askDate) {
                return status;
            }
        }
    }

    function Run(){
        var startDateInput = document.getElementById('startDate');
        var savedStartDate = localStorage.getItem('startDate');
        if (savedStartDate) {
            startDateInput.value = savedStartDate;

        }


        // var startDate = '05-02-2023';
        var startDate = startDateInput.value;
        // change 2023-05-31 to 31-05-2023
        startDate = moment(startDate).format('DD-MM-YYYY');



        var askDate = document.getElementById('askDate').value;
        // chnage the format of the date
        askDate = moment(askDate).format('DD-MM-YYYY');
        var status = main(askDate, startDate);
        document.getElementById('status').innerHTML = status;
        if (status === 'Δουλεύεις' || status === 'Πρωί' || status === 'Απόγευμα') {
            document.getElementById('status').style.color = 'red';
            // make it bold
            document.getElementById('status').style.fontWeight = 'bold';
        } else {
            document.getElementById('status').style.color = 'green';

        }


        console.log(status);
        console.log(askDate);
        console.log( startDateInput.value);


    }



</script>
</body>
</html>
