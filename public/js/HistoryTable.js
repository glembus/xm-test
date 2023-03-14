class HistoryTable {
    constructor(container, dashboard) {
        let _self = this;
        _self.static = {
            dashboard: dashboard,
            container: container,
            table: container + ' table',
        }

        $(document).on('dashboard:finance-history:refresh', function (e) {
            let data = [];
            if (_self.static.dashboard.financeHistory.prices) {
                data = _self.static.dashboard.financeHistory.prices;
            }

            $(_self.static.table).DataTable({
                paging: true,
                pageLength: 50,
                select: false,
                data: data,
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
    }
}
