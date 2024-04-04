$(document).ready(function () {
    const body = $('body');
    body.on('click', '.confirm-delete', function () {
        const button = $(this).addClass('disabled');
        const title = button.attr('title');

        if (confirm(title ? title + '?' : 'Confirm the deletion')) {
            if (button.data('reload')) {
                return true;
            }
            $.getJSON(button.attr('href'), function (response) {
                button.removeClass('disabled');
                if (response.result === 'success') {
                    button.closest('tr').fadeOut(function () {
                        this.remove();
                    });
                } else {
                    alert(response.error);
                }
            });
        }
        return false;
    });

    body.on('change', '.news-banner-status', function (e) {
        e.preventDefault()
        const id = $(this).data("id")
        let status = this.checked ? 1 : 0
        $.getJSON(`/news/banner-status?id=${id}&status=${status}`);
        return false;
    });

    $(document).bind('keydown', function (e) {
        if (e.ctrlKey && e.which === 83) {
            $('.model-form').submit();
            e.preventDefault();
            return false;
        }
    });

    body.on('click', '.modalButton', function () {
        $.get($(this).attr('href'), function (data) {
            $("#modal").modal('show').find('#modalContent').html(data)
            $(".datepicker").flatpickr({
                dateFormat: "m-d-Y"
            });
        });
        return false;
    })

    $(".datepicker").flatpickr({
        dateFormat: "m-d-Y",
        allowInput: true,
        parseDate: (datestr, format) => {
            return moment(datestr, format, true).toDate();
        },
        formatDate: (date, format, locale) => {
            return moment(date).format(format);
        }
    });

    $(".event-date").flatpickr();

    $(".dateTimePicker").flatpickr({
        enableTime: true,
        dateFormat: "m-d-Y H:i"
    });

    $('.date-changer').daterangepicker({
        locale: { format: 'DD.MM.YYYY' }
    });

    let addQuestion = '.ajax-add-question'
    $(body).on('click', addQuestion, (e) => {
        e.preventDefault()

        $.ajax({
            url: $(addQuestion).attr('href'),
            type: 'GET',
            success: (data) => $('.make-question').append(data),
            error: (data) => console.log(data)
        })
    })

    let addAnswer = '.ajax-add-answer'
    $(body).on('click', addAnswer, (e) => {
        e.preventDefault()

        $.ajax({
            url: $(addAnswer).attr('href'),
            type: 'GET',
            success: (data) => $('.make-answer').append(data),
            error: (data) => console.log(data)
        })
    })
});

