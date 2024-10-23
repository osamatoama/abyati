function sortByKey(array, key) {
    return array.sort(function(a, b) {
        var x = a[key]
        var y = b[key]
        return ((x < y) ? -1 : ((x > y) ? 1 : 0))
    })
}

function isNumeric(str) {
    if (typeof str != "string") {
        return false
    }

    return !isNaN(str) && !isNaN(parseFloat(str))
}

function getCurrentLang() {
    return $('html').attr('lang') == 'ar' ? 'ar' : 'en'
}

function getTranslation(keyword) {
    let lang = getCurrentLang()
    return helpers.dictionary[keyword][lang] || ''
}

function getSelect2Translation(keyword) {
    let lang = getCurrentLang()
    return helpers.plugins.select2.translations[keyword][lang] || ''
}

function getFormData(form) {
    if (! form instanceof jQuery) {
        // throw exception
    }

    return new FormData(form[0])
}

function generateFormData(method) {
    let formData = new FormData
    formData.append('_method', method)

    return formData
}

function resetForm(form) {
    if (! form instanceof jQuery) {
        // throw exception
    }

    form.trigger('reset')
}

function enableSubmit(form) {
    if (! form instanceof jQuery) {
        // throw exception
    }

    let submitButton = form.find('button[type=submit]')

    if (submitButton.length == 0) {
        submitButton = $(`button[type=submit][form=${form.attr('id')}]`)
    }

    submitButton.removeClass('disabled')
}

function enableElement(el) {
    if (! el instanceof jQuery) {
        // throw exception
    }

    el.removeClass('disabled')
}

function disableSubmit(form) {
    if (! form instanceof jQuery) {
        // throw exception
    }

    let submitButton = form.find('button[type=submit]')

    if (submitButton.length == 0) {
        submitButton = $(`button[type=submit][form=${form.attr('id')}]`)
    }

    submitButton.addClass('disabled')
}

function disableElement(el) {
    if (! el instanceof jQuery) {
        // throw exception
    }

    el.addClass('disabled')
}

function enableElement(el) {
    if (! el instanceof jQuery) {
        // throw exception
    }

    el.removeClass('disabled')
}

function disableElement(el) {
    if (! el instanceof jQuery) {
        // throw exception
    }

    el.addClass('disabled')
}

function showElement(el) {
    el.removeClass('d-none')
}

function hideElement(el) {
    el.addClass('d-none')
}

function handleAjaxFormError(error, form) {
    if (error.response.status == 422) {
        let errors = error.response.data.errors

        if (form != undefined) {
            showFormValidationErrors(form, errors)
        } else {
            errorToast(getTranslation('somethingWrong'))
        }
    } else if (error.response.status == 404) {
        errorToast(error.response.data.error)
    } else if (error.response.status == 500) {
        errorToast(getTranslation('somethingWrong'))
    } else {
        errorToast(getTranslation('somethingWrong'))
    }
}

function showFormValidationErrors(form, errors) {
    if (! form instanceof jQuery) {
        // throw exception
    }

    for (let input in errors) {
        let inputName = input

        if (input.includes('.')) {
            let inputNameToArr = inputName.split(".")

            if (isNumeric(inputNameToArr[1])) {
                inputName = inputNameToArr[0]
            } else {
                inputName = inputNameToArr[0] + "\\[" + inputNameToArr[1] + "\\]"
            }
        }

        if (input.includes('[')) {
            inputName = inputName.replace('[', '\\[')
        }

        if (input.includes(']')) {
            inputName = inputName.replace(']', '\\]')
        }

        let inputId = `${form.attr('id')}-${inputName}`
        let inputEl = $('#' + inputId)
        let errorSpanId = `${form.attr('id')}-${inputName}-error`
        let errorSpan = $('#' + errorSpanId)
        showElement(errorSpan)
        inputEl.addClass('is-invalid')
        errorSpan.html(errors[input][0])
    }
}

function reloadDatatable(dt) {
    dt.ajax.reload(null, false)
}

function reloadPage() {
    window.location.reload()
}

function hideFormValidationErrors(form) {
    hideElement($(`#${form.attr('id')} .form-input-error`))
    $(`#${form.attr('id')} .is-invalid`).removeClass('is-invalid')
}

function setFormAction(form, action) {
    form.attr('action', action)
}

