export default {
	data() {
		return {
            quickStoreDetail: []
		}
	},
	methods: {
        redirectToStore(storeId = '') {
            var link = ''
            if(storeId != '' && typeof storeId == "number"){
                link = '/edit/' + storeId
            }
            window.location.href = "store" + link
        },
        getStoreInformations(storeId) {
            fetch('vue/getDashboardStore?storeId=' + storeId)
            .then(res => res.json())
            .then(res => {
                this.quickStoreDetail = res
            })

            let element = $("#store-modal")
            $(element).modal('show')
        },
	}

}
