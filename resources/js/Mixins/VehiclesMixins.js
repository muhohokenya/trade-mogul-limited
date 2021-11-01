export default {

    methods:{
        fetchVehicles() {
            let url = base_url + 'vehicles'
            return axios.get(url).then(response => {
                return response
            }).catch(error => {
                return  error.response.data.errors
            })
        },

        fetchAvailableVehicles() {
            let url = base_url + 'vehicles/available'
            return axios.get(url).then(response => {
                return response
            }).catch(error => {
                return  error.response.data.errors
            })
        },
        markVehicleLoading(vehicle) {
            let url = base_url + 'vehicles/mark_loading'
            let data = {
                vehicle:vehicle.id
            };
            return axios.post(url,data).then(response => {
                return response
            }).catch(error => {
                return  error.response.data.errors
            })
        },

        markVehicleOnTransit(vehicle) {
            let url = base_url + 'vehicles/mark_on_transit'
            let data = {
                vehicle:vehicle.id
            };
            return axios.post(url,data).then(response => {
                return response
            }).catch(error => {
                return  error.response.data.errors
            })
        },

        markVehicleAvailable(vehicle) {
            let url = base_url + 'vehicles/mark_available'
            let data = {
                vehicle:vehicle.id
            };
            return axios.post(url,data).then(response => {
                return response
            }).catch(error => {
                return  error.response.data.errors
            })
        },

        delete(vehicle) {
            let url = base_url + 'vehicles/delete/'+vehicle.id
            return axios.delete(url).then(response => {
                return response
            }).catch(error => {
                return  error.response.data.errors
            })
        }
    }
}
