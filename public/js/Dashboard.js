class Dashboard {
    constructor() {
        let _self = this;
        _self.data = {
            company: {},
            financeHistory: []
        };

        $(document).on('dashboard:company:set', function (e) {
            _self.data.company = e.company;
            $(document).trigger('dashboard:company:refresh');
        });

        $(document).on('dashboard:finance-history:set', function (e) {
            _self.data.financeHistory = e.financeHistory;
            $(document).trigger('dashboard:finance-history:refresh');
        });
    }
}

