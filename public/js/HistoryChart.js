class HistoryChart {
    constructor(container) {
        let _self = this;
        _self.static = {
            container: container
        };

        $(document).on('dashboard:company:refresh', function (e, data){
            let companyName = 'Company Name';
            $(_self.static.container).removeClass('d-none');
            $(_self.static.container).CanvasJSChart({
                title: {
                    text: data.company[companyName]
                },
                axisY: {
                    includeZero: false,
                    title: "Price",
                },
                axisX: {
                    intervalType: "day",
                    interval: 1,
                    valueFormatString: "MMM"
                },
                data: [
                    {
                        type: "candlestick",
                        dataPoints: _self.convertToChartFormat(data.financeHistory),
                    }
                ]
            })
        });

        $(document).on('dashboard:company:hide', function () {
            $(_self.static.container).addClass('d-none');
        })
    }

    convertToChartFormat(data) {
        let convertedData = [];
        let offSet = data.offset;
        $.each(data.prices, function (row) {
            convertedData.push({x: new Date(row.data), y: [row.open, row.high, row.low, row.close]});
        });

        return convertedData;
    }
}
