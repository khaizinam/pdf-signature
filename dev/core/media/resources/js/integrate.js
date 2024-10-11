import { Helpers } from './App/Helpers/Helpers'
import { MediaConfig } from './App/Config/MediaConfig'
import { ContextMenuService } from './App/Services/ContextMenuService'

export class EditorService {
    static editorSelectFile(selectedFiles) {
        let is_ckeditor = Helpers.getUrlParam('CKEditor') || Helpers.getUrlParam('CKEditorFuncNum')

        if (window.opener && is_ckeditor) {
            let firstItem = Helpers.arrayFirst(selectedFiles)

            window.opener.CKEDITOR.tools.callFunction(Helpers.getUrlParam('CKEditorFuncNum'), firstItem.full_url)

            if (window.opener) {
                window.close()
            }
        } else {
            // No WYSIWYG editor found, use custom method.
        }
    }
}

class appMedia {
    constructor(selector, options) {
        let customHandler = window.RvMediaCustomCallback || null

        if (typeof customHandler === 'function') {
            customHandler(selector, options)
            return
        }

        window.appMedia = window.appMedia || {}

        let $body = $('body')

        let defaultOptions = {
            multiple: true,
            type: '*',
            onSelectFiles: (files, $el) => {},
        }

        options = $.extend(true, defaultOptions, options)

        let clickCallback = (event) => {
            event.preventDefault()
            let $current = $(event.currentTarget)

            $('#app_media_modal').modal('show')

            window.appMedia.options = options
            window.appMedia.options.open_in = 'modal'

            window.appMedia.$el = $current

            MediaConfig.request_params.filter = 'everything'
            Helpers.storeConfig()

            let elementOptions = window.appMedia.$el.data('app-media')
            if (typeof elementOptions !== 'undefined' && elementOptions.length > 0) {
                elementOptions = elementOptions[0]
                window.appMedia.options = $.extend(true, window.appMedia.options, elementOptions || {})
                if (typeof elementOptions.selected_file_id !== 'undefined') {
                    window.appMedia.options.is_popup = true
                } else if (typeof window.appMedia.options.is_popup !== 'undefined') {
                    window.appMedia.options.is_popup = undefined
                }
            }

            if ($('#app_media_body .app-media-container').length === 0) {
                $('#app_media_body').load(APP_MEDIA_URL.popup, (data) => {
                    if (data.error) {
                        alert(data.message)
                    }

                    $('#app_media_body')
                        .removeClass('media-modal-loading')
                        .closest('.modal-content')
                        .removeClass('bb-loading')
                    $(document).find('.app-media-container .js-change-action[data-type=refresh]').trigger('click')

                    if (Helpers.getRequestParams().filter !== 'everything') {
                        $('.app-media-actions .btn.js-app-media-change-filter-group.js-filter-by-type').hide()
                    }

                    ContextMenuService.destroyContext()
                    ContextMenuService.initContext()
                })
            } else {
                $(document).find('.app-media-container .js-change-action[data-type=refresh]').trigger('click')
            }
        }

        if (typeof selector === 'string') {
            $body.off('click', selector).on('click', selector, clickCallback)
        } else {
            selector.off('click').on('click', clickCallback)
        }
    }
}

window.AppMediaStandAlone = appMedia

$('.js-insert-to-editor')
    .off('click')
    .on('click', function (event) {
        event.preventDefault()
        let selectedFiles = Helpers.getSelectedFiles()
        if (Helpers.size(selectedFiles) > 0) {
            EditorService.editorSelectFile(selectedFiles)
        }
    })

$.fn.appMedia = function (options) {
    let $selector = $(this)

    MediaConfig.request_params.filter = 'everything'
    $(document)
        .find('.js-insert-to-editor')
        .prop('disabled', MediaConfig.request_params.view_in === 'trash')
    Helpers.storeConfig()

    let customHandler = window.RvMediaCustomCallback || null

    if (typeof customHandler === 'function') {
        customHandler($selector, options)
        return
    }

    new appMedia($selector, options)
}

document.dispatchEvent(new CustomEvent('core-media-loaded'))
