jQuery(document).ready(function ($) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#catalog-sidebar > ul ul').hide();
    $('#catalog-sidebar .badge').on('click', function () {
        var $badge = $(this);
        var closed = $badge.siblings('ul') && !$badge.siblings('ul').is(':visible');

        if (closed) {
            $badge.siblings('ul').slideDown('normal', function () {
                $badge.children('i').removeClass('fa-plus').addClass('fa-minus');
            });
        } else {
            $badge.siblings('ul').slideUp('normal', function () {
                $badge.children('i').removeClass('fa-minus').addClass('fa-plus');
            });
        }
    });

    setupProfilePrefill($);
    setupAjaxBasket($);
    setupCheckoutPayment($);
});

function setupProfilePrefill($) {
    $('form#profiles button[type="submit"]').hide();

    $('form#profiles select').change(function () {
        if ($(this).val() == 0) {
            $('#checkout').trigger('reset');
            return;
        }

        var data = new FormData($('form#profiles')[0]);
        $.ajax({
            url: '/basket/profile',
            data: data,
            processData: false,
            contentType: false,
            type: 'POST',
            dataType: 'JSON',
            success: function (data) {
                if (data.profile === undefined) {
                    return;
                }

                $('input[name="name"]').val(data.profile.name);
                $('input[name="email"]').val(data.profile.email);
                $('input[name="phone"]').val(data.profile.phone);
                $('input[name="address"]').val(data.profile.address);
                $('textarea[name="comment"]').val(data.profile.comment);
            },
            error: function (reject) {
                alert(reject.responseJSON.error);
            }
        });
    });
}

function setupAjaxBasket($) {
    $('form.add-to-basket').submit(function (e) {
        e.preventDefault();
        var $form = $(this);
        var data = new FormData($form[0]);

        $.ajax({
            url: $form.attr('action'),
            data: data,
            processData: false,
            contentType: false,
            type: 'POST',
            dataType: 'HTML',
            beforeSend: function () {
                var spinner = ' <span class="spinner-border spinner-border-sm"></span>';
                $form.find('button').append(spinner);
            },
            success: function (html) {
                $form.find('.spinner-border').remove();
                $('#top-basket').html(html);
            }
        });
    });
}

