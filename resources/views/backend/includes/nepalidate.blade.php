<script
src="https://nepalidatepicker.sajanmaharjan.com.np/nepali.datepicker/js/nepali.datepicker.v4.0.4.min.js"
    type="text/javascript"></script>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize Nepali Datepicker for "Admission Date" field
        var admissionInput = document.getElementById("admission-datepicker");
        if (admissionInput) {
            admissionInput.nepaliDatePicker({
                dateFormat: "YYYY-MM-DD",
                ndpYear: true,
                ndpMonth: true,
                ndpYearCount: 200
            });
        }

        // Initialize Nepali Datepicker for "Date of Birth" field
        var dobInput = document.getElementById("dob-datepicker");
        if (dobInput) {
            dobInput.nepaliDatePicker({
                dateFormat: "YYYY-MM-DD",
                ndpYear: true,
                ndpMonth: true,
                ndpYearCount: 200
            });
        }


        // Initialize Nepali Datepicker for another field
        var nepaliInput = document.getElementById("nepali-datepicker");
        if (nepaliInput) {
            nepaliInput.nepaliDatePicker({
                dateFormat: "YYYY-MM-DD",
                ndpYear: true,
                ndpMonth: true,
                ndpYearCount: 200
            });
        }
        // Initialize Nepali Datepicker for another field
        var nepaliInput2 = document.getElementById("nepali-datepicker2");
        if (nepaliInput2) {
            nepaliInput2.nepaliDatePicker({
                dateFormat: "YYYY-MM-DD",
                ndpYear: true,
                ndpMonth: true,
                ndpYearCount: 200
            });
        }

        //initialize depali datepicker for model
        $("#model-nepali-datepicker").nepaliDatePicker();
        $("#model-nepali-datepicker2").nepaliDatePicker();
        $("#model-nepali-datepicker").nepaliDatePicker({
            container: "#createLeaveType",
            dateFormat: "YYYY-MM-DD",
            ndpYear: true,
            ndpMonth: true,
            ndpYearCount: 200
        });

        $("#model-nepali-datepicker2").nepaliDatePicker({
            container: "#createLeaveType",
            dateFormat: "YYYY-MM-DD",
            ndpYear: true,
            ndpMonth: true,
            ndpYearCount: 200
        });
    });
</script>
