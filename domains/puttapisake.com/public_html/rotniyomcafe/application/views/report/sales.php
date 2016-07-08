
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/data.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>


<script type="text/javascript">
    function printDiv2(divId) {
        
           $('#'+divId).printThis();
//        var printContents = document.getElementById(divId).innerHTML;
//
//        var originalContents = document.body.innerHTML;
//        //console.log(originalContents);
//
//        document.body.innerHTML = "<html><head>   </head><body>" + printContents + "</body>";
//
//        window.print();
//
//        document.body.innerHTML = originalContents;
        


    }

    function print_chart() {
<?php if ($type == 'สินค้าขายดี' || $type == 'ประเภทสินค้าขายดี' || $type == 'Topping ขายดี' || $type == 'หมวดหมู่ขายดี') { ?>
            printCharts([chart1]);
<?php } else { ?>
            printCharts([chart1, chart2]);
<?php } ?>

    }

    function printCharts(charts) {

        var origDisplay = [],
                origParent = [],
                body = document.body,
                childNodes = body.childNodes;

        // hide all body content
        Highcharts.each(childNodes, function (node, i) {
            if (node.nodeType === 1) {
                origDisplay[i] = node.style.display;
                node.style.display = "none";
            }
        });

        // put the charts back in
        $.each(charts, function (i, chart) {
            origParent[i] = chart.container.parentNode;
            body.appendChild(chart.container);
        });

        // print
        window.print();

        // allow the browser to prepare before reverting
        setTimeout(function () {
            // put the chart back in
            $.each(charts, function (i, chart) {
                origParent[i].appendChild(chart.container);
            });

            // restore all body content
            Highcharts.each(childNodes, function (node, i) {
                if (node.nodeType === 1) {
                    node.style.display = origDisplay[i];
                }
            });
        }, 500);
    }


</script>
<section class="content-header">
    <h1>
        <i class="fa fa-file-text"></i> รายงาน
    </h1>
    <ol class="breadcrumb hidden">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol>