function setupCheckoutPayment($) {
    var $form = $('#checkout');

    if (!$form.length) {
        return;
    }

    var state = {
        checkout: null,
        config: null,
        paypalCardFields: null,
        submitting: false
    };

    var $submit = $('#checkout-submit-button');
    var $feedback = $('#checkout-feedback');
    var $error = $('#checkout-payment-error');
    var $panel = $('#checkout-payment-panel');
    var $panelLoading = $('#checkout-payment-loading');
    var $paymentNote = $('#checkout-payment-note');
    var $statusLink = $('#checkout-payment-status-link');
    var $payButton = $('#checkout-card-submit');
    var $paypalFields = $('#checkout-paypal-fields');
    var $fakeFields = $('#checkout-fake-fields');

    function selectedMethod() {
        return $form.find('input[name="payment_method"]:checked').val() || 'manager_confirmation';
    }

    function updateSubmitLabel() {
        var label = selectedMethod() === 'online_card'
            ? $form.data('onlineLabel')
            : $form.data('manualLabel');

        $submit.text(label);
    }

    function setSubmitting(value) {
        state.submitting = value;
        $submit.prop('disabled', value);
        $payButton.prop('disabled', value || !state.config);
    }

    function showFeedback(message) {
        if (!message) {
            $feedback.attr('hidden', true).text('');
            return;
        }

        $feedback.removeAttr('hidden').text(message);
    }

    function showError(message) {
        if (!message) {
            $error.attr('hidden', true).text('');
            return;
        }

        $error.removeAttr('hidden').text(message);
    }

    function showPaymentNote(message) {
        if (!message) {
            $paymentNote.attr('hidden', true).text('');
            return;
        }

        $paymentNote.removeAttr('hidden').text(message);
    }

    function resetHostedUi() {
        state.config = null;
        state.paypalCardFields = null;
        $panel.attr('hidden', true);
        $panelLoading.attr('hidden', true);
        $paypalFields.attr('hidden', true);
        $fakeFields.attr('hidden', true);
        $statusLink.attr('href', '#');
        showPaymentNote('');
        clearPayPalContainers();
        $payButton.prop('disabled', true);
    }

    function resetState() {
        state.checkout = null;
        showFeedback('');
        showError('');
        resetHostedUi();
    }

    async function submitHostedPayment() {
        if (!state.checkout || !state.checkout.payment || !state.config) {
            return;
        }

        showError('');
        $panelLoading.removeAttr('hidden');
        $payButton.prop('disabled', true);

        try {
            if (state.checkout.payment.provider.code === 'paypal') {
                if (!state.paypalCardFields) {
                    throw new Error($form.data('paymentFormNotReady'));
                }

                await state.paypalCardFields.submit();
                return;
            }

            if (state.checkout.payment.provider.code === 'fake') {
                await capturePayment(state.config.provider_payment_id);
                return;
            }

            throw new Error($form.data('paymentProviderUnsupported'));
        } catch (error) {
            $panelLoading.attr('hidden', true);
            $payButton.prop('disabled', false);
            showError(error.message || $form.data('cardPaymentFailed'));
        }
    }

    async function capturePayment(providerPaymentId, payerId) {
        var paymentId = state.checkout.payment.id;
        var response = await requestJson('/api/v1/payments/' + paymentId + '/capture', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                provider_payment_id: providerPaymentId || null,
                payer_id: payerId || null
            })
        });

        window.location.href = (state.config && state.config.status_url) || ('/payments/' + paymentId);
    }

    async function initializeHostedPayment(paymentId, providerCode) {
        $panel.removeAttr('hidden');
        $panelLoading.removeAttr('hidden');

        var response = await requestJson('/api/v1/payments/' + paymentId + '/checkout-config', {
            headers: {
                'Accept': 'application/json'
            }
        });

        state.config = response.data;
        $statusLink.attr('href', state.config.status_url || ('/payments/' + paymentId));
        $payButton.prop('disabled', false);

        if (providerCode === 'paypal') {
            await mountPayPalFields(state.config);
            $paypalFields.removeAttr('hidden');
        } else if (providerCode === 'fake') {
            mountFakeFields(state.config);
            $fakeFields.removeAttr('hidden');
        }

        $panelLoading.attr('hidden', true);
    }

    async function mountPayPalFields(config) {
        if (!config.sdk) {
            throw new Error($form.data('paymentSdkMissing'));
        }

        await loadExternalScript(config.sdk.script_url, {
            'data-client-token': config.sdk.client_token
        });

        if (!window.paypal || !window.paypal.CardFields) {
            throw new Error($form.data('paymentSdkUnavailable'));
        }

        clearPayPalContainers();

        var cardFields = window.paypal.CardFields({
            createOrder: function () {
                return config.provider_payment_id || '';
            },
            onApprove: function (data) {
                return capturePayment(data.orderID || config.provider_payment_id, data.payerID);
            },
            onError: function (error) {
                $panelLoading.attr('hidden', true);
                $payButton.prop('disabled', false);
                showError(error && error.message ? error.message : $form.data('cardPaymentFailed'));
            }
        });

        if (!cardFields.isEligible()) {
            throw new Error($form.data('paymentNotAvailable'));
        }

        await Promise.resolve(cardFields.NameField().render('#paypal-name-field'));
        await Promise.resolve(cardFields.NumberField().render('#paypal-number-field'));
        await Promise.resolve(cardFields.ExpiryField().render('#paypal-expiry-field'));
        await Promise.resolve(cardFields.CVVField().render('#paypal-cvv-field'));

        state.paypalCardFields = cardFields;
    }

    function mountFakeFields(config) {
        if (!config.sandbox_card) {
            return;
        }

        $('#checkout-fake-number').text(config.sandbox_card.number);
        $('#checkout-fake-expiry').text($form.data('expiryLabel') + ' ' + config.sandbox_card.expiry);
        $('#checkout-fake-cvv').text($form.data('cvvLabel') + ' ' + config.sandbox_card.cvv);
        $('#checkout-fake-postal').text($form.data('postalLabel') + ' ' + config.sandbox_card.postal_code);
    }

    function clearPayPalContainers() {
        ['paypal-name-field', 'paypal-number-field', 'paypal-expiry-field', 'paypal-cvv-field'].forEach(function (id) {
            var element = document.getElementById(id);
            if (element) {
                element.replaceChildren();
            }
        });
    }

    $form.on('change', 'input[name="payment_method"]', function () {
        updateSubmitLabel();
        resetState();
    });

    $form.on('submit', async function (event) {
        if (selectedMethod() !== 'online_card') {
            return;
        }

        event.preventDefault();

        if (state.submitting) {
            return;
        }

        setSubmitting(true);
        resetState();

        try {
            var response = await requestJson($form.attr('action'), {
                method: 'POST',
                headers: {
                    'Accept': 'application/json'
                },
                body: new FormData($form[0])
            });

            state.checkout = response.data;

            if (!state.checkout.payment) {
                window.location.reload();
                return;
            }

            showFeedback($form.data('checkoutCreatedOnline'));

            if (state.checkout.payment.currency !== state.checkout.payment.store_currency) {
                showPaymentNote(
                    formatTemplate($form.data('sandboxChargeTemplate'), {
                        payment_amount: state.checkout.payment.amount,
                        payment_currency: state.checkout.payment.currency,
                        store_amount: state.checkout.payment.store_amount,
                        store_currency: state.checkout.payment.store_currency,
                        rate: state.checkout.payment.conversion_rate
                    })
                );
            }

            await initializeHostedPayment(state.checkout.payment.id, state.checkout.payment.provider.code);
        } catch (error) {
            showError(error.message || $form.data('checkoutFailed'));
        } finally {
            setSubmitting(false);
        }
    });

    $payButton.on('click', function () {
        submitHostedPayment();
    });

    updateSubmitLabel();
}

