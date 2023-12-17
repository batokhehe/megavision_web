<script type="application/javascript">
    $(document).ready(function() {
        var start_date = moment();
        var end_date = moment().add(5, 'day');

        table = $('.datatables').DataTable({
            processing: true,
            searching: true,
            serverSide: true,
            ajax: {
                url: "<?php echo base_url('api/dashboard'); ?>",
                type: "GET",
                headers: {
                    "Authorization": ""
                },
            },
            columns: [{
                    data: 'client_name'
                },
                {
                    data: 'order_date'
                },
                {
                    data: 'order_amount'
                },
                {
                    data: 'client_phone'
                },
                {
                    data: 'employee_name'
                },
                {
                    data: 'office_name'
                },
                {
                    data: null
                }
            ],
            order: [
                [1, "asc"]
            ]
        });

        var colors = ['rgb(14, 186, 169)', 'rgb(255, 198, 193)', 'rgb(132, 233, 255)', 'rgb(58, 171, 88)', 'rgb(221, 79, 64)', 'rgb(255, 244, 158)', 'rgb(216, 180, 255)', 'rgb(185, 255, 192)', 'rgb(240, 190, 144)', 'rgb(73, 149, 241)'];

        function loadDashboardData() {
            var start_date_title = moment(start_date).format('DD, MMM-YYYY');
            var end_date_title = moment(end_date).format('DD, MMM-YYYY');

            $('#date-title').html('Sales: ' + start_date_title + ' - ' + end_date_title)

            $.ajax({
                url: "<?php echo base_url() . '/api/dashboard' ?>",
                type: 'post',
                data: JSON.stringify({
                    'date_start': start_date,
                    'date_end': end_date
                }),
                dataType: 'json',
                contentType: 'application/json',
                headers: {
                    "Authorization": ""
                },
                success: function(data) {
                    var total_sales_percentage = parseInt(data.total_sales_percentage);
                    var total_sales = parseInt(data.total_sales);

                    var sales_text = 'description-percentage ';
                    sales_text += total_sales_percentage > 0 ? 'text-success' : total_sales_percentage < 0 ? 'text-danger' : 'text-warning';
                    var sales_icon = total_sales_percentage > 0 ? '<i class="fas fa-caret-up"></i>' : total_sales_percentage < 0 ? '<i class="fas fa-caret-down"></i>' : '<i class="fas fa-caret-left"></i>';

                    $('#sales-description-percentage').html(sales_icon + ' ' + total_sales_percentage.toLocaleString('en-US'));
                    $('#sales-description-header').html(total_sales.toLocaleString('en-US'));
                    $('#sales-description-percentage').attr('class', sales_text);

                    var total_income_percentage = parseInt(data.total_income_percentage);
                    var total_income = parseInt(data.total_income);

                    var income_text = 'description-income ';
                    income_text += total_income_percentage > 0 ? 'text-success' : total_income_percentage < 0 ? 'text-danger' : 'text-warning';
                    var income_icon = total_income_percentage > 0 ? '<i class="fas fa-caret-up"></i>' : total_income_percentage < 0 ? '<i class="fas fa-caret-down"></i>' : '<i class="fas fa-caret-left"></i>';

                    $('#income-description-percentage').html(income_icon + ' Rp.' + total_income_percentage.toLocaleString('en-US'));
                    $('#income-description-header').html('Rp. ' + total_income.toLocaleString('en-US'));
                    $('#income-description-percentage').attr('class', income_text);

                    var salesPerformance = data.sales_performance;
                    var datasets = [];
                    var months = [];
                    for (let index = 0; index < salesPerformance.length; index++) {
                        const element = salesPerformance[index];
                        obj = {};
                        obj['label'] = element.name;
                        obj['fill'] = false;
                        obj['borderColor'] = colors[index];
                        obj['tension'] = 0.1;
                        obj['data'] = [element.count_4, element.count_3, element.count_2, element.count_1, element.count_0];
                        datasets.push(obj);
                    }

                    var init_date = moment(start_date).subtract(5, 'month');
                    for (let index = 0; index < 5; index++) {
                        var temp = init_date.add(1, 'month').format('MMMM');
                        months.push(temp);
                    }

                    var salesChartCanvas = $("#sales-chart").get(0).getContext("2d");
                    var salesChartData = {
                        labels: months,
                        datasets: datasets
                    };

                    var salesChartOptions = {
                        maintainAspectRatio: true,
                        responsive: true,
                        scales: {
                            xAxes: [{
                                gridLines: {
                                    display: false,
                                },
                            }, ],
                            yAxes: [{
                                gridLines: {
                                    display: false,
                                },
                            }, ],
                        },
                        legend: {
                            display: true,
                            position: 'top',
                            align: 'start'
                        }
                    };

                    // This will get the first returned node in the jQuery collection.
                    // eslint-disable-next-line no-unused-vars
                    var salesChart = new Chart(salesChartCanvas, {
                        type: "line",
                        data: salesChartData,
                        options: salesChartOptions,
                    });

                    //---------------------------
                    // - END MONTHLY SALES CHART -
                    //---------------------------
                }
            });
        }


        loadDashboardData();
        $('input[name="daterange"]').daterangepicker({
            opens: 'left',
            startDate: moment(),
            endDate: moment().add(5, 'day'),
        }, function(start, end, label) {
            start_date = start.format('YYYY-MM-DD');
            end_date = end.format('YYYY-MM-DD');
            loadDashboardData();
        });

    });
</script>