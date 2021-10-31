export default {

    methods:{
        fetchVehicles() {
            let url = base_url + 'vehicles'
            return axios.get(url).then(response => {
                return response
            }).catch(error => {
                return  error.response.data.errors
            })
        }
    }
}
