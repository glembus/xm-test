class FilterForm {
    constructor(container) {
        let _self = this;
        _self.static = {
            container: container,
        }

        $(_self.static.container + ' form').on('submit', function (e) {
            e.preventDefault();
            e.stopPropagation();
            let requestParameters = {
                url: $(this).attr('action'),
                method: "POST",
                data: $(this).serialize()
            };

            $.ajax(requestParameters)
                .done(function (response) {
                    if (response.form) {
                        $(_self.static.container).html(response.form);
                    }

                    if (response.company) {
                        $(document).trigger('dashboard:company:set', {company: response.company})
                    }

                    if (response.financeHistory) {
                        $(document).trigger('dashboard:finance-history:set', {financeHistory: response.financeHistory})
                    }
                })
                .fail(function (response) {
                    alert(response.responseJSON.error ?? 'Something went wrong. try again');
                    console.log(response);
                })
        })
    }
}
