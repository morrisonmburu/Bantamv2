<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        // rename myToken as you like
        window.myToken =  <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <title>{{ config('app.name', 'Bantam') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- for the inspinia theme -->
    <link href="{{ asset('font-awesome/css/font-awesome.css') }}"  rel="stylesheet">
    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">


    <!--- for text spinners-->
    <link href="{{ asset('css/plugins/textSpinners/spinners.css') }}" rel="stylesheet">

<!--- Added when adding calender in leave planner view
-->
    <link href="{{ asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">
    <link href="{{ asset('css/plugins/fullcalendar/fullcalendar.css')}}" rel="stylesheet">
    <link href="{{ asset('css/plugins/fullcalendar/fullcalendar.print.css')}}" rel='stylesheet' media='print'>
    <!--


    End of leave planner  imports -->

    <!--  Ladda css added by Mayaka. This is for the button spinners -->
        <!-- Ladda style -->
        <link href="css/plugins/ladda/ladda-themeless.min.css" rel="stylesheet">
    <!-- End of ladda -->
    <link href="{{ asset('css/plugins/datapicker/datepicker3.css')}}" rel="stylesheet">

    <style>
        [v-cloak]{
            display: none;
        }
    </style>

</head>
<body class="gray-bg" style="background-color: #8b0304">
<div id="app">
    <main class="py-4" v-cloak>
        @yield('content')
    </main>
</div>
<script src="js/jquery-3.1.1.min.js"></script>
<!-- Data picker -->
{{--<script src="{{ asset('js/plugins/datapicker/bootstrap-datepicker.js')}}"></script>--}}
<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>

<!-- Ladda  :: added  by @mayaka-->
<script src="{{asset("js/plugins/ladda/spin.min.js")}}"></script>
<script src="{{asset("js/plugins/ladda/ladda.min.js")}}"></script>
<script src="{{asset("js/plugins/ladda/ladda.jquery.min.js")}}"></script>
<!--  End of ladda -->


<!-- Highcharts imports -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/4.2.7/highcharts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/4.2.7/modules/exporting.js"></script>
<!-- End of high chart imports -->
<script>
    var leaveAllocations = {};
    $(document).ready(function() {
        var APP_URL ={!! json_encode(url('/')) !!};
        var user ={!!Auth::user()!=null?Auth::user()->id:''!!};
        var url=APP_URL+'/api/employees/'+user+'/leave_allocations';
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
        success: function(data) {
            createBarGraph(data.data);
        },
        error: function(errorThrown) {
            console.log('Error in Database:'+url);
            console.log(errorThrown);
        }
    });
        function createBarGraph(data) {
            //Leave types vs days bar graph
            Leaves = [];
            allocated = [];
            accrued = [];
            balance = [];
            balance_bf = [];
            for (i=1;i< data.length;i++){
                switch(data[i]['Leave_Code']){
                    case"ANNUAL":
                        Leaves.push("Annual");
                        break;
                    case"COMPSS":
                        Leaves.push("Compassion");
                        break;
                    case"MATERNITY":
                        Leaves.push("Maternity");
                        break;
                    case"OFFDAY":
                        Leaves.push("Off Day");
                        break;
                    case"PATERNITY":
                        Leaves.push("Paternity");
                        break;
                    case"SICK":
                        Leaves.push("Sick");
                        break;
                    default:
                        Leaves.push(data[i]['Leave_Code']);
                }

                allocated.push(parseFloat(data[i]['Allocated_Days']));
                accrued.push(parseFloat(data[i]['Accrued_Days']));
                balance.push(parseFloat(data[i]['Balance']));
                balance_bf.push(parseFloat(data[i]['Balance_B_F']));
            }
            console.log(accrued);
            var leaveTypesBarGraph = new Highcharts.chart('leaveDaysChart', {
                chart: {
                    type: 'bar'
                },
                title: {
                    text: ''
                },
                xAxis: {
                    categories: Leaves
                },
                yAxis: {
                    min: 0,
                    title: {
                        text: 'Days'
                    }
                },
                legend: {
                    reversed: true
                },
                plotOptions: {
                    series: {
                        stacking: 'normal'
                    }
                },
                series: [{
                    name: 'Allocated',
                    data: allocated,
                    color: '#78f78d'
                }, {
                    name: 'Accrued',
                    data: accrued,
                    color: '#ff9548'
                }, {
                    name: 'Balance',
                    data: balance,
                    color: '#57bbec'
                }, {
                    name: 'Balance BF',
                    data: balance_bf,
                    color: '#ec1a1d'
                }]
            });
        }


        //Leave application statistics pie chart
        var leaveApplicationsPieChart  = new Highcharts.chart('leaveApplicationsChart', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: ''
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: false
                    },
                    showInLegend: true
                }
            },
            series: [{
                name: 'Applications',
                colorByPoint: true,
                data: [{
                    name: 'All',
                    y: 61.41,
                    sliced: true,
                    selected: true,
                    color:"#f7ed06"
                }, {
                    name: 'Successful',
                    y: 11.84,
                    color:'#78f78d'
                }, {
                    name: 'Pending',
                    y: 10.85,
                    color:'#2addf7'
                }, {
                    name: 'Rejected',
                    y: 4.67,
                    color:'#f73c31'
                }]
            }]
        });
    });
