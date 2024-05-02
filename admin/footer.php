</div>

<footer class="bg-white sticky-footer">
    <div class="container my-auto">
        <div class="text-center my-auto copyright"><span>Copyright © Online Logistics System
                <?php echo date('Y');?></span></div>
    </div>
</footer>
</div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
</div>
<script src="../assets/bootstrap/js/bootstrap.min.js"></script>
<script src="../assets/js/chart.min.js"></script>
<script src="../assets/js/bs-init.js"></script>
<script src="../assets/js/theme.js"></script>
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">

<!-- Include DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

<!-- Include DataTables Buttons CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

<!-- Include DataTables Buttons JS -->
<script type="text/javascript" charset="utf8"
    src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js">
</script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js">
</script>

<script>
    $(document).ready(function () {
        // Initialize DataTable for monthly reports table
        var table = $('#monthlyReportsTable').DataTable({
            dom: 'Bfrtip', // Add buttons to the DataTable
            buttons: [
                'copy', 'excel', 'pdf', 'print' // Include copy, excel, pdf, and print buttons
            ]
        });

        // Add print button functionality
        $('#monthlyReportsTable_wrapper .dt-buttons').prepend(
            '<button class="btn btn-primary" id="printButton">Print</button>');

        // Handle print button click event
        $('#printButton').on('click', function () {
            table.button('3').trigger(); // Trigger the print button
        });
    });
</script>


<script>
    $(document).ready(function () {
        $('#myTable').DataTable();
    });
</script>
<!-- <script>
        $(document).ready( function () {
            $('#monthlyReportsTable').DataTable();
        });
    </script> -->
>
<script>
    $(document).ready(function () {
        // Initialize DataTable for monthly reports table
        var table = $('#OnDemandReport').DataTable({
            dom: 'Bfrtip', // Add buttons to the DataTable
            buttons: [
                'copy', 'excel', 'pdf', 'print' // Include copy, excel, pdf, and print buttons
            ]
        });

        // Add print button functionality
        $('#monthlyReportsTable_wrapper .dt-buttons').prepend(
            '<button class="btn btn-primary" id="printButton">Print</button>');

        // Handle print button click event
        $('#printButton').on('click', function () {
            table.button('3').trigger(); // Trigger the print button
        });
    });
</script>
</body>

</html>