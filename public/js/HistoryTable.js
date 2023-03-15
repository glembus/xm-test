class HistoryTable {
    constructor(container) {
        let _self = this;
        _self.static = {
            container: container,
            table: container + ' table',
        }

        let table = $(_self.static.table).DataTable({
            paging: false,
            select: false,
            data: [],
            columns: [
                {data: 'date'},
                {data: 'open'},
                {data: 'high'},
                {data: 'low'},
                {data: 'close'},
                {data: 'volume'},
            ]
        });

        $(document).on('dashboard:finance-history:refresh', function (e, data) {
            let prices = [];
            $(_self.static.container).addClass('d-none');
            if (data.financeHistory.prices) {
               prices = data.financeHistory.prices;
               $(_self.static.container).removeClass('d-none');
            }

            if (typeof table != 'undefined') {
                table.destroy();
            }

            let table = $(_self.static.table).DataTable({
                paging: false,
                select: false,
                data: prices,
                columns: [
                    {data: 'date'},
                    {data: 'open'},
                    {data: 'high'},
                    {data: 'low'},
                    {data: 'close'},
                    {data: 'volume'},
                ]
            });
        })

        $(document).on('dashboard:finance-history:hide', function() {
            $(_self.static.container).addClass('d-none');
        })
    }
}
