import VehiclesMixins from "../../../Mixins/VehiclesMixins";
import {ListLoader} from "vue-content-loader";
export default {
    name: "Vehicles",
    mixins:[
        VehiclesMixins
    ],

    components:{
        ListLoader
    },

    data() {
        return {
            errors: '',
            saving: false,
            loading: false,
            updating: false,
            edit_form:{
                edit_vehicle:'',
                vehicle_id:'',
            },
            vehicles: [],
            vehicle_status: {
                available: 'Available',
                loading: 'Loading',
                on_transit: 'on_transit',
            },
            form: {
                reg_no: '',
            }
        }
    },

    created() {

    },

    mounted() {
        this.getVehicles()
    },


    methods: {
        makeVehicleAvailable(vehicle){
            this.markVehicleAvailable(vehicle).
            then(response=>{
                this.getVehicles()
                this.$notify({
                    title:'Available'
                })
            }).catch(error=>{

            });
        },
        deleteVehicle(vehicle){
            this.$swal({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.delete(vehicle).then(response=>{
                        this.getVehicles()
                        this.$swal(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }).catch(error=>{

                    })

                }
            })
        },
        markLoading(vehicle){
            this.markVehicleLoading(vehicle).then(response=>{
                this.getVehicles()
            }).catch(error=>{});
        },

        markOnTransit(vehicle){
            this.markVehicleOnTransit(vehicle).then(response=>{
                this.getVehicles()
            }).catch(error=>{});
        },

        markAvailable(vehicle){
            this.markVehicleAvailable(vehicle).then(response=>{
                this.getVehicles()
            }).catch(error=>{});
        },
        setVehicle(vehicle){
            this.edit_form.edit_vehicle = vehicle.reg_no
            this.edit_form.vehicle_id = vehicle.id
        },
        getVehicles() {
            this.loading = true;
            this.fetchVehicles().then(response => {
                this.vehicles = response.data
                this.loading = false
            }).catch(error => {
                this.loading = false
                this.errors = error.response.data.errors
            })
        },
        addVehicle() {
            this.saving = true
            let url = base_url + 'vehicles'
            axios.post(url, this.form).then(response => {
                this.vehicles.push(response.data)
                this.saving = false
                this.form.reg_no = ''
                $("#addDepotModal").modal('hide');
            }).catch(error => {
                this.errors = error.response.data.errors
                this.saving = false
            })
        },
        updateVehicle(){
            this.updating = true
            let url = base_url + 'vehicles/'+this.edit_form.vehicle_id
            axios.put(url, this.edit_form).then(response => {
                this.updating = false
                let index = this.vehicles.findIndex(x => x.id ===this.edit_form.vehicle_id);
                this.vehicles.splice(index, 1);
                this.vehicles.push(response.data)
                $("#editModal").modal('hide');
            }).catch(error => {
                this.errors = error.response.data.errors
                this.updating = false
            })
        },
    },
}