</section>
<!-- Main content -->
<section class="content" id="content-print">
    <div class="row">

        <div class="col-md-12">
            <form action="<?= base_url() ?>report/sales" method="POST">
                <input type="hidden" id="date_start" name="date_start" value="<?= empty($_POST['date_start']) ? '' : $_POST['date_start'] ?>">
                <input type="hidden" id="date_end" name="date_end" value="<?= empty($_POST['date_end']) ? '' : $_POST['date_end'] ?>">
                <div class="box box-widget ">

                    <div class="box-header with-border ">
                        <h3 class="box-title"><i class="fa fa-search"></i> ค้นหา</h3>
                    </div>
                    <div class="box-body">
                        <?php
                        $arr = array(
                            'ยอดขาย',
                            //  'สินค้า',
                            'สินค้าขายดี',
                            'ประเภทสินค้าขายดี',
                            'หมวดหมู่ขายดี',
                            'Topping ขายดี',
                            'ช่วงเวลาขายดี',
                            'Order',
                        );
                        $arr2 = array(
                            '',
                            'ตามช่วงเวลา',
                            'ตามช่วงเดือน',
                            'ตามช่วงปี',
                        );
                        ?>
                        <div class="row">
                            <div class="col-md-12 col-xs-12">
                                <div class="form-inline">
                                    <p>
                                        <select name="report_type" data-validation="required" id="report_type" class="form-control col-md-3 col-sm-6 col-xs-6" style="min-width: 240px;">
                                            <?php
                                            foreach ($arr as $value) {
                                                ?>
                                                <option value="<?= $value ?>" <?= $value == $type ? 'selected' : '' ?>>
                                                    <?php
                                                    if ($value == 'ประเภทสินค้าขายดี') {
                                                        echo 'ประเภทขายดี';
                                                    } else {
                                                        echo $value;
                                                    }
                                                    ?>
                                                </option>  
                                            <?php } ?>
                                        </select>
                                        <select name="report_range" data-validation="required" id="report_range" class="form-control col-md-3 col-sm-6 col-xs-6" style="min-width: 240px;" onchange="report_ranges(this)">
                                            <?php
                                            foreach ($arr2 as $value2) {
                                                ?>
                                                <option value="<?= $value2 ?>" <?= $value2 == $report_range ? 'selected' : '' ?>>

                                                    <?php
                                                    if ($value2 == '') {
                                                        echo '----กรุณาเลือก----';
                                                    } else {
                                                        if ($value2 == 'ตามช่วงเวลา') {
                                                            echo 'เลือกวัน';
                                                        }
                                                        if ($value2 == 'ตามช่วงเดือน') {
                                                            echo 'เลือกเดือน';
                                                        }
                                                        if ($value2 == 'ตามช่วงปี') {
                                                            echo 'เลือกปี';
                                                        }
                                                    }
                                                    ?>

                                                </option>  
                                            <?php } ?>
                                        </select>
                                    </p>
                                    <link href="<?= base_url() ?>assets/plugins/datepicker/redmond.datepick.css" rel="stylesheet">

                                    <script src="<?= base_url() ?>assets/plugins/datepicker/jquery.plugin.js"></script>
                                    <script src="<?= base_url() ?>assets/plugins/datepicker/jquery.datepick.js"></script>
                                    <script src="<?= base_url() ?>assets/plugins/datepicker/jquery.datepick-th.js"></script>
                                    <script>
                                            $(function () {
                                                // $('#transfer_date').datepick();
                                                $('#datepicker2').datepick({
                                                    //    maxDate: +0,
                                                    changeYear: false,
                                                    dateFormat: 'yyyy-mm-dd'
                                                });
                                                // $('#inlineDatepicker').datepick({onSelect: showDate});
                                            });

                                    </script>

                                    <p class="tools_date">
                                        <?php if (isset($reservation)) { ?>
                                            &nbsp; เลือกวัน : <input type="text" readonly data-validation="required" placeholder="คลิกเลือกวันที่" class="form-control " id="reservation" name="reservation" value="<?= $reservation ?>" style="min-width: 300px;">   
                                        <?php } else { ?>
                                            &nbsp; เลือกวัน : <input type="text" readonly data-validation="required" placeholder="คลิกเลือกวันที่" class="form-control " id="reservation" name="reservation" value="<?= empty($_POST['reservation']) ? '' : $_POST['reservation'] ?>" style="min-width: 300px;">
                                        <?php } ?>

                                    </p>

                                    <p class="tools_month">
                                        &nbsp; เลือกเดือน : <input type="text" readonly="" data-validation="required" placeholder="คลิกเลือกเดือนเริ่ม" class="form-control" id="daterange_month_start" name="daterange_month_start" value="<?= empty($_POST['daterange_month_start']) ? '' : $_POST['daterange_month_start'] ?>" style="width: 300px;">   

                                    </p>

                                    <p class="tools_year">
                                        &nbsp; เลือกปี : <input type="text" readonly="" data-validation="required" placeholder="คลิกเลือกปีเริ่ม" class="form-control" id="daterange_year_start" name="daterange_year_start" value="" style="width: 300px;">   

                                    </p>
                                    <div class="clearfix"></div>
                                    <p>
                                        <button type="submit" class="btn btn-flat bg-purple col-md-1 col-xs-12" name="btn_submit" id="btn_submit" value="ค้นหา"><i class="fa fa-search"></i> ค้นหา</button>

                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="box box-widget" id="box-content">

                    <div class="box-header">
                        <h3><i class="fa fa-list"></i> แสดงข้อมูลที่ค้นหา </h3>
                        <h4 class="text-center"> <?= isset($duration) ? $duration : '' ?> </h4>
                    </div>
                    <div class="box-body" >
                        <?php if (($type) == 'ยอดขาย') { ?>

                            <div class="col-md-12 col-xs-12">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="active show-table-data"><a href="#view_text" data-toggle="tab">แสดงข้อมูล</a></li>
                                        <li class=""><a href="#view_gp" class="link-show-graph-data" data-toggle="tab" >แสดงกราฟ</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <div class="active tab-pane" id="view_text">
                                            <p>
                                                <button type="button" class="btn btn-flat bg-blue col-md-1 col-xs-12 pull-right"  onclick="printDiv2('box-content')"><i class="fa fa-print"></i> Print</button>     
                                            </p>
                                            <div class="clearfix"></div>
                                            <div class="table-responsive">
                                                <table id="report1" class="table table-hover table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>  
                                                            <th>Date</th>  
                                                            <th>Qty</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>No.</th>  
                                                            <th>Date</th>  
                                                            <th>Qty</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        <?php
                                                        $total_sales = 0;
                                                        foreach ($res_active_order_sales as $key => $row) {

                                                            $date = ($row['formatted_date']);
                                                            $total_sales = $total_sales + $row['total'];
                                                            ?>

                                                            <tr class="">
                                                                <td><?= $key + 1 ?></td>
                                                                <td><?= $row['menu_name'] ?></td>
                                                                <td> <?= $row['total_qty'] ?></td>
                                                                <td> <?= $row['total'] ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="info-box">
                                                <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">รวมทั้งหมด</span>
                                                    <span class="info-box-number">฿ <?= $total_sales ?></span>
                                                </div>
                                            </div>
                                        </div><!-- /.tab-pane -->
                                        <div class="tab-pane" id="view_gp">
                                            <div class="">
                                                <button type="button" class="btn btn-flat bg-blue col-md-1 col-xs-12 pull-right"  onclick="print_chart()"><i class="fa fa-print"></i> Print</button>     
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="table-responsive">
                                                <div class="col-md-10 col-xs-12" id="gp">

                                                </div>
                                                <p>&nbsp;</p>
                                                <div class="col-md-10 col-xs-12"  id="gp2">

                                                </div>
                                            </div>


                                        </div><!-- /.tab-pane -->
                                    </div><!-- /.tab-content -->
                                </div><!-- /.nav-tabs-custom -->
                            </div>



                        <?php } ?>
                        <?php if (($type) == 'ช่วงเวลาขายดี') { ?>

                            <div class="col-md-12">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class="hidden active show-table-data"><a href="#view_text" data-toggle="tab">แสดงข้อมูล</a></li>
                                        <li class="active"><a href="#view_gp" class="link-show-graph-data" data-toggle="tab" >แสดงกราฟ</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <div class="hidden tab-pane" id="view_text">
                                            <p>
                                                <button type="button" class="btn btn-flat bg-blue col-md-1 col-xs-12 pull-right"  onclick="printDiv2('box-content')"><i class="fa fa-print"></i> Print</button>     
                                            </p>
                                            <div class="clearfix"></div>
                                            <div class="table-responsive">
                                                <table id="report1" class="table table-hover table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>  
                                                            <th>Date</th>  
                                                            <th>Qty</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>No.</th>  
                                                            <th>Date</th>  
                                                            <th>Qty</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        <?php
                                                        $total_sales = 0;
                                                        foreach ($res_active_order_sales as $key => $row) {

                                                            $date = ($row['formatted_date']);
                                                            $total_sales = $total_sales + $row['total'];
                                                            ?>

                                                            <tr class="">
                                                                <td><?= $key + 1 ?></td>
                                                                <td><?= $row['menu_name'] ?></td>
                                                                <td> <?= $row['total_qty'] ?></td>
                                                                <td> <?= $row['total'] ?></td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="info-box">
                                                <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">รวมทั้งหมด</span>
                                                    <span class="info-box-number">฿ <?= $total_sales ?></span>
                                                </div>
                                            </div>
                                        </div><!-- /.tab-pane -->
                                        <div class="active tab-pane" id="view_gp">
                                            <div class="">
                                                <button type="button" class="btn btn-flat bg-blue col-md-1 col-xs-12 pull-right"  onclick="print_chart()"><i class="fa fa-print"></i> Print</button>     
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="table-responsive">
                                                <div class="col-md-10 col-xs-12" id="gp">

                                                </div>
                                                <p>&nbsp;</p>
                                                <div class="col-md-10 col-xs-12" id="gp2">

                                                </div>
                                            </div>


                                        </div><!-- /.tab-pane -->
                                    </div><!-- /.tab-content -->
                                </div><!-- /.nav-tabs-custom -->
                            </div>



                        <?php } ?>
                        <?php if (($type) == 'สินค้าขายดี') { ?>

                            <div class="col-md-12">
                                <div class="nav-tabs-custom">
                                    <ul class="nav nav-tabs">
                                        <li class=""><a href="#view_text_product" data-toggle="tab">แสดงข้อมูล</a></li>
                                        <li class="active"><a href="#view_gp_product" data-toggle="tab" >แสดงกราฟ</a></li>
                                    </ul>

                                    <div class="tab-content">
                                        <div class=" tab-pane" id="view_text_product">
                                            <p>
                                                <button type="button" class="btn btn-flat bg-blue col-md-1 col-xs-12 pull-right"  onclick="printDiv2('box-content')"><i class="fa fa-print"></i> Print</button>     
                                            </p>
                                            <div class="clearfix"></div>
                                            <div class="table-responsive">
                                                <table id="report2" class="table table-hover table-bordered" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>No.</th>  
                                                            <th>Product</th>
                                                            <th>Qty</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tfoot>
                                                        <tr>
                                                            <th>No.</th>  
                                                            <th>Product</th>
                                                            <th>Qty</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        <?php
                                                        $total_sales = 0;
                                                        $menu_type = '';

                                                        foreach ($res_active_order_sales as $key => $row) {

                                                            // $date = ShowDateTh2($row['formatted_date']);
                                                            $total_sales = $total_sales + $row['total_price'];
                                                            if ($row['menu_type'] == 'iced') {
                                                                $menu_type = 'เย็น';
                                                            }
                                                            if ($row['menu_type'] == 'hot') {
                                                                $menu_type = 'ร้อน';
                                                            }
                                                            if ($row['menu_type'] == 'smoothie') {
                                                                $menu_type = 'ปั่น';
                                                            }
                                                            ?>

                                                            <tr class="">
                                                                <td><?= $key + 1 ?></td>
                                                                <td><?= $row['product'] ?></td>
                                                                <td><?= $row['total_qty'] ?></td>
                                                                <td> <?= $row['total_price'] ?></td>

                                                            </tr>
                                                        <?php } ?>


                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="info-box">
                                                <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
                                                <div class="info-box-content">
                                                    <span class="info-box-text">รวมทั้งหมด</span>
                                                    <span class="info-box-number">฿ <?= $total_sales ?></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="active tab-pane" id="view_gp_product">
                                            <div class="">
                                                <button type="button" class="btn btn-flat bg-blue col-md-1 col-xs-12 pull-right"  onclick="print_chart()"><i class="fa fa-print"></i> Print</button>     
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="table-responsive">
                                                <div class="col-md-10 col-xs-12" id="gp_product">

                                                </div>
                                            </div>


                                        </div><!-- /.tab-pane -->
                                    </div>

                                <?php } ?>
                                <?php if (($type) == 'ประเภทสินค้าขายดี') { ?>

                                    <div class="col-md-12">
                                        <div class="nav-tabs-custom">
                                            <ul class="nav nav-tabs">
                                                <li class="active show-table-data"><a href="#view_text_product" data-toggle="tab">แสดงข้อมูล</a></li>
                                                <li class=""><a href="#view_gp_product" class="link-show-graph-data" data-toggle="tab">แสดงกราฟ</a></li>
                                            </ul>

                                            <div class="tab-content">
                                                <div class="active tab-pane" id="view_text_product">
                                                    <p>
                                                        <button type="button" class="btn btn-flat bg-blue col-md-1 col-xs-12 pull-right"  onclick="printDiv2('box-content')"><i class="fa fa-print"></i> Print</button>     
                                                    </p>
                                                    <div class="clearfix"></div>
                                                    <div class="table-responsive">
                                                        <table id="report2" class="table table-hover table-bordered" cellspacing="0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>  
                                                                    <th>Type</th>
                                                                    <th>Qty</th>

                                                                </tr>
                                                            </thead>
                                                            <tfoot>
                                                                <tr>
                                                                    <th>No.</th>  
                                                                    <th>Type</th>
                                                                    <th>Qty</th>

                                                                </tr>
                                                            </tfoot>
                                                            <tbody>
                                                                <?php
                                                                $total_sales = 0;
                                                                $menu_type = '';

                                                                foreach ($res_active_order_sales as $key => $row) {

                                                                    // $date = ShowDateTh2($row['formatted_date']);
                                                                    $total_sales = $total_sales + $row['total_price'];
                                                                    if ($row['menu_type'] == 'iced') {
                                                                        $menu_type = 'เย็น';
                                                                    }
                                                                    if ($row['menu_type'] == 'hot') {
                                                                        $menu_type = 'ร้อน';
                                                                    }
                                                                    if ($row['menu_type'] == 'smoothie') {
                                                                        $menu_type = 'ปั่น';
                                                                    }
                                                                    ?>

                                                                    <tr class="">
                                                                        <td><?= $key + 1 ?></td>
                                                                        <td><?= $menu_type ?></td>
                                                                        <td><?= $row['total_qty'] ?></td>


                                                                    </tr>
                                                                <?php } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="info-box hidden">
                                                        <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
                                                        <div class="info-box-content">
                                                            <span class="info-box-text">รวมทั้งหมด</span>
                                                            <span class="info-box-number">฿ <?= $total_sales ?></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane" id="view_gp_product">
                                                    <div class="">
                                                        <button type="button" class="btn btn-flat bg-blue col-md-1 col-xs-12 pull-right"  onclick="print_chart()"><i class="fa fa-print"></i> Print</button>     
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="table-responsive">
                                                        <div class="" style="" id="gp_product">

                                                        </div>
                                                    </div>


                                                </div><!-- /.tab-pane -->
                                            </div>

                                        <?php } ?>
                                        <?php if (($type) == 'หมวดหมู่ขายดี') { ?>

                                            <div class="col-md-12">
                                                <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
                                                        <li class="active show-table-data"><a href="#view_text_product" data-toggle="tab">แสดงข้อมูล</a></li>
                                                        <li class=""><a href="#view_gp_product" class="link-show-graph-data" data-toggle="tab">แสดงกราฟ</a></li>
                                                    </ul>

                                                    <div class="tab-content">
                                                        <div class="active tab-pane" id="view_text_product">
                                                            <p>
                                                                <button type="button" class="btn btn-flat bg-blue col-md-1 col-xs-12 pull-right"  onclick="printDiv2('box-content')"><i class="fa fa-print"></i> Print</button>     
                                                            </p>
                                                            <div class="clearfix"></div>
                                                            <div class="table-responsive">
                                                                <table id="report2" class="table table-hover table-bordered" cellspacing="0" width="100%">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>No.</th>  
                                                                            <th>Category</th>
                                                                            <th>Qty</th>

                                                                        </tr>
                                                                    </thead>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <th>No.</th>  
                                                                            <th>Category</th>
                                                                            <th>Qty</th>

                                                                        </tr>
                                                                    </tfoot>
                                                                    <tbody>
                                                                        <?php
                                                                        $total_sales = 0;
                                                                        $menu_type = '';

                                                                        foreach ($res_active_order_sales as $key => $row) {

                                                                            // $date = ShowDateTh2($row['formatted_date']);
                                                                            $total_sales = $total_sales + $row['total_price'];
//                                                                    if ($row['menu_type'] == 'iced') {
//                                                                        $menu_type = 'เย็น';
//                                                                    }
//                                                                    if ($row['menu_type'] == 'hot') {
//                                                                        $menu_type = 'ร้อน';
//                                                                    }
//                                                                    if ($row['menu_type'] == 'smoothie') {
//                                                                        $menu_type = 'ปั่น';
//                                                                    }
                                                                            ?>

                                                                            <tr class="">
                                                                                <td><?= $key + 1 ?></td>
                                                                                <td><?= $row['category_name'] ?></td>
                                                                                <td><?= $row['total_qty'] ?></td>


                                                                            </tr>
                                                                        <?php } ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            <div class="info-box hidden">
                                                                <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
                                                                <div class="info-box-content">
                                                                    <span class="info-box-text">รวมทั้งหมด</span>
                                                                    <span class="info-box-number">฿ <?= $total_sales ?></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane" id="view_gp_product">
                                                            <div class="">
                                                                <button type="button" class="btn btn-flat bg-blue col-md-1 col-xs-12 pull-right"  onclick="print_chart()"><i class="fa fa-print"></i> Print</button>     
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <div class="table-responsive">
                                                                <div class="" style="" id="gp_product">

                                                                </div>
                                                            </div>


                                                        </div><!-- /.tab-pane -->
                                                    </div>

                                                <?php } ?>
                                                <?php if (($type) == 'สินค้า') { ?>
                                                    <div class="table-responsive" id="">

                                                        <table id="report3" class="table table-bordered" cellspacing="0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>No.</th>  
                                                                    <th>Product</th>
                                                                    <th>Qty</th>

                                                                </tr>
                                                            </thead>
                                                            <tfoot>
                                                                <tr>
                                                                    <th>No.</th>  
                                                                    <th>Product</th>
                                                                    <th>Qty</th>

                                                                </tr>
                                                            </tfoot>

                                                            <tbody>
                                                                <?php
                                                                $total_sales = 0;
                                                                $menu_type = '';

                                                                foreach ($res_active_order_sales as $key => $row) {

                                                                    // $date = ShowDateTh2($row['formatted_date']);
                                                                    $total_sales = $total_sales + $row['total_price'];
                                                                    if ($row['menu_type'] == 'iced') {
                                                                        $menu_type = 'เย็น';
                                                                    }
                                                                    if ($row['menu_type'] == 'hot') {
                                                                        $menu_type = 'ร้อน';
                                                                    }
                                                                    if ($row['menu_type'] == 'smoothie') {
                                                                        $menu_type = 'ปั่น';
                                                                    }
                                                                    ?>

                                                                    <tr class="">
                                                                        <td><?= $key + 1 ?></td>
                                                                        <td><?= $row['product'] . ' (' . $menu_type . ')' ?></td>
                                                                        <td><?= $row['total_qty'] ?></td>

                                                                    </tr>
                                                                <?php } ?>

                                                            </tbody>
                                                        </table>
                                                    </div>
                                                <?php } ?>
                                                <?php if (($type) == 'Topping ขายดี') { ?>
                                                    <div class="col-md-12">
                                                        <div class="nav-tabs-custom">
                                                            <ul class="nav nav-tabs">
                                                                <li class=""><a href="#view_text_topping" data-toggle="tab">แสดงข้อมูล</a></li>
                                                                <li class="active"><a href="#view_gp_topping" class="link-show-graph-data" data-toggle="tab" >แสดงกราฟ</a></li>
                                                            </ul>

                                                            <div class="tab-content">
                                                                <div class=" tab-pane" id="view_text_topping">
                                                                    <p>
                                                                        <button type="button" class="btn btn-flat bg-blue col-md-1 col-xs-12 pull-right"  onclick="printDiv2('box-content')"><i class="fa fa-print"></i> Print</button>     
                                                                    </p>
                                                                    <div class="clearfix"></div>
                                                                    <div class="table-responsive">
                                                                        <table id="report4" class="table table-hover table-bordered" cellspacing="0" width="100%">
                                                                            <thead>
                                                                                <tr>
                                                                                    <th>No.</th>  
                                                                                    <th>Topping</th>
                                                                                    <th>Qty</th>

                                                                                </tr>
                                                                            </thead>
                                                                            <tfoot>
                                                                                <tr>
                                                                                    <th>No.</th>  
                                                                                    <th>Topping</th>
                                                                                    <th>Qty</th>

                                                                                </tr>
                                                                            </tfoot>
                                                                            <tbody>
                                                                                <?php
                                                                                $total_sales = 0;
                                                                                foreach ($res_active_order_sales as $key => $row) {

                                                                                    // $date = ShowDateTh2($row['formatted_date']);
                                                                                    $total_sales = $total_sales + $row['total'];
                                                                                    ?>

                                                                                    <tr class="">
                                                                                        <td><?= $key + 1 ?></td>
                                                                                        <td><?= $row['topping'] ?></td>
                                                                                        <td><?= $row['cnt_topping'] ?></td>


                                                                                    </tr>
                                                                                <?php } ?>


                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="info-box hidden">
                                                                        <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
                                                                        <div class="info-box-content">
                                                                            <span class="info-box-text">รวมทั้งหมด</span>
                                                                            <span class="info-box-number">฿ <?= $total_sales ?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="active tab-pane" id="view_gp_topping">
                                                                    <div class="">
                                                                        <button type="button" class="btn btn-flat bg-blue col-md-1 col-xs-12 pull-right"  onclick="print_chart()"><i class="fa fa-print"></i> Print</button>     
                                                                    </div>
                                                                    <div class="clearfix"></div>
                                                                    <div class="table-responsive">
                                                                        <div class="" style="width: 85%;" id="gp_topping">

                                                                        </div>
                                                                    </div>


                                                                </div><!-- /.tab-pane -->

                                                            </div>
                                                        </div>
                                                    </div>



                                                <?php } ?>
                                                <?php if (($type) == 'Order') { ?>
                                                    <p>
                                                        <button type="button" class="btn btn-flat bg-blue col-md-1 col-xs-12 pull-right"  onclick="printDiv2('box-content')"><i class="fa fa-print"></i> Print</button>     
                                                    </p>
                                                    <div class="clearfix"></div>
                                                    <?php if (($detail) == 'OrderDetail') { ?>

                                                        <div class="col-md-12 col-xs-12 hidden">
                                                            <div class="form-inline">
                                                                <button type="button" id="btn_back" class="btn btn-flat bg-blue col-md-1 col-xs-12"><i class="fa fa-arrow-left"></i>&nbsp; Back </button>
                                                            </div>
                                                        </div>
                                                        <p>&nbsp;</p>


                                                        <div class="col-md-12">
                                                            <div class="nav-tabs-custom">
                                                                <ul class="nav nav-tabs">
                                                                    <li class="active"><a href="#view_text" data-toggle="tab" aria-expanded="true">แสดงข้อมูล</a></li>
                                                                    <li class="hidden"><a href="#view_gp" data-toggle="tab" aria-expanded="false">แสดงกราฟ</a></li>

                                                                </ul>

                                                                <div class="tab-content">
                                                                    <div class="active  tab-pane" id="view_text">
                                                                        <section class="">
                                                                            <!-- title row -->
                                                                            <div class="row">
                                                                                <div class="col-xs-12">
                                                                                    <h2 class="page-header">
                                                                                        <b>Order ID:</b> <?= $res_active_order_sales[0]['order_id'] ?>

                                                                                        <small class="pull-right">Order Date: <?= $res_active_order_sales[0]['order_date'] ?></small>
                                                                                    </h2>
                                                                                </div><!-- /.col -->
                                                                            </div>
                                                                            <!-- info row -->
                                                                            <div class="row invoice-info">

                                                                                <div class="col-md-12 invoice-col">

                                                                                    <b>Cashier:</b> <?= $res_active_order_sales[0]['cashier_name'] ?>

                                                                                </div><!-- /.col -->
                                                                            </div><!-- /.row -->

                                                                            <!-- Table row -->
                                                                            <div class="row">
                                                                                <div class="col-md-12 text-center">
                                                                                    <b>รายการ</b> 
                                                                                </div>
                                                                                <div class="col-md-12 table-responsive">
                                                                                    <table class="table table-condensed">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th style="width: 40px;" class="text-center">Qty</th>
                                                                                                <th style="width: 150px;" class="text-left">Product</th>
                                                                                                <th style="width: 150px;" class="text-left">หมายเหตุ</th>
                                                                                                <th style="width: 50px;" class="text-right ">Price</th>
                                                                                                <th style="width: 100px;" class="text-right">Ext.Price</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                            <?php
                                                                                            $grand_total = 0;
                                                                                            foreach ($res_active_order_sales as $key => $row) {
                                                                                                $total_sales = 0;
                                                                                                $total_sales_topping = 0;
                                                                                                ?>
                                                                                                <tr data-active-order-detail-id="444" data-qty="1" data-detail-active_order_id="195" data-detail-menu_id="1" data-detail-menu_type="iced">
                                                                                                    <td class="text-center text-bold" style="font-size: 16px;">
                                                                                                        <p style="color: blue;"><?= $row['qty'] ?></p>
                                                                                                    </td>
                                                                                                    <td style="font-size: 16px;">
                                                                                                        <div class="row">
                                                                                                            <div class="col-md-12">
                                                                                                                <span id="menu-name"><?= $row['product'] ?>  (<?= $row['menu_type'] ?> )</span> 
                                                                                                                <div class="col-md-12">
                                                                                                                    <ul class="text-topping">

                                                                                                                        <?php
                                                                                                                        if ($row['topping_list'] != '') {
                                                                                                                            foreach ($row['topping_list'] as $key => $row2) {
                                                                                                                                ?>
                                                                                                                                <li class="">+ <?= $row2['topping'] ?></li>
                                                                                                                            <?php } ?>
                                                                                                                        <?php } ?>
                                                                                                                    </ul>
                                                                                                                </div>
                                                                                                            </div>

                                                                                                        </div>
                                                                                                    </td>
                                                                                                    <td class="" style="font-size: 13px;"><?= $row['comment'] ?></td>
                                                                                                    <td class="" style="font-size: 16px;">
                                                                                                        <div id="" class="text-right">฿ <?= $row['price'] ?>.00</div>
                                                                                                        <ul class="">
                                                                                                            <?php
                                                                                                            if ($row['topping_list'] != '') {
                                                                                                                foreach ($row['topping_list'] as $key => $row2) {
                                                                                                                    $total_sales_topping = $total_sales_topping + $row2['price'];
                                                                                                                    ?>
                                                                                                                    <li class="text-left">+ ฿<?= $row2['price'] ?>.00</li>
                                                                                                                <?php } ?>
                                                                                                            <?php } ?>
                                                                                                        </ul>
                                                                                                    </td>
                                                                                                    <?php
                                                                                                    $total_sales = ($total_sales_topping + $row['price'] ) * $row['qty'];
                                                                                                    $grand_total = $grand_total + $total_sales;
                                                                                                    ?>
                                                                                                    <td class="text-right text-bold" style="font-size: 16px;">฿ <?= $total_sales ?>.00</td>
                                                                                                </tr>
                                                                                            <?php } ?>
                                                                                            <tr class="bg-warning">

                                                                                                <td colspan="4" style="font-size: 16px;"><b>Total:</b></td>
                                                                                                <td style="font-size: 16px;text-align: right;"><b>฿ <?= $grand_total ?>.00</b></td>
                                                                                            </tr>

                                                                                        </tbody>
                                                                                    </table>
                                                                                </div><!-- /.col -->
                                                                            </div><!-- /.row -->
                                                                        </section><!-- /.content -->
                                                                    </div><!-- /.tab-pane -->
                                                                    <div class="tab-pane active" id="view_gp">
                                                                    </div><!-- /.tab-pane -->
                                                                </div><!-- /.tab-content -->
                                                            </div><!-- /.nav-tabs-custom -->
                                                        </div>

                                                    <?php } else { ?>

                                                        <table id="example2" class="display" cellspacing="0" width="100%">
                                                            <thead>
                                                                <tr>
                                                                    <th></th>
                                                                    <th class="text-center">OrderID</th>
                                                                    <th class="text-center">Grand total</th>
                                                                    <th class="text-center">Order Date</th>

                                                                    <th class="text-center">Cashier Name</th>
                                                                    <th class="text-center td-condition">ตัวเลือก</th>


                                                                </tr>
                                                            </thead>
                                                            <tfoot>
                                                                <tr>
                                                                    <th></th>
                                                                    <th class="text-center">OrderID</th>
                                                                    <th class="text-center">Grand total</th>
                                                                    <th class="text-center">Order Date</th>
                                                                    <th class="text-center">Cashier Name</th>
                                                                    <th class="text-center td-condition">ตัวเลือก</th>
                                                                </tr>
                                                            </tfoot>
                                                            <tbody>
                                                                <?php
                                                                $total_sales = 0;
                                                                foreach ($res_active_order_sales as $key => $row) {
                                                                    ?>

                                                                    <tr class="">
                                                                        <td class="text-center"><?= $key + 1 ?></td>
                                                                        <td class="text-center"><?= $row['order_id'] ?></td>
                                                                        <td class="text-center"><?= $row['total_price'] ?></td>
                                                                        <td class="text-center"><?= $row['order_date'] ?></td>
                                                                        <td class="text-center"> <?= $row['cashier_name'] ?></td>
                                                                        <td class="text-center td-condition"> <a href="<?= base_url('report/sales/Order/' . $row['id']) ?>" class="btn-sm btn btn-info">ดูรายละเอียด</a></td>

                                                                    </tr>
                                                                <?php } ?>


                                                            </tbody>
                                                        </table>
                                                    <?php } ?>
                                                <?php } ?>

                                            </div>
                                        </div>
                                        </form>
                                    </div><!-- /.col -->
                                </div><!-- /.row -->
                                </section><!-- /.content -->

                                <input type="hidden" id="kk">

                                <script>
                                    function printContent(el) {
                                        $(document).ready(function () {
                                            var restorepage = document.body.innerHTML;
                                            var printcontent = document.getElementById(el).innerHTML;
                                            document.body.innerHTML = printcontent;
                                            if (printcontent !== '') {
                                                window.print();
                                                document.body.innerHTML = restorepage;
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
                                </script>

                                <script>
                                    var tool_date = $('.tools_date');
                                    var tool_month = $('.tools_month');
                                    var tool_year = $('.tools_year');

                                    tool_month.hide();
                                    tool_year.hide();
                                    tool_date.hide();

<?php if ($report_range != '') { ?>
    <?php if ($report_range == 'ตามช่วงเวลา') { ?>
                                            tool_date.show();
    <?php } ?>
    <?php if ($report_range == 'ตามช่วงเดือน') { ?>
                                            tool_month.show();
    <?php } ?>
    <?php if ($report_range == 'ตามช่วงปี') { ?>
                                            tool_year.show();
    <?php } ?>
<?php } ?>



                                    function report_ranges(ele) {
                                       
                                        var val = $(ele).val();

                                        if (val == 'ตามช่วงเวลา') {
                                            tool_date.show();
                                            tool_month.hide();
                                            tool_year.hide();

                                        } else if (val == 'ตามช่วงเดือน') {
                                            tool_date.hide();
                                            tool_year.hide();
                                            tool_month.show();


                                        } else if (val == 'ตามช่วงปี') {
                                            tool_date.hide();
                                            tool_month.hide();
                                            tool_year.show();

                                        } else {
                                            tool_date.hide();
                                            tool_month.hide();
                                            tool_year.hide();
                                        }
                                    }

                                    $(document).ready(function () {

//
//                                         $("#reservation").datepicker({
//                                            dateFormat: 'yy-mm-dd'    
//                                        });  
                                        $("#reservation").datepick({dateFormat: 'yyyy-mm-dd'});

//                                          $('#reservation').daterangepicker({
//                                            singleDatePicker: true,
//                                            showDropdowns: true,
//                                            format: "Y-mm",
//                                        }, 
//                                        function(start, end, label) {
//                                           // var years = moment().diff(start, 'years');
//                                           // alert("You are " + years + " years old.");
//                                        });

  

                                        $('#daterange_month_start').datepicker({
                                            format: "yyyy-mm",
                                            changeYear: false,
                                            viewMode: "months",
                                            minViewMode: "months",
                                        }).datepicker('setDate', 'today');
                                        
         
                                        
                                        
                                        
                                        //   $('#daterange_month_start').datepicker().;
        //                                $('#daterange_month_end').datepicker({
        //                                    format: "yyyy-mm",
        //                                    changeYear: false,
        //                                    viewMode: "months",
        //                                    minViewMode: "months"
        //                                }).datepicker('setDate', 'today');

                                        $('#daterange_year_start').datepicker({
                                            format: "yyyy",
                                            changeYear: false,
                                            viewMode: "years",
                                            minViewMode: "years"
                                        }).datepicker('setDate', 'today');
        //
        //                                $('#daterange_year_end').datepicker({
        //                                    format: "yyyy",
        //                                    changeYear: false,
        //                                    viewMode: "years",
        //                                    minViewMode: "years"
        //                                }).datepicker('setDate', 'today');

                                    });
                                </script>


                                <script src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
                                <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js "></script>



                                <style>
                                    .ui-datepicker-calendar {

                                        display: none;

                                    }​

                                    td.details-control {
                                        background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
                                        cursor: pointer;
                                    }
                                    tr.shown td.details-control {
                                        background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
                                    }

                                </style>
                                <pre id="csv" style="display:none">
                                    <?php
                                    if ($type == 'Topping ขายดี') {
                                        if (isset($res_chart)) {
                                            // cnt_topping topping
                                            echo ",จำนวน" . "\n";
                                            foreach ($res_chart as $value) {
                                                echo $value['topping'] . ',' . $value['cnt_topping'] . "\n";
                                            }
                                        }
                                    }
                                    if ($type == 'สินค้าขายดี') {
                                        if (isset($res_chart)) {
                                            // cnt_topping topping
                                            echo ",จำนวน" . "\n";
                                            $menu_type = '';
                                            foreach ($res_chart as $value) {
                                                if ($value['menu_type'] == 'iced') {
                                                    $menu_type = ' เย็น';
                                                }
                                                if ($value['menu_type'] == 'hot') {
                                                    $menu_type = ' ร้อน';
                                                }
                                                if ($value['menu_type'] == 'smoothie') {
                                                    $menu_type = ' ปั่น';
                                                }
                                                echo $value['product'] . ',' . $value['total_qty'] . "\n";
                                            }
                                        }
                                    }
                                    if ($type == 'ประเภทสินค้าขายดี') {
                                        if (isset($res_chart)) {
                                            // cnt_topping topping
                                            echo ",จำนวน" . "\n";
                                            $menu_type = '';
                                            foreach ($res_chart as $value) {
                                                if ($value['menu_type'] == 'iced') {
                                                    $menu_type = ' เย็น';
                                                }
                                                if ($value['menu_type'] == 'hot') {
                                                    $menu_type = ' ร้อน';
                                                }
                                                if ($value['menu_type'] == 'smoothie') {
                                                    $menu_type = ' ปั่น';
                                                }
                                                echo $menu_type . ',' . $value['total_qty'] . "\n";
                                            }
                                        }
                                    }
                                    if ($type == 'หมวดหมู่ขายดี') {
                                        if (isset($res_chart)) {
                                            // cnt_topping topping
                                            echo ",จำนวน" . "\n";
                                            $menu_type = '';
                                            foreach ($res_chart as $value) {
//                                        if ($value['menu_type'] == 'iced') {
//                                            $menu_type = ' เย็น';
//                                        }
//                                        if ($value['menu_type'] == 'hot') {
//                                            $menu_type = ' ร้อน';
//                                        }
//                                        if ($value['menu_type'] == 'smoothie') {
//                                            $menu_type = ' ปั่น';
//                                        }
                                                echo $value['category_name'] . ',' . $value['total_qty'] . "\n";
                                            }
                                        }
                                    }
                                    ?>

                                </pre>
                                <script>


                                    var chart1, chart2;
                                    function set_chart(datas) {

                                        //ยอดขาย
<?php if (($type) == 'ยอดขาย') { ?>
    <?php if (($report_range) == 'ตามช่วงเวลา') { ?>
                                                var data = $.parseJSON(datas);
                                                var arrx;
                                                var arrx2 = [];
                                                $.each(data, function (index, value) {
                                                    arrx = [
                                                        value.menu_name, parseInt(value.total)
                                                    ];
                                                    arrx2.push(arrx);
                                                });
                                                //  console.log(arrx2);
                                                Highcharts.setOptions({
                                                    lang: {
                                                        decimalPoint: '.',
                                                        thousandsSep: ','
                                                    }
                                                });

                                                chart1 = new Highcharts.Chart({
                                                    chart: {
                                                        type: 'column',
                                                        renderTo: 'gp',
                                                        //  shadow: true
                                                    },
                                                    title: {
                                                        text: 'ยอดขาย'
                                                    },
                                                    subtitle: {
                                                        text: '<?= isset($duration) ? $duration : '' ?>'

                                                    },
                                                    xAxis: {
                                                        type: 'category',
                                                        labels: {
                                                            rotation: -45,
                                                            style: {
                                                                fontSize: '12px',
                                                                fontFamily: 'Verdana, sans-serif'
                                                            }
                                                        }
                                                    },
                                                    yAxis: {
                                                        min: 0,
                                                        title: {
                                                            text: 'Bath'
                                                        }
                                                    },
                                                    legend: {
                                                        enabled: false
                                                    },
                                                    tooltip: {
                                                        pointFormat: "รวมทั้งสิ้น <b>{point.y:','.2f} บาท</b>"
                                                    },
                                                    exporting: {
                                                        enabled: false
                                                    },
                                                    series: [{
                                                            name: 'Population',
                                                            data: arrx2,
                                                            dataLabels: {
                                                                enabled: true,
                                                                rotation: 0,
                                                                color: '#000',
                                                                align: 'center',
                                                                //    format: "{point.y:','.2f}", // one decimal
                                                                y: 20, // 10 pixels down from the top
                                                                style: {
                                                                    fontSize: '12px',
                                                                    fontFamily: 'Verdana, sans-serif'
                                                                }
                                                            }
                                                        }]
                                                });

                                                chart2 = new Highcharts.Chart({
                                                    chart: {
                                                        type: 'line',
                                                        renderTo: 'gp2',
                                                        // shadow: true
                                                    },
                                                    title: {
                                                        text: ' '
                                                    },
                                                    subtitle: {
                                                        text: ''

                                                    },
                                                    xAxis: {
                                                        type: 'category',
                                                        labels: {
                                                            rotation: -45,
                                                            style: {
                                                                fontSize: '12px',
                                                                fontFamily: 'Verdana, sans-serif'
                                                            }
                                                        }
                                                    },
                                                    yAxis: {
                                                        min: 0,
                                                        title: {
                                                            text: 'Bath'
                                                        }
                                                    },
                                                    legend: {
                                                        enabled: false
                                                    },
                                                    tooltip: {
                                                        pointFormat: "รวมทั้งสิ้น <b>{point.y:','.2f} บาท</b>"
                                                    },
                                                    exporting: {
                                                        enabled: false
                                                    },
                                                    series: [{
                                                            name: 'Population',
                                                            data: arrx2,
                                                            dataLabels: {
                                                                enabled: true,
                                                                rotation: 0,
                                                                color: '#000',
                                                                align: 'center',
                                                                //    format: "{point.y:','.2f}", // one decimal
                                                                y: 20, // 10 pixels down from the top
                                                                style: {
                                                                    fontSize: '12px',
                                                                    fontFamily: 'Verdana, sans-serif'
                                                                }
                                                            }
                                                        }]
                                                });

    <?php } ?>
    <?php if (($report_range) == 'ตามช่วงเดือน') { ?>

                                                var res_graph = '<?= $res_graph ?>';

                                                var data = $.parseJSON(res_graph);

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

                                                // console.log(price);
                                                // return false;
                                                Highcharts.setOptions({
                                                    lang: {
                                                        decimalPoint: '.',
                                                        thousandsSep: ','
                                                    }
                                                });

                                                chart1 = new Highcharts.Chart({
                                                    chart: {
                                                        type: 'column',
                                                        renderTo: 'gp',
                                                        //  shadow: true
                                                    },
                                                    title: {
                                                        text: 'ยอดขาย'
                                                    },
                                                    subtitle: {
                                                        text: '<?= isset($duration) ? $duration : '' ?>'

                                                    },
                                                    xAxis: {
                                                        categories: list,
                                                        type: 'category',
                                                        labels: {
                                                            //   rotation: -45,
                                                            style: {
                                                                fontSize: '12px',
                                                                fontFamily: 'Verdana, sans-serif'
                                                            }
                                                        }
                                                    },
                                                    yAxis: {
                                                        min: 0,
                                                        title: {
                                                            text: 'Bath'
                                                        }
                                                    },
                                                    legend: {
                                                        enabled: false
                                                    },
                                                    tooltip: {
                                                        pointFormat: "รวมทั้งสิ้น <b>{point.y:','.2f} บาท</b>"
                                                    },
                                                    exporting: {
                                                        enabled: false
                                                    },
                                                    series: [{
                                                            name: 'Population',
                                                            data: price,
                                                            dataLabels: {
                                                                enabled: true,
                                                                rotation: 0,
                                                                color: '#000',
                                                                align: 'center',
                                                                //  format: "{point.y:','.2f}", // one decimal
                                                                // y: 20, // 10 pixels down from the top
                                                                style: {
                                                                    fontSize: '12px',
                                                                    fontFamily: 'Verdana, sans-serif'
                                                                },
                                                                formatter: function () {
                                                                    if (this.y > 0) {
                                                                        return  Highcharts.numberFormat(this.y, 0, '.');
                                                                    }
                                                                }
                                                            }

                                                        }]
                                                });
                                                chart2 = new Highcharts.Chart({
                                                    chart: {
                                                        type: 'line',
                                                        renderTo: 'gp2',
                                                    },
                                                    title: {
                                                        text: ' '
                                                    },
                                                    subtitle: {
                                                        text: ''

                                                    },
                                                    xAxis: {
                                                        categories: list,
                                                        type: 'category',
                                                        labels: {
                                                            //   rotation: -45,
                                                            style: {
                                                                fontSize: '12px',
                                                                fontFamily: 'Verdana, sans-serif'
                                                            }
                                                        }
                                                    },
                                                    yAxis: {
                                                        min: 0,
                                                        title: {
                                                            text: 'Bath'
                                                        }
                                                    },
                                                    legend: {
                                                        enabled: false
                                                    },
                                                    tooltip: {
                                                        pointFormat: "รวมทั้งสิ้น <b>{point.y:','.2f} บาท</b>"
                                                    },
                                                    exporting: {
                                                        enabled: false
                                                    },
                                                    series: [{
                                                            name: 'Population',
                                                            data: price,
                                                            dataLabels: {
                                                                enabled: true,
                                                                rotation: 0,
                                                                color: '#000',
                                                                align: 'center',
                                                                //  format: "{point.y:','.2f}", // one decimal
                                                                // y: 20, // 10 pixels down from the top
                                                                style: {
                                                                    fontSize: '12px',
                                                                    fontFamily: 'Verdana, sans-serif'
                                                                },
                                                                formatter: function () {
                                                                    if (this.y > 0) {
                                                                        return  Highcharts.numberFormat(this.y, 0, '.');
                                                                    }
                                                                }
                                                            }

                                                        }]
                                                });



    <?php } ?>
    <?php if (($report_range) == 'ตามช่วงปี') { ?>

                                                var res_graph = '<?= $res_graph ?>';

                                                var data = $.parseJSON(res_graph);

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

                                                // console.log(price);
                                                // return false;
                                                Highcharts.setOptions({
                                                    lang: {
                                                        decimalPoint: '.',
                                                        thousandsSep: ','
                                                    }
                                                });

                                                chart1 = new Highcharts.Chart({
                                                    chart: {
                                                        type: 'column',
                                                        renderTo: 'gp',
                                                        //  shadow: true
                                                    },
                                                    title: {
                                                        text: 'ยอดขาย'
                                                    },
                                                    subtitle: {
                                                        text: '<?= isset($duration) ? $duration : '' ?>'

                                                    },
                                                    xAxis: {
                                                        categories: list,
                                                        type: 'category',
                                                        labels: {
                                                            //   rotation: -45,
                                                            style: {
                                                                fontSize: '12px',
                                                                fontFamily: 'Verdana, sans-serif'
                                                            }
                                                        }
                                                    },
                                                    yAxis: {
                                                        min: 0,
                                                        title: {
                                                            text: 'Bath'
                                                        }
                                                    },
                                                    legend: {
                                                        enabled: false
                                                    },
                                                    tooltip: {
                                                        pointFormat: "รวมทั้งสิ้น <b>{point.y:','.2f} บาท</b>"
                                                    },
                                                    exporting: {
                                                        enabled: false
                                                    },
                                                    series: [{
                                                            name: 'Population',
                                                            data: price,
                                                            dataLabels: {
                                                                enabled: true,
                                                                rotation: 0,
                                                                color: '#000',
                                                                align: 'center',
                                                                //  format: "{point.y:','.2f}", // one decimal
                                                                // y: 20, // 10 pixels down from the top
                                                                style: {
                                                                    fontSize: '12px',
                                                                    fontFamily: 'Verdana, sans-serif'
                                                                },
                                                                formatter: function () {
                                                                    if (this.y > 0) {
                                                                        return  Highcharts.numberFormat(this.y, 0, '.');
                                                                    }
                                                                }
                                                            }

                                                        }]
                                                });
                                                chart2 = new Highcharts.Chart({
                                                    chart: {
                                                        type: 'line',
                                                        renderTo: 'gp2',
                                                        //  shadow: true
                                                    },
                                                    title: {
                                                        text: ' '
                                                    },
                                                    subtitle: {
                                                        text: ''

                                                    },
                                                    xAxis: {
                                                        categories: list,
                                                        type: 'category',
                                                        labels: {
                                                            //   rotation: -45,
                                                            style: {
                                                                fontSize: '12px',
                                                                fontFamily: 'Verdana, sans-serif'
                                                            }
                                                        }
                                                    },
                                                    yAxis: {
                                                        min: 0,
                                                        title: {
                                                            text: 'Bath'
                                                        }
                                                    },
                                                    legend: {
                                                        enabled: false
                                                    },
                                                    tooltip: {
                                                        pointFormat: "รวมทั้งสิ้น <b>{point.y:','.2f} บาท</b>"
                                                    },
                                                    exporting: {
                                                        enabled: false
                                                    },
                                                    series: [{
                                                            name: 'Population',
                                                            data: price,
                                                            dataLabels: {
                                                                enabled: true,
                                                                rotation: 0,
                                                                color: '#000',
                                                                align: 'center',
                                                                //  format: "{point.y:','.2f}", // one decimal
                                                                // y: 20, // 10 pixels down from the top
                                                                style: {
                                                                    fontSize: '12px',
                                                                    fontFamily: 'Verdana, sans-serif'
                                                                },
                                                                formatter: function () {
                                                                    if (this.y > 0) {
                                                                        return  Highcharts.numberFormat(this.y, 0, '.');
                                                                    }
                                                                }
                                                            }

                                                        }]
                                                });



    <?php } ?>
<?php } ?>

                                        //ช่วงเวลาขายดี
<?php if (($type) == 'ช่วงเวลาขายดี') { ?>
    <?php if (($report_range) == 'ตามช่วงเวลา' || $report_range == 'ตามช่วงเดือน' || $report_range == 'ตามช่วงปี') { ?>
                                                var res_graph = '<?= $res_graph ?>';

                                                var data = $.parseJSON(res_graph);

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

                                                // console.log(price);
                                                // return false;
                                                Highcharts.setOptions({
                                                    lang: {
                                                        decimalPoint: '.',
                                                        thousandsSep: ','
                                                    }
                                                });

                                                chart1 = new Highcharts.Chart({
                                                    chart: {
                                                        type: 'column',
                                                        renderTo: 'gp',
                                                        //  shadow: true
                                                    },
                                                    title: {
                                                        text: 'ช่วงเวลาขายดี'
                                                    },
                                                    subtitle: {
                                                        text: '<?= isset($duration) ? $duration : '' ?>'

                                                    },
                                                    xAxis: {
                                                        categories: list,
                                                        type: 'category',
                                                        labels: {
                                                            //    rotation: -45,
                                                            style: {
                                                                fontSize: '10px',
                                                                fontFamily: 'Verdana, sans-serif'
                                                            }
                                                        }
                                                    },
                                                    yAxis: {
                                                        min: 0,
                                                        title: {
                                                            text: 'Bath'
                                                        }
                                                    },
                                                    legend: {
                                                        enabled: false
                                                    },
                                                    tooltip: {
                                                        pointFormat: "รวมทั้งสิ้น <b>{point.y:','.2f} บาท</b>"
                                                    },
                                                    exporting: {
                                                        enabled: false
                                                    },
                                                    series: [{
                                                            name: 'Population',
                                                            data: price,
                                                            dataLabels: {
                                                                enabled: true,
                                                                rotation: 0,
                                                                color: '#000',
                                                                align: 'center',
                                                                //  format: "{point.y:','.2f}", // one decimal
                                                                // y: 20, // 10 pixels down from the top
                                                                style: {
                                                                    fontSize: '12px',
                                                                    fontFamily: 'Verdana, sans-serif'
                                                                },
                                                                formatter: function () {
                                                                    if (this.y > 0) {
                                                                        return  Highcharts.numberFormat(this.y, 0, '.');
                                                                    }
                                                                }
                                                            }

                                                        }]
                                                });


                                                chart2 = new Highcharts.Chart({
                                                    chart: {
                                                        type: 'line',
                                                        renderTo: 'gp2',
                                                        //  shadow: true
                                                    },
                                                    title: {
                                                        text: ' '
                                                    },
                                                    subtitle: {
                                                        text: ''

                                                    },
                                                    xAxis: {
                                                        categories: list,
                                                        type: 'category',
                                                        labels: {
                                                            //   rotation: -45,
                                                            style: {
                                                                fontSize: '10px',
                                                                fontFamily: 'Verdana, sans-serif'
                                                            }
                                                        }
                                                    },
                                                    yAxis: {
                                                        min: 0,
                                                        title: {
                                                            text: 'Bath'
                                                        }
                                                    },
                                                    legend: {
                                                        enabled: false
                                                    },
                                                    tooltip: {
                                                        pointFormat: "รวมทั้งสิ้น <b>{point.y:','.2f} บาท</b>"
                                                    },
                                                    exporting: {
                                                        enabled: false
                                                    },
                                                    series: [{
                                                            name: 'Population',
                                                            data: price,
                                                            dataLabels: {
                                                                enabled: true,
                                                                rotation: 0,
                                                                color: '#000',
                                                                align: 'center',
                                                                //  format: "{point.y:','.2f}", // one decimal
                                                                // y: 20, // 10 pixels down from the top
                                                                style: {
                                                                    fontSize: '12px',
                                                                    fontFamily: 'Verdana, sans-serif'
                                                                },
                                                                formatter: function () {
                                                                    if (this.y > 0) {
                                                                        return  Highcharts.numberFormat(this.y, 0, '.');
                                                                    }
                                                                }
                                                            }

                                                        }]
                                                });



    <?php } ?>

<?php } ?>
                                        //สินค้า
<?php if (($type) == 'สินค้าขายดี') { ?>

                                            Highcharts.setOptions({
                                                lang: {
                                                    decimalPoint: '.',
                                                    thousandsSep: ','
                                                }
                                            });



                                            chart1 = new Highcharts.Chart({
                                                chart: {
                                                    type: 'pie',
                                                    renderTo: 'gp_product',
                                                    //  shadow: true
                                                },
                                                title: {
                                                    text: 'สินค้าขายดี '
                                                },
                                                subtitle: {
                                                    text: '<?= isset($duration) ? $duration : '' ?>'
                                                },
                                                data: {
                                                    csv: document.getElementById('csv').innerHTML
                                                },
                                                exporting: {
                                                    enabled: false
                                                },
                                                plotOptions: {
                                                    pie: {
                                                        allowPointSelect: true,
                                                        cursor: 'pointer',
                                                        dataLabels: {
                                                            enabled: true,
                                                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                                            style: {
                                                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                                            }
                                                        }
                                                    }
                                                },
                                                yAxis: {
                                                    min: 0,
                                                    title: {
                                                        text: 'แก้ว'
                                                    }
                                                },
                                                tooltip: {
                                                    headerFormat: '<span style="font-size:13px">{point.key}</span><table>',
                                                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                                            '<td style="padding:0"><b>{point.y:",".0f}</b></td></tr>',
                                                    footerFormat: '</table>',
                                                    shared: true,
                                                    useHTML: true
                                                },
                                                series: []
                                            });
<?php } ?>
<?php if (($type) == 'ประเภทสินค้าขายดี') { ?>

                                            Highcharts.setOptions({
                                                lang: {
                                                    decimalPoint: '.',
                                                    thousandsSep: ','
                                                }
                                            });

                                            chart1 = new Highcharts.Chart({
                                                chart: {
                                                    type: 'pie',
                                                    renderTo: 'gp_product',
                                                    //  shadow: true
                                                },
                                                title: {
                                                    text: 'ประเภทขายดี'
                                                },
                                                subtitle: {
                                                    text: '<?= isset($duration) ? $duration : '' ?>'
                                                },
                                                data: {
                                                    csv: document.getElementById('csv').innerHTML
                                                },
                                                exporting: {
                                                    enabled: false
                                                },
                                                plotOptions: {
                                                    pie: {
                                                        allowPointSelect: true,
                                                        cursor: 'pointer',
                                                        dataLabels: {
                                                            enabled: true,
                                                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                                            style: {
                                                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                                            }
                                                        }
                                                    }
                                                },
                                                yAxis: {
                                                    min: 0,
                                                    title: {
                                                        text: 'แก้ว'
                                                    }
                                                },
                                                tooltip: {
                                                    headerFormat: '<span style="font-size:13px">{point.key}</span><table>',
                                                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                                            '<td style="padding:0"><b>{point.y:",".0f}</b></td></tr>',
                                                    footerFormat: '</table>',
                                                    shared: true,
                                                    useHTML: true
                                                },
                                                series: []
                                            });
<?php } ?>

<?php if (($type) == 'หมวดหมู่ขายดี') { ?>

                                            Highcharts.setOptions({
                                                lang: {
                                                    decimalPoint: '.',
                                                    thousandsSep: ','
                                                }
                                            });

                                            chart1 = new Highcharts.Chart({
                                                chart: {
                                                    type: 'pie',
                                                    renderTo: 'gp_product',
                                                    //  shadow: true
                                                },
                                                title: {
                                                    text: 'หมวดหมู่ขายดี'
                                                },
                                                subtitle: {
                                                    text: '<?= isset($duration) ? $duration : '' ?>'
                                                },
                                                data: {
                                                    csv: document.getElementById('csv').innerHTML
                                                },
                                                exporting: {
                                                    enabled: false
                                                },
                                                plotOptions: {
                                                    pie: {
                                                        allowPointSelect: true,
                                                        cursor: 'pointer',
                                                        dataLabels: {
                                                            enabled: true,
                                                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                                            style: {
                                                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                                            }
                                                        }
                                                    }
                                                },
                                                yAxis: {
                                                    min: 0,
                                                    title: {
                                                        text: 'แก้ว'
                                                    }
                                                },
                                                tooltip: {
                                                    headerFormat: '<span style="font-size:13px">{point.key}</span><table>',
                                                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                                            '<td style="padding:0"><b>{point.y:",".0f}</b></td></tr>',
                                                    footerFormat: '</table>',
                                                    shared: true,
                                                    useHTML: true
                                                },
                                                series: []
                                            });
<?php } ?>
                                        //topping
<?php if (($type) == 'Topping ขายดี') { ?>

                                            Highcharts.setOptions({
                                                lang: {
                                                    decimalPoint: '.',
                                                    thousandsSep: ','
                                                }
                                            });



                                            chart1 = new Highcharts.Chart({
                                                chart: {
                                                    type: 'pie',
                                                    renderTo: 'gp_topping',
                                                    //  shadow: true
                                                },
                                                title: {
                                                    text: 'Topping ขายดี'
                                                },
                                                subtitle: {
                                                    text: '<?= isset($duration) ? $duration : '' ?>'
                                                },
                                                data: {
                                                    csv: document.getElementById('csv').innerHTML
                                                },
                                                exporting: {
                                                    enabled: false
                                                },
                                                plotOptions: {
                                                    pie: {
                                                        allowPointSelect: true,
                                                        cursor: 'pointer',
                                                        dataLabels: {
                                                            enabled: true,
                                                            format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                                                            style: {
                                                                color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                                                            }
                                                        }
                                                    }
                                                },
                                                yAxis: {
                                                    min: 0,
                                                    title: {
                                                        text: 'Values'
                                                    }
                                                },
                                                tooltip: {
                                                    headerFormat: '<span style="font-size:13px">{point.key}</span><table>',
                                                    pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                                                            '<td style="padding:0"><b>{point.y:",".0f}</b></td></tr>',
                                                    footerFormat: '</table>',
                                                    shared: true,
                                                    useHTML: true
                                                },
                                                series: []
                                            });
<?php } ?>


                                    }



                                    $(document).ready(function () {
<?php if ($type == 'ยอดขาย') { ?>
                                            var json_code = '<?php echo isset($res_chart) ? $res_chart : '' ?>';
                                            if (json_code != '') {
                                                set_chart(json_code);
                                            }
<?php } else { ?>
                                            set_chart('');
<?php } ?>


                                        $('#btn_back').on('click', function () {
                                            $('#btn_submit').trigger('click');

                                        });



                                        $("#chkboxall").click(function (e) {
                                            $('.chkbox').prop('checked', this.checked);
                                        });

                                    });




                                    $('#report1').DataTable({
                                        "searching": false,
                                        "ordering": true,
                                        "columnDefs": [{
                                                "targets": [0],
                                                "orderable": false
                                            }]
                                    });
                                    $('#report2').DataTable({
                                        "searching": false,
                                        "ordering": true,
                                        "columnDefs": [{
                                                "targets": [0],
                                                "orderable": false
                                            }]
                                    });
                                    $('#report3').DataTable({
                                        "searching": false,
                                        "ordering": true,
                                        "columnDefs": [{
                                                "targets": [0],
                                                "orderable": false
                                            }]
                                    });
                                    $('#report4').DataTable({
                                        "searching": false,
                                        "ordering": true,
                                        "columnDefs": [{
                                                "targets": [0],
                                                "orderable": false
                                            }]
                                    });
                                    /* Formatting function for row details - modify as you need */



                                    $('#example2').DataTable({
                                        "searching": false,
                                        "ordering": true,
                                        "columnDefs": [{
                                                "targets": [0, 5],
                                                "orderable": false
                                            }]
                                    });

                                </script>

                                <style>


                                    td.details-control {
                                        background: url('<?= base_url() ?>assets/images/details_open.png') no-repeat center center;
                                        cursor: pointer;
                                    }
                                    tr.shown td.details-control {
                                        background: url('<?= base_url() ?>assets/images/details_close.png') no-repeat center center;
                                    }
                                    td{
                                        padding: 5px;
                                    }
                                    .highcharts-container{

                                        margin: auto;

                                    }


                                </style>

                                <?php if ($report_range == 'ตามช่วงเดือน' || $report_range == 'ตามช่วงปี' || $report_range == 'ประเภทสินค้าขายดี') { ?>
                                    <script>
                                        // $('.show-table-data').hide();
                                        $('document').ready(function () {
                                            $('.link-show-graph-data').trigger('click');
                                        });


                                        $('#btn_submit').click(function () {

                                        });
                                    </script>

                                <?php } ?>

                                <!-- date-range-picker -->
                                <script src="<?= base_url() ?>assets/js/moment.min.js"></script>
                                <script src="<?= base_url() ?>assets/plugins/daterangepicker/daterangepicker.js"></script>
                                <script src="<?= base_url() ?>assets/printThis/printThis.js"></script>