function openModal(modal) {
    if (! modal instanceof jQuery) {
        // throw exception
    }

    $(`#open-${modal.attr('id')}`).trigger('click')
}

function openStackedModal(modal) {
    if (! modal instanceof jQuery) {
        // throw exception
    }

    $(`#open-stacked-${modal.attr('id')}`).trigger('click')
}

function closeModal(modal) {
    if (! modal instanceof jQuery) {
        // throw exception
    }

    modal.find('.btn-close').trigger('click')
}

function successToast(message) {
    toastr.success(message)
}

function warningToast(message) {
    toastr.warning(message)
}

function errorToast(message) {
    toastr.error(message)
}


$('body').on('hidden.bs.modal', '.modal', function (e) {
    let el = $(e.target)
    let form = el.find('form')

    // let fileInputs = form.find('input[type=file]')
    // fileInputs.each(function(i, file) {
    //     if ($(file).val()) {
    //         let label = $(file).closest('.form-control-wrap').siblings('label').text()
    //         $(file).siblings('label').text(label || '')
    //     }
    // })

    form.trigger('reset')
    // form.find('.select2-input-custom').val('').trigger('change')
    // form.find('.select2-input-search').val('').trigger('change')
    // form.find('.select2-input-multiple').val(null).trigger('change')
    // form.find('.select2-input-custom[multiple=multiple]').val([]).trigger('change')
    // form.find('.select2-input-search[multiple=multiple]').val([]).trigger('change')
    // form.find('.summernote-minimal').val('')
    // form.find('.summernote-minimal').siblings('.note-editor').find('.note-editable').html('')
    // form.find('.summernote-basic').val('')
    // form.find('.summernote-basic').siblings('.note-editor').find('.note-editable').html('')
    // form.find('.old-image-preview').each(function(i, item) {
    //     let image = $(item)
    //     image.attr('src', '#')
    //     hideElement(image)
    // })
    form.find('.form-input-error').addClass('d-none')
})

function rangeFlatpickr(el, config) {
    let defaultConfig = {
        altInput: true,
        altFormat: "Y-m-d",
        dateFormat: "Y-m-d",
        mode: "range",
        locale: getCurrentLang(),
    }

    return flatpickr(el, {
        ...defaultConfig,
        ...config
    })
}


/**
 * Filters (Query string)
 */
let queryStringFilters = {}

function autoFillFiltersObject() {
    queryStringFilters = getQueryParams()
}

function appendFilter(key, val) {
    queryStringFilters[key] = val
}

function removeFilter(key) {
    delete queryStringFilters[key]
}

function resetFilters() {
    queryStringFilters = {}
}

function filtersToQueryString() {
    var qs = []

    for (var p in queryStringFilters) {
        if (queryStringFilters.hasOwnProperty(p)) {
            qs.push(encodeURIComponent(p) + "=" + encodeURIComponent(queryStringFilters[p]))
        }
    }

    return (qs.length > 0) ? '?' + qs.join('&') : ''
}

