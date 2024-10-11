class CacheManagement {
    init() {
        $(document).on('click', '.btn-clear-cache', (event) => {
            event.preventDefault()

            let _self = $(event.currentTarget)

            Apps.showButtonLoading(_self)

            $httpClient
                .make()
                .post(_self.data('url'), { type: _self.data('type') })
                .then(({ data }) => Apps.showSuccess(data.message))
                .finally(() => Apps.hideButtonLoading(_self))
        })
    }
}

$(() => {
    new CacheManagement().init()
})