async function requestJson(url, options) {
    var requestFailedMessage = document.body && document.body.dataset
        ? (document.body.dataset.requestFailed || 'Request failed.')
        : 'Request failed.';
    var response = await fetch(url, Object.assign({
        credentials: 'same-origin',
        headers: {}
    }, options || {}));

    var payload = null;

    try {
        payload = await response.json();
    } catch (error) {
        payload = null;
    }

    if (!response.ok) {
        throw new Error(extractApiError(payload, requestFailedMessage));
    }

    return payload;
}

function extractApiError(payload, fallback) {
    if (!payload || typeof payload !== 'object') {
        return fallback;
    }

    if (payload.errors && typeof payload.errors === 'object') {
        var firstKey = Object.keys(payload.errors)[0];
        if (firstKey && Array.isArray(payload.errors[firstKey]) && payload.errors[firstKey][0]) {
            return payload.errors[firstKey][0];
        }
    }

    return payload.message || fallback;
}

async function loadExternalScript(src, attributes) {
    var paymentSdkLoadFailed = $('#checkout').data('paymentSdkLoadFailed') || 'Failed to load the payment SDK.';
    var existing = Array.prototype.slice.call(document.scripts).find(function (script) {
        return script.dataset.checkoutSdk === src;
    });

    if (existing) {
        if (window.paypal) {
            return;
        }

        await waitForScript(existing);
        return;
    }

    await new Promise(function (resolve, reject) {
        var script = document.createElement('script');
        script.src = src;
        script.async = true;
        script.dataset.checkoutSdk = src;

        Object.keys(attributes || {}).forEach(function (key) {
            script.setAttribute(key, attributes[key]);
        });

        script.addEventListener('load', function () {
            resolve();
        }, { once: true });
        script.addEventListener('error', function () {
            reject(new Error(paymentSdkLoadFailed));
        }, { once: true });

        document.head.appendChild(script);
    });
}

function waitForScript(script) {
    var paymentSdkLoadFailed = $('#checkout').data('paymentSdkLoadFailed') || 'Failed to load the payment SDK.';
    return new Promise(function (resolve, reject) {
        script.addEventListener('load', function () {
            resolve();
        }, { once: true });
        script.addEventListener('error', function () {
            reject(new Error(paymentSdkLoadFailed));
        }, { once: true });
    });
}

function formatTemplate(template, replacements) {
    return Object.keys(replacements || {}).reduce(function (result, key) {
        return result.replaceAll(':' + key, String(replacements[key]));
    }, template || '');
}
