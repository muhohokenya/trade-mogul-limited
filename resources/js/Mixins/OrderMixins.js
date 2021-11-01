export default {

    methods:{
        fetchOrders() {
            let url = base_url + 'orders'
            return axios.get(url).then(response => {
                return response
            }).catch(error => {
                return  error.response.data.errors
            })
        },

        fetchLoadingOrders() {
            let url = base_url + 'orders/loading'
            return axios.get(url).then(response => {
                return response
            }).catch(error => {
                return  error.response.data.errors
            })
        },

        fetchDispatchedOrders() {
            let url = base_url + 'orders/dispatched'
            return axios.get(url).then(response => {
                return response
            }).catch(error => {
                return  error.response.data.errors
            })
        },

        fetchPendingOrders() {
            let url = base_url + 'orders/pending'
            return axios.get(url).then(response => {
                return response
            }).catch(error => {
                return  error.response.data.errors
            })
        }
    }
}
