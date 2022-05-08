<?php $v->layout("_checkout"); ?>
<div id="checkout">
    <div class="container">
        <h1>Você <?= ucfirst($title) ?></h1>
        <div id="grafico" style="width: 550px; height: 400px;"></div>
        <script language="JavaScript">
            $(document).ready(function() {
                var data = {
                    table: 'datatable'
                };
                var chart = {
                    type: 'column'
                };
                var title = {
                    text: 'Resultados'
                };
                var yAxis = {
                    allowDecimals: false,
                    title: {
                        text: 'Units'
                    }
                };
                var tooltip = {
                    formatter: function () {
                        return '<b>' + this.series.name + '</b><br/>' +
                            this.point.y + ' ' + this.point.name.toLowerCase();
                    }
                };
                var credits = {
                    enabled: false
                };

                var json = {};
                json.chart = chart;
                json.title = title;
                json.data = data;
                json.yAxis = yAxis;
                json.credits = credits;
                json.tooltip = tooltip;
                $('#grafico').highcharts(json);
            });
        </script>
        <table id="datatable">
            <thead>
            <tr><th></th><th>Quantidade</th></tr>
            </thead>
            <tbody>
            <?php foreach ($resultado as $key => $value): ?>
            <tr><th><?= ucfirst($key)?></th><td><?= $value ?></td></tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>