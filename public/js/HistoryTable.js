class HistoryTable {
    constructor(container) {
        let _self = this;
        _self.static = {
            container: container,
            table: container + ' table',
        }

        $(document).on('dashboard:finance-history:refresh', function (e, data) {
            let prices = [];
            $(_self.static.container).addClass('d-none').html(_self.getTableHtml());
            if (data.financeHistory.prices) {
               prices = data.financeHistory.prices;
               $(_self.static.container).removeClass('d-none');
            }

            $(_self.static.table).DataTable({
                paging: false,
                select: false,
                searching: false,
                data: prices,
                columns: [
                    {data: 'date'},
                    {data: 'open'},
                    {data: 'high'},
                    {data: 'low'},
                    {data: 'close'},
                    {data: 'volume'},
                ]
            }).destroy();
        })

        $(document).on('dashboard:finance-history:hide', function() {
            $(_self.static.container).addClass('d-none');
        })
    }

    getTableHtml() {
        return '<table class="table stripe">\n' +
            '<thead>\n' +
            '<tr>\n' +
            '<th scope="col">Date</th>\n' +
            '<th scope="col">Open</th>\n' +
            '<th scope="col">High</th>\n' +
            '<th scope="col">Low</th>\n' +
            '<th scope="col">Close</th>\n' +
            '<th scope="col">Volume</th>\n' +
            '</tr>\n' +
            '</thead>\n' +
            '</table>';
    }
}
