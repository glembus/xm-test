class HistoryChart {
    constructor(container, dashboard) {
        let _self = this;
        _self.static = {
            dashboard: dashboard,
            container: container
        };

        $(document).on('dashboard:company:refresh', function (e){
            $(_self.static.container).CanvasJSChart({
                title: {
                    text: _self.static.dashboard.companyName
                },
                axisY: {
                    includeZero: false,
                    title: "Price",
                },
                axisX: {
                    intervalType: "day",
                    interval: 1,
                    valueFormatString: "DD-MM-YY"
                },
                data: [
                    {
                        type: "candlestick",
                        dataPoints: _self.convertToChartFormat(_self.static.dashboard.financeHistory.prices),
                    }
                ]
            })
        });
    }

    convertToChartFormat(data) {
        let convertedData = [];
        $.each(data, function (row) {
            convertedData.push({x: row.data, y: [row.open, row.high, row.low, row.close]});
        });

        return convertedData;
    }
}
