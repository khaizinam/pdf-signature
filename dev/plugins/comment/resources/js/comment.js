$(() => {
    let isReplying = false
    let originalForm = ''

    const setCookie = (name, value, expriesDate) => {
        const exdate = new Date()
        exdate.setDate(exdate.getDate() + expriesDate)
        value = encodeURIComponent(value) + (expriesDate == null ? '' : '; expires=' + exdate.toUTCString())
        document.cookie = `comment-${name}=${value}; path=/`
    }

    const getCookie = (name) => {
        const arr = document.cookie.match(new RegExp(`(^| )comment-${name}=([^;]*)(;|$)`))

        if (arr != null) {
            return decodeURIComponent(arr[2])
        }

        return null
    }

    const deleteCookie = (name) => {
        document.cookie = `comment-${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/`
    }

    $(document)
        .find('.comment-form input')
        .each((index, input) => {
            const name = $(input).prop('name')

            if (getCookie(name)) {
                if (name === 'cookie_consent') {
                    $(input).prop('checked', true)
                } else {
                    $(input).val($(input).val() || getCookie(name))
                }
            }
        })

    const fetchComments = (url = fobComment.listUrl) => {
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: ({ error, data, message }) => {
                if (window?.Theme !== undefined && error) {
                    Theme.showError(message)

                    return
                }

                const { title, html, comments } = data

                const $commentListSection = $(document).find('.comment-list-section')

                if (comments.total < 1) {
                    $commentListSection.hide()
                } else {
                    $commentListSection.show()
                    $(document).find('.comment-list-title').text(title)
                    $(document).find('.comment-list-wrapper').html(html)
                }
            },
        })
    }

    $(document)
        .on('submit', '.comment-form', (e) => {
            e.stopPropagation()
            e.preventDefault()

            if (typeof $.fn.validate !== 'undefined') {
                if (!$('.comment-form').valid()) {
                    return
                }
            }

            const form = $(e.currentTarget)
            const formData = new FormData(form[0])

            const cookieConsentsCheckbox = form.find('input[type="checkbox"][name="cookie_consent"]')
            const saveToCookie = cookieConsentsCheckbox.length > 0 && cookieConsentsCheckbox.is(':checked')

            $.ajax({
                url: form.prop('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: ({ error, message }) => {
                    if (window?.Theme !== undefined) {
                        if (error) {
                            Theme.showError(message)

                            return
                        }

                        Theme.showSuccess(message)
                    }

                    if (saveToCookie) {
                        setCookie('name', formData.get('name'), 365)
                        setCookie('email', formData.get('email'), 365)
                        setCookie('website', formData.get('website'), 365)
                        setCookie('cookie_consent', 1, 365)

                        form.find('textarea[name="content"]').val('')
                    } else {
                        form[0].reset()

                        deleteCookie('name')
                        deleteCookie('email')
                        deleteCookie('website')
                        deleteCookie('cookie_consent')
                    }

                    fetchComments()

                    if (isReplying) {
                        isReplying = false

                        $(document).find('.comment-form-section').remove(originalForm)

                        $(document).find('.comment-list-section').after(originalForm)
                    }
                },
                error: (error) => {
                    if (window?.Theme !== undefined) {
                        Theme.handleError(error)
                    }
                },
            })
        })
        .on('click', '.comment-pagination a', (e) => {
            e.preventDefault()

            const url = e.currentTarget.href

            if (url) {
                fetchComments(url)

                $('html, body').animate({
                    scrollTop: $('.comment-list-section').offset().top,
                })
            }
        })
        .on('click', '.comment-item-reply', (e) => {
            e.preventDefault()

            const currentTarget = $(e.currentTarget)

            const form = $(document).find('.comment-form-section')

            if (form) {
                form.remove()
            }

            if (!isReplying) {
                originalForm = form.clone()
            }

            currentTarget.closest('.comment-item').after(form)

            form.find('.comment-form-title').text(currentTarget.data('reply-to'))
            form.find('.comment-form-title').append(
                `<a href="#" class="cancel-comment-reply-link" rel="nofollow">${currentTarget.data('cancel-reply')}</a`
            )
            form.find('form').prop('action', currentTarget.prop('href'))

            isReplying = true
        })
        .on('click', '.cancel-comment-reply-link', (e) => {
            e.preventDefault()

            isReplying = false

            const form = $(document).find('.comment-form-section')

            if (form) {
                form.remove()
            }

            $(document).find('.comment-list-section').after(originalForm)
        })

    fetchComments()
})
