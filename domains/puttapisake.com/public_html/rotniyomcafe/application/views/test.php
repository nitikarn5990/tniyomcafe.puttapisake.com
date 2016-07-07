<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/drilldown.js"></script>


<button id="type_chart">Back</button>
<div id="container" style="height: 400px">
    
</div>
<div style="display: none;">
    <button id="name">Toggle name</button>
    <button id="data-labels">Toggle data labels</button>
    <button id="markers">Toggle point markers</button>
    <button id="color">Toggle color</button>

    <button id="column" style="margin-left: 2em">Column</button>
    <button id="line">Line</button>
    <button id="spline">Spline</button>
    <button id="area">Area</button>
    <button id="areaspline">Areaspline</button>
    <button id="scatter">Scatter</button>
    <button id="pie">Pie</button>
    <button type="button" id="set4" >Click</button>
    <button type="button" id="updatedata" onclick="xx()" >update Data</button>
</div>

<?php
$arr = [
    'name' => 'TEST',
    'title' => 'All TEST',
    'keys' => [
        'x',
        'y',
        'drilldown',
    ],
    'data' => [
        [1420070400000, 63.284, 'y2015']
    ]
];
$main_arr = array(
    'series' => array($arr),
    'drilldown' => array(
        'series' => [$arr]
    )
);
//$main_arr['drilldown'] = 
//echo "<pre>";
//echo (json_encode($main_arr));
//die();
?>
<script>
    var chart;
    $(function () {

        Highcharts.setOptions({
            lang: {
                decimalPoint: '.',
                thousandsSep: ','
            }
        });
        $('#container').highcharts({
            title: {
                text: ''
            },
//            subtitle: {
//                text: 'Subtitle'
//            },
            chart: {
                type: 'column',
                events: {
                    load: function () {
                        //swapCats();
                        load_years();
                    }
                }

            },
            xAxis: {
                //categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                showEmpty: false
            },
            yAxis: {
                showEmpty: false,
                title: {
                    text: 'บาท'
                }
            },
            plotOptions: {
                series: {
                    dataLabels: {
                        enabled: true,
                        formatter: function () {
                            if (this.y > 0)
                                return this.y;
                        }
                    },
                    cursor: 'pointer',
                    point: {
                        events: {
                            click: function () {
                                //   alert('Category: ' + this.category + ', value: ' + this.y);
                                console.log(type_chart);
                                type_value = this.category;

                                if (type_chart == 'year') {
                                    //  load_months();
                                    year_value = this.category;
                                    load_months();
                                } else if (type_chart == 'month') {


                                    // load_days();
                                    //  console.log( this.category);
                                    month_value = this.category;
                                    load_days();

                                    //  alert(year_value);
                                    //  alert(month_value);
                                } else if (type_chart == 'day') {
                                    //  console.log(this.category);
                                    // load_days();
                                    day_value = this.category;
                                    load_count_order();
                                }
                            }
                        }
                    }
                }
            },
            series: [{
                    allowPointSelect: false,
                    name: 'ยอดขาย',
                    dataLabels: {
                        enabled: true,
                        formatter: function () {
                            if (this.y > 0) {
                                return  Highcharts.numberFormat(this.y, 0, '.');
                            }
                        }
                    },
//                    data: [// use names for display in pie data labels
//                        ['January', 29.9],
//                        ['February', 71.5],
//                        ['March', 106.4],
//                        ['April', 129.2],
//                        ['May', 144.0],
//                        ['June', 176.0],
//                        ['July', 135.6],
//                        ['August', 148.5],
//                        {
//                            name: 'September',
//                            y: 216.4,
//                            selected: true,
//                            sliced: true
//                        },
//                        ['October', 194.1],
//                        ['November', 95.6],
//                        ['December', 54.4],
//                    ],
                    marker: {
                        enabled: false
                    },
                    showInLegend: true
                }]
        });
        chart = $('#container').highcharts(),
                name = false,
                enableDataLabels = true,
                enableMarkers = true,
                color = false;
        // Toggle names
        $('#name').click(function () {
            chart.series[0].update({
                name: name ? null : 'ยอดขาย'
            });
            name = !name;
        });
        // Toggle data labels
        $('#data-labels').click(function () {
            chart.series[0].update({
                dataLabels: {
                    enabled: enableDataLabels
                }
            });
            enableDataLabels = !enableDataLabels;
        });
        // Toggle point markers
        $('#markers').click(function () {
            chart.series[0].update({
                marker: {
                    enabled: enableMarkers
                }
            });
            enableMarkers = !enableMarkers;
        });
        // Toggle point markers
        $('#color').click(function () {
            chart.series[0].update({
                color: color ? null : Highcharts.getOptions().colors[1]
            });
            color = !color;
        });
        // Set type
        $.each(['line', 'column', 'spline', 'area', 'areaspline', 'scatter', 'pie'], function (i, type) {
            $('#' + type).click(function () {
                chart.series[0].update({
                    type: type
                });
            });
        });
    });
    function swapCats() {
        if (Highcharts.charts[0].xAxis[0].categories[0] == 'Jan') {

//            Highcharts.charts[0].xAxis[0].update({
//                        categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12']
//            },true );

            Highcharts.charts[0].xAxis[0].update({categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']}, true);
        } else {

            Highcharts.charts[0].xAxis[0].update({categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']}, true);
        }

        //  setTimeout(swapCats,1000);    
    }


 
    var type_chart = '';
    var type_value = '';

    var year_value = '';
    var month_value = '';
    var day_value = '';

    function load_years() {

        type_chart = 'year';
         

        $.ajax({
            url: "<?= base_url() ?>backoffice/test/ajax_get_years",
            type: "POST",
            //data: send,
            dataType: "json",
            success: function (data) {

                var list = new Array();
                var price = new Array();
                $.each(data, function (k, v) {
                    //  console.log(v.formatted_date);
                    // alert(JSON.stringify(v));
                    list.push(v.formatted_date);
                    // list.push(v.formatted_date);
                    var val = {
                        name: v.formatted_date,
                        y: parseInt(v.sum_total)
                    };
                    //  xx.push(test);
                    // xx = JSON.stringify(v.formatted_date);
                    price.push(val);
                });
                // var myJsonString = JSON.stringify(xx);
                // var jsonArray = JSON.parse((xx));
                //JSON.stringify(xx2);
                //  console.log(price);
                Highcharts.charts[0].xAxis[0].update({
                    categories: list
                }, true);
                chart.series[0].update({
                    data: price
                });
                //   if (data.status == true) {
                //  location.reload();
                //  }
            }
        });
    }
    function get_month_th(num) {
        if (num == 01)
            print2 = 'มกราคม';
        if (num == 02)
            print2 = 'กุมภาพันธ์';
        if (num == 03)
            print2 = 'มีนาคม';
        if (num == 04)
            print2 = 'เมษายน';
        if (num == 05)
            print2 = 'พฤษภาคม';
        if (num == 06)
            print2 = 'มิถุนายน';
        if (num == 07)
            print2 = 'กรกฎาคม';
        if (num == 08)
            print2 = 'สิงหาคม';
        if (num == 09)
            print2 = 'กันยายน';
        if (num == 10)
            print2 = 'ตุลาคม';
        if (num == 11)
            print2 = 'พฤศจิกายน';
        if (num == 12)
            print2 = 'ธันวาคม';

        return print2;

    }
    function get_num_month(str_month) {
        if (str_month == 'มกราคม')
            print2 = '01';
        if (str_month == 'กุมภาพันธ์')
            print2 = '02';
        if (str_month == 'มีนาคม')
            print2 = '03';
        if (str_month == 'เมษายน')
            print2 = '04';
        if (str_month == 'พฤษภาคม')
            print2 = '05';
        if (str_month == 'มิถุนายน')
            print2 = '06';
        if (str_month == 'กรกฎาคม')
            print2 = '07';
        if (str_month == 'สิงหาคม')
            print2 = '08';
        if (str_month == 'กันยายน')
            print2 = '09';
        if (str_month == 'ตุลาคม')
            print2 = '10';
        if (str_month == 'พฤศจิกายน')
            print2 = '11';
        if (str_month == 'ธันวาคม')
            print2 = '12';

        return print2;

    }
    function load_months() {

        type_chart = 'month';
        chart.setTitle({
             text: "ปี "+ year_value
        });
      
         chart.series[0].update({
            name: 'ยอดขาย'
        });

        chart.yAxis[0].update({
            title: {
                text: 'บาท'
            }
        }, true);


        $.ajax({
            url: "<?= base_url() ?>backoffice/test/ajax_get_months",
            type: "POST",
            data: {
                year: year_value
            },
            dataType: "json",
            success: function (data) {

                var list = new Array();
                var price = new Array();
                $.each(data, function (k, v) {
                    //  console.log(v.formatted_date);
                    // alert(JSON.stringify(v));
                    list.push(get_month_th(v.formatted_date));
                    // list.push(v.formatted_date);

                    var val = {
                        name: get_month_th(v.formatted_date),
                        y: parseInt(v.sum_total)
                    };
                    //  xx.push(test);
                    // xx = JSON.stringify(v.formatted_date);
                    price.push(val);
                });
                // var myJsonString = JSON.stringify(xx);
                // var jsonArray = JSON.parse((xx));
                //JSON.stringify(xx2);
                //console.log(price);
                Highcharts.charts[0].xAxis[0].update({
                    categories: list
                }, true);
                chart.series[0].update({
                    data: price
                });
                //   if (data.status == true) {
                //  location.reload();
                //  }
            }
        });
    }
    function load_days() {


        type_chart = 'day';

        chart.setTitle({
            text: " เดือน "+ month_value+" ปี "+ year_value 
        });
         chart.series[0].update({
            name: 'ยอดขาย'
        });
        chart.yAxis[0].update({
            title: {
                text: 'บาท'
            }
        }, true);
        $.ajax({
            url: "<?= base_url() ?>backoffice/test/ajax_get_days/" + year_value + "/" + get_num_month(month_value),
            type: "POST",
            data: {
                //  year: year_value,
                // month: get_num_month(month_value) 
            },
            dataType: "json",
            success: function (data) {
                //  console.log(data);
                var list = new Array();
                var price = new Array();
                $.each(data, function (k, v) {
                    //  console.log(v.formatted_date);
                    // alert(JSON.stringify(v));
                    list.push((v.formatted_date));
                    // list.push(v.formatted_date);

                    var val = {
                        name: (v.formatted_date),
                        y: parseInt(v.sum_total)
                    };
                    //  xx.push(test);
                    // xx = JSON.stringify(v.formatted_date);
                    price.push(val);
                });
                // var myJsonString = JSON.stringify(xx);
                // var jsonArray = JSON.parse((xx));
                //JSON.stringify(xx2);
                //console.log(price);
                Highcharts.charts[0].xAxis[0].update({
                    categories: list
                }, true);
                chart.series[0].update({
                    data: price
                });
                //   if (data.status == true) {
                //  location.reload();
                //  }
            }
        });
    }

    function load_count_order() {


        type_chart = 'count_order';

        chart.setTitle({
            text: "วันที่ "+day_value + " เดือน " + month_value + " ปี " + year_value 
        });
        chart.series[0].update({
            name: 'จำนวน'
        });

        chart.yAxis[0].update({
            title: {
                text: 'จำนวน'
            }
        }, true);
        //   alert(year_value );
        // alert(get_num_month(month_value) );
        //   return false;
        $.ajax({
            url: "<?= base_url() ?>backoffice/test/ajax_count_order/" + year_value + "/" + get_num_month(month_value) + "/" + day_value,
            type: "POST",
            data: {
                //  year: year_value,
                // month: get_num_month(month_value) 
            },
            dataType: "json",
            success: function (data) {
                // console.log(data[0]);



                // var myJsonString = JSON.stringify(xx);
                // var jsonArray = JSON.parse((xx));
                //JSON.stringify(xx2);
                //console.log(price);
                Highcharts.charts[0].xAxis[0].update({
                    categories: ['จำนวน Order']
                }, true);
                chart.series[0].update({
                    data: [
                        {
                            name: ('จำนวน Order'),
                            y: parseInt(data[0].count_order)
                        }
                    ]
                });
                //   if (data.status == true) {
                //  location.reload();
                //  }
            }
        });
    }


    $('#type_chart').click(function () {
        if (type_chart == 'month') {
            load_years();
        } else if (type_chart == 'day') {
            load_months();
        } else if (type_chart == 'count_order') {
            load_days();
        }
    });
</script>
