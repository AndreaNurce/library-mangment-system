$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    let $ajax_form = $("form.ajax-form");

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "progressBar": true,
        "preventDuplicates": false,
        "positionClass": "toast-top-right",
        "onclick": null,
        "showDuration": "500",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };

    $ajax_form.attr('novalidate', 'novalidate');

    $ajax_form.submit(function (event) {
        event.preventDefault();
        formAjax($(this));
    });

    $('body').on('click', '.action-button', function (event) {
        event.preventDefault();

        let $this = $(this),
            $actionModal = $('#action-modal'),
            $actionFormModal = $('#action-form-modal'),
            $actionFormButton = $('#action-form-button'),
            $actionFormInputs = $('#action-form-inputs'),
            $actionModalTitle = $('#action-title'),
            $actionModalMessage = $('#action-message'),
            method = $this.data('method'),
            action = $this.data('action'),
            title = $this.data('title'),
            message = $this.data('message'),
            isDanger = $this.data('is-danger') === 'true' || $this.data('is-danger') === true;

        if (method === 'PUT' || method === 'PATCH' || method === 'DELETE') {
            $actionFormModal.attr('method', 'POST');
            $actionFormInputs.html(`<input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}"><input type="hidden" name="_method" value="${method}">`);
        } else if (method === 'POST') {
            $actionFormModal.attr('method', 'POST');
            $actionFormInputs.html(`<input type="hidden" name="_token" value="${$('meta[name="csrf-token"]').attr('content')}">`);
        } else {
            $actionFormModal.attr('method', 'GET');
            $actionFormInputs.html('');
        }

        if (isDanger) {
            $actionFormButton.removeClass('btn-success');
            $actionFormButton.addClass('btn-danger');
        } else {
            $actionFormButton.addClass('btn-success');
            $actionFormButton.removeClass('btn-danger');
        }

        $actionModalTitle.html(title);
        $actionModalMessage.html(message);
        $actionFormModal.attr('action', action);
        $actionModal.modal('show');
    });
});

function formAjax($form, $submit_btn = null, async = true) {
    $.ajax({
        url: $form.attr('action'),
        type: $form.attr('method'),
        data: new FormData($form[0]),
        dataType: 'JSON',
        contentType: false,
        cache: false,
        processData: false,
        async: async,
        beforeSend: function () {
            showLoadSubmitButton($form, $submit_btn);
            clearFormErrors($form);
        },
        success: function (response) {
            let data = response.data;
            if (!data.success) {
                toastr.error('Error!');
            }

            if (data.success !== undefined && data.success) {
                if (data.redirect_to !== undefined && data.redirect_to !== null && data.redirect_to.length > 0) {
                    window.location.href = data.redirect_to;
                }
            }
        },
        error: function (data) {
            handleSubmitFormErrors(data);
        },
        complete: function () {
            hideLoadSubmitButton($form, $submit_btn);
        }
    });
}

function handleSubmitFormErrors(response) {
    let data = response.responseJSON;

    if (response.status === 422) { // Validation Error
        toastr.error('', data.message);

        $.each(data.errors, function (input, errorMessage) {
            let inputName = input;

            if (input.indexOf(".") !== -1) {
                let inputParts = input.split(".");

                if (inputParts.length === 2 && typeof inputParts[1] === 'number') {
                    input = `[name="${inputParts[0]}[]"]:eq(${inputParts[1]})`;
                } else if (inputParts.length === 2 && typeof inputParts[1] !== 'number') {
                    input = `[name="${inputParts[0]}[${inputParts[1]}]"]`;
                } else if (inputParts.length === 3) {
                    input = `[name="${inputParts[0]}[${inputParts[1]}][${inputParts[2]}]"]`;
                } else if (inputParts.length === 4) {
                    input = `[name="${inputParts[0]}[${inputParts[1]}][${inputParts[2]}][${inputParts[3]}]"]`;
                }
            } else {
                input = `[name^=${input}]`;
            }

            let $input = $(input);
            $input.addClass('is-invalid');
            $input.siblings('span.invalid-feedback').html(errorMessage[0]);
            $input.parent().next('span.invalid-feedback').html(errorMessage[0]);

        });
    } else {
        toastr.error(data.message, response.status);
    }
}

function showLoadSubmitButton($form, $submit_btn = null) {
    if ($submit_btn !== null) {
        $submit_btn.attr('disabled', true);
        $submit_btn.find('i.fa').removeClass('d-none');
    } else {
        $form.find('button.submit-btn').attr('disabled', true);
        $form.find('button.submit-btn i.fa').removeClass('d-none');
    }
}

function hideLoadSubmitButton($form, $submit_btn = null) {
    if ($submit_btn !== null) {
        $submit_btn.attr('disabled', false);
        $submit_btn.find('i.fa').addClass('d-none');
    } else {
        $form.find('button.submit-btn').attr('disabled', false);
        $form.find('button.submit-btn i.fa').addClass('d-none');
    }
}

function clearFormErrors($form) {
    $form.find('input').next('span.invalid-feedback').html('');
    $form.find('input').parent().next('span.invalid-feedback').html('');
    $form.find('.is-invalid').removeClass('is-invalid');
    $form.find('span.text-danger.asterisk').remove();
}
