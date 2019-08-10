



$(document).on('click', '#select-all-brands', function () {

    if ($('#select-all-brands:checked').length > 0) {
        select_all = true;
    } else {
        select_all = false;
    }

    $('.brand-item').each(function () {
        if (this.checked) {
            if (!select_all) {
                this.checked = false;
            } else {
                this.checked = true;
            }

        } else {
            if (select_all) {
                this.checked = true;
            } else {
                this.checked = false;
            }
        }
    });


});

