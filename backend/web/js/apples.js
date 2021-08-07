(function () {
    $('[data-btn-eat]').popover({
        html: true,
        placement: 'left',
        content: function () {
            let $content = $('form', '#popover-template').clone();
            $('input[name=appleId]', $content).val(this.getAttribute('data-btn-eat'));
            return $content;
        }
    });

    $(document).on('submit', '.apple-eat-form', function () {
        let $form = $(this);
        $.ajax(this.getAttribute('action'), {
            type: "post",
            data: $(this).serialize(),
            beforeSend: function () {
                $('[type=submit]', $form).attr('disabled', 'disabled');
            },
            success: function (data) {
                if (data.result === false) {
                    alert(data.error);
                    return;
                }
                window.location.reload();
            },
            complete: function () {
                $('[type=submit]', $form).removeAttr('disabled');
                $form.closest('.popover').popover('hide');
            }
        });
        return false;
    });
})()
