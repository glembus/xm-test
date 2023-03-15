class FilterForm {
    constructor(container) {
        let _self = this;
        _self.static = {
            container: container,
        }

        $(document).on('submit', _self.static.container + ' form', function (e) {
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
                        $(document).trigger('dashboard:company:refresh', response);
                    } else {
                        $(document).trigger('dashboard:company:hide');
                    }

                    if (response.financeHistory) {
                        $(document).trigger('dashboard:finance-history:refresh', response);
                    } else {
                        $(document).trigger('dashboard:finance-history:hide');
                    }
                })
                .fail(function (response) {
                    console.log(response);
                })
        })
    }
}