</script>


{{--<!-- Flot -->--}}
{{--<script src="js/plugins/flot/jquery.flot.js"></script>--}}
{{--<script src="js/plugins/flot/jquery.flot.tooltip.min.js"></script>--}}
{{--<script src="js/plugins/flot/jquery.flot.spline.js"></script>--}}
{{--<script src="js/plugins/flot/jquery.flot.resize.js"></script>--}}
{{--<script src="js/plugins/flot/jquery.flot.pie.js"></script>--}}
{{--<script src="js/plugins/flot/jquery.flot.symbol.js"></script>--}}
{{--<script src="js/plugins/flot/jquery.flot.time.js"></script>--}}

<!-- Peity -->
{{--<script src="js/plugins/peity/jquery.peity.min.js"></script>--}}
{{--<script src="js/demo/peity-demo.js"></script>--}}

{{--<!-- jQuery UI -->--}}
{{--<script src="js/plugins/jquery-ui/jquery-ui.min.js"></script>--}}

<!-- Jvectormap -->
{{--<script src="js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js"></script>--}}
{{--<script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>--}}

<!-- EayPIE -->
{{--<script src="js/plugins/easypiechart/jquery.easypiechart.js"></script>--}}

{{--<!-- Sparkline -->--}}
{{--<script src="js/plugins/sparkline/jquery.sparkline.min.js"></script>--}}


{{--<!-- Sparkline demo data  -->--}}
{{--<script src="js/demo/sparkline-demo.js"></script>--}}

{{--<!--- Added when adding calender in leave planner view-->--}}
{{--<script src="js/plugins/fullcalendar/moment.min.js"></script>--}}

{{--<!-- iCheck -->--}}
{{--<script src="js/plugins/iCheck/icheck.min.js"></script>--}}

<!-- Full Calendar -->
{{--<script src="js/plugins/fullcalendar/fullcalendar.min.js"></script>--}}