function removeQueryString(url) {
    return url.split(/[?#]/)[0]
}

function redirect(url) {
    window.location.href = url
}

function reloadWithFilters() {
    let url = removeQueryString(window.location.href)
    url += filtersToQueryString()

    window.location.href = url
}

function getQueryParams() {
    let params = new URLSearchParams(window.location.search)

    return Object.fromEntries(params.entries())
}

function getQueryParam(key) {
    let params = new Proxy(new URLSearchParams(window.location.search), {
        get: (searchParams, prop) => searchParams.get(prop),
    })

    return params[key]
}

function getQueryParamForUrl(url, key) {
    let params = new Proxy(new URLSearchParams(url), {
        get: (searchParams, prop) => searchParams.get(prop),
    })

    return params[key]
}

function initSelect2Components() {
    var elements = [].slice.call(document.querySelectorAll('[data-control="select2-custom"], [data-kt-select2="true"]'))

    elements.map(function (element) {
        if (element.getAttribute("data-kt-initialized") === "1") {
            return
        }

        var options = {
            dir: getCurrentLang() == 'ar' ? 'rtl' : 'ltr'
        }

        if (element.getAttribute('data-hide-search') == 'true') {
            options.minimumResultsForSearch = Infinity
        }

        $(element).select2(options)

        element.setAttribute("data-kt-initialized", "1")

        $(document).on('select2:open', function(e) {
            var elements = document.querySelectorAll('.select2-container--open .select2-search__field')
            if (elements.length > 0) {
                elements[elements.length - 1].focus()
            }
        })
    })
}

function select2SelectAll(select2) {
    let vals = []
    select2.find('option').each(function(i, el) {
        vals.push($(el).val())
    })
    select2.val(vals).trigger('change')
}

function select2ClearAll(select2) {
    select2.val([]).trigger('change')
}

// initSelect2Components()


function initPasswordMeter(el, config) {
    var defaultConfig = {
        minLength: 8,
        checkUppercase: true,
        checkLowercase: true,
        checkDigit: true,
        checkChar: true,
        scoreHighlightClass: "active"
    }

    return new KTPasswordMeter(el, {
        ...defaultConfig,
        ...config,
    })
}

function enableTooltips() {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    return tooltipList
}

function initModalTriggers() {
    $('.modal').each(function(i, item) {
        const el = $(item)
        const id = el.attr('id')
        const button = $('<button>', {
            "id": `open-${id}`,
            "data-bs-toggle": 'modal',
            "data-bs-target": `#${id}`,
            "class": 'd-none',
        })

        $('body').append(button)
    })
}

// $(document).ready(function() {
    initModalTriggers()
// })

function initDraggable() {
    const containers = document.querySelectorAll(".draggable-zone")

    if (containers.length === 0) {
        return
    }

    return new Sortable.default(containers, {
        draggable: ".draggable",
        handle: ".draggable .draggable-handle",
        mirror: {
            //appendTo: selector,
            appendTo: "body",
            constrainDimensions: true
        }
    })
}

function copyToClipboard(content) {
    if (window.isSecureContext && navigator.clipboard) {
        navigator.clipboard.writeText(content)
    } else {
        unsecuredCopyToClipboard(content)
    }
}

function copyToClipboardWithSuccessToast(content) {
    copyToClipboard(content)

    successToast(getTranslation('copiedToClipboard'))
}

function unsecuredCopyToClipboard(content) {
    var tempTextarea = $('<textarea>')
    $('body').append(tempTextarea)
    tempTextarea.val(content).select()

    try {
        document.execCommand('copy')
    } catch (err) {
        console.error('Unable to copy to clipboard', err)
    }

    tempTextarea.remove()
}

function showCardOverlay(el) {
    const overlay = el.find('.card-body .overlay')

    if (! overlay.length) {
        return
    }

    overlay.removeClass('d-none')
}

function hideCardOverlay(el) {
    const overlay = el.find('.card-body .overlay')

    if (! overlay.length) {
        return
    }

    overlay.addClass('d-none')
}

function createPieChart(config) {
    const {
        el = null,
        labels = {},
        data = {},
        title = null,
    } = config

    if (! el) {
        return
    }

    let titleConfig = {display: false}
    if (title) {
        titleConfig = {display: true, text: title, font: {size: 16}}
    }

    return new Chart(el, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                label: 'hello',
                data: data,
                backgroundColor: [
                    '#FF6384', // Red
                    '#36A2EB', // Blue
                    '#FFCE56', // Yellow
                    '#4BC0C0', // Teal
                    '#9966FF', // Purple
                    '#FF9F40', // Orange
                    '#32CD32', // Lime Green
                    '#FF00FF',  // Magenta
                ],
                hoverOffset: 4
            }]
        },
        options: {
            plugins: {
                title: titleConfig
            },
            responsive: true,
        },
        defaults:{
            global: {
                defaultFont: KTUtil.getCssVariableValue('--bs-font-sans-serif'),
            }
        }
    })
}

function updateChart(config) {
    const {
        chart = null,
        labels = {},
        data = {},
    } = config

    if (! chart) {
        return
    }

    chart.data.labels = labels
    chart.data.datasets.forEach((dataset) => {
        dataset.data = data
    })

    chart.update()
}

function playVoiceNotification(id, level = 1.0) {
    var audio = document.getElementById(id)

    audio.volume = level

    audio.play()
}

function playSpeechSynthesisNotification(message, lang = 'en-US') {
    if ('speechSynthesis' in window) {
        const speech = new SpeechSynthesisUtterance(message)

        speech.lang = lang
        speech.rate = 0.75
        speech.pitch = 1
        // speech.volume = 1

        window.speechSynthesis.speak(speech)
    } else {
        console.log("Speech Synthesis not supported in this browser.")
    }
}