{{--<script>--}}
    {{--$(document).ready(function() {--}}
        {{--// $('.datepicker').datepicker({--}}
        {{--//     format: 'yyyy-mm-dd',--}}
        {{--//     startDate: '-3d'--}}
        {{--// });--}}
        {{--$('.i-checks').iCheck({--}}
            {{--checkboxClass: 'icheckbox_square-green',--}}
            {{--radioClass: 'iradio_square-green'--}}
        {{--});--}}
        {{--/* initialize the external events--}}
         {{-------------------------------------------------------------------*/--}}
        {{--$('#external-events div.external-event').each(function() {--}}

            {{--// store data so the calendar knows to render an event upon drop--}}
            {{--$(this).data('event', {--}}
                {{--title: $.trim($(this).text()), // use the element's text as the event title--}}
                {{--stick: true // maintain when user navigates (see docs on the renderEvent method)--}}
            {{--});--}}

            {{--// make the event draggable using jQuery UI--}}
            {{--$(this).draggable({--}}
                {{--zIndex: 1111999,--}}
                {{--revert: true,      // will cause the event to go back to its--}}
                {{--revertDuration: 0  //  original position after the drag--}}
            {{--});--}}

        {{--});--}}
        {{--/* initialize the calendar--}}
         {{-------------------------------------------------------------------*/--}}
        {{--var date = new Date();--}}
        {{--var d = date.getDate();--}}
        {{--var m = date.getMonth();--}}
        {{--var y = date.getFullYear();--}}

        {{--$('#calendar').fullCalendar({--}}
            {{--header: {--}}
                {{--left: 'prev,next today',--}}
                {{--center: 'title',--}}
                {{--right: 'month,agendaWeek,agendaDay'--}}
            {{--},--}}
            {{--editable: true,--}}
            {{--droppable: true, // this allows things to be dropped onto the calendar--}}
            {{--drop: function() {--}}
                {{--// is the "remove after drop" checkbox checked?--}}
                {{--if ($('#drop-remove').is(':checked')) {--}}
                    {{--// if so, remove the element from the "Draggable Events" list--}}
                    {{--$(this).remove();--}}
                {{--}--}}
            {{--},--}}
            {{--events: [--}}
                {{--{--}}
                    {{--title: 'All Day Event',--}}
                    {{--start: new Date(y, m, 1)--}}
                {{--},--}}
                {{--{--}}
                    {{--title: 'Long Event',--}}
                    {{--start: new Date(y, m, d-5),--}}
                    {{--end: new Date(y, m, d-2)--}}
                {{--},--}}
                {{--{--}}
                    {{--id: 999,--}}
                    {{--title: 'Repeating Event',--}}
                    {{--start: new Date(y, m, d-3, 16, 0),--}}
                    {{--allDay: false--}}
                {{--},--}}
                {{--{--}}
                    {{--id: 999,--}}
                    {{--title: 'Repeating Event',--}}
                    {{--start: new Date(y, m, d+4, 16, 0),--}}
                    {{--allDay: false--}}
                {{--},--}}
                {{--{--}}
                    {{--title: 'Meeting',--}}
                    {{--start: new Date(y, m, d, 10, 30),--}}
                    {{--allDay: false--}}
                {{--},--}}
                {{--{--}}
                    {{--title: 'Lunch',--}}
                    {{--start: new Date(y, m, d, 12, 0),--}}
                    {{--end: new Date(y, m, d, 14, 0),--}}
                    {{--allDay: false--}}
                {{--},--}}
                {{--{--}}
                    {{--title: 'Birthday Party',--}}
                    {{--start: new Date(y, m, d+1, 19, 0),--}}
                    {{--end: new Date(y, m, d+1, 22, 30),--}}
                    {{--allDay: false--}}
                {{--},--}}
                {{--{--}}
                    {{--title: 'Click for Google',--}}
                    {{--start: new Date(y, m, 28),--}}
                    {{--end: new Date(y, m, 29),--}}
                    {{--url: 'http://google.com/'--}}
                {{--}--}}
            {{--]--}}
        {{--});--}}
    {{--});--}}
    {{--$(document).ready(function (){--}}

        {{--// Bind normal buttons--}}
        {{--Ladda.bind( '.ladda-button',{ timeout: 2000 });--}}

        {{--// Bind progress buttons and simulate loading progress--}}
        {{--Ladda.bind( '.progress-demo .ladda-button',{--}}
            {{--callback: function( instance ){--}}
                {{--var progress = 0;--}}
                {{--var interval = setInterval( function(){--}}
                    {{--progress = Math.min( progress + Math.random() * 0.1, 1 );--}}
                    {{--instance.setProgress( progress );--}}

                    {{--if( progress === 1 ){--}}
                        {{--instance.stop();--}}
                        {{--clearInterval( interval );--}}
                    {{--}--}}
                {{--}, 200 );--}}
            {{--}--}}
        {{--});--}}


        {{--var l = $( '.ladda-button-demo' ).ladda();--}}

        {{--l.click(function(){--}}
            {{--// Start loading--}}
            {{--l.ladda( 'start' );--}}

            {{--// Timeout example--}}
            {{--// Do something in backend and then stop ladda--}}
            {{--setTimeout(function(){--}}
                {{--l.ladda('stop');--}}
            {{--},12000)--}}
        {{--});--}}

    {{--});--}}

{{--</script>--}}
<!--  End of leave planner imports -->
</body>
</html>
