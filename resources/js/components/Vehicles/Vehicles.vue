<template>
    <main class="container">
        <section class="container">


            <div class="row">
                <div class="col">
                    <!-- Button trigger modal -->
                    <button type="button" class="btn btn-outline-primary" data-toggle="modal"
                            data-target="#addDepotModal">
                        Add Vehicle
                    </button>
                </div>
            </div>

            <div class="row mt-5">


                <div class="col">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Reg No</th>
                                <th>Status</th>
                                <th>Orders</th>
                                <th colspan="4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(vehicle,index) in vehicles">
                            <td>{{index+=1}}</td>
                            <td>{{vehicle.reg_no}}</td>
                            <td>{{vehicle.vehicle_status}}</td>
                            <td>{{vehicle.orders.length}}</td>
                            <td>
                                <div v-if="vehicle.vehicle_status==='Available'">

                                    <div v-if="vehicle.orders.length">
                                        <button class="btn btn-outline-success" @click="markLoading(vehicle)">Mark Loading</button>
                                    </div>
                                    <div v-else>
                                        No Orders Assigned
                                    </div>

                                </div>
                                <div v-else-if="vehicle.vehicle_status==='Loading'">
                                    <button class="btn btn-outline-primary" @click="markOnTransit(vehicle)">Mark On Transit</button>
                                </div>
                                <div v-else-if="vehicle.vehicle_status==='On_transit'">
                                    <button class="btn btn-outline-primary" @click="makeVehicleAvailable(vehicle)">Make Available</button>
                                </div>
                            </td>


                            <td>
                                <!-- Button trigger modal -->
                                <button @click="setVehicle(vehicle)" type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
                                    Edit
                                </button>
                            </td>
                            <td>
                                <button v-if="vehicle.orders.length===0" class="btn btn-outline-danger" @click="deleteVehicle(vehicle)">Delete</button>
                                <button v-else class="btn btn-danger" disabled>Delete</button>
                            </td>
                        </tr>
                        </tbody>
                    </table>



                    <!-- Modal -->
                    <div class="modal fade" id="editModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="editBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editBackdropLabel">Edit Vehicle</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form @submit.prevent="updateVehicle">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="edit_reg_no">Reg No</label>
                                            <input :class="{'is-invalid':errors.reg_no}" v-model="edit_form.edit_vehicle"
                                                   type="text"
                                                   class="form-control" id="edit_reg_no">
                                            <span v-if="errors.reg_no"
                                                  :class="{'text-danger':errors.reg_no}">{{
                                                    errors.reg_no[0]
                                                }}</span>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button v-if="updating" class="btn btn-primary" type="button" disabled>Updating...</button>
                                        <button v-else type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>




                    <!-- Modal -->
                    <div class="modal fade" id="addDepotModal" data-backdrop="static" data-keyboard="false"
                         tabindex="-1"
                         aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="staticBackdropLabel">Add Vehicle</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form @submit.prevent="addVehicle" autocomplete="off">
                                    <div class="modal-body">

                                        <div class="form-group">
                                            <label for="reg_no">Reg No</label>
                                            <input :class="{'is-invalid':errors.reg_no}" v-model="form.reg_no"
                                                   type="text"
                                                   class="form-control" id="reg_no">
                                            <span v-if="errors.reg_no"
                                                  :class="{'text-danger':errors.reg_no}">{{
                                                                    errors.reg_no[0]
                                                                }}</span>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close
                                        </button>
                                        <button v-if="saving" class="btn btn-primary" type="button" disabled>
                                        <span class="spinner-border spinner-border-sm" role="status"
                                              aria-hidden="true"></span>
                                            Loading...
                                        </button>
                                        <button v-else type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <notifications/>

                </div>
            </div>
        </section>
    </main>
</template>

<script>
import VehiclesMixins from "../../Mixins/VehiclesMixins";

export default {
    name: "Vehicles",
    mixins:[
        VehiclesMixins
    ],

    data() {
        return {
            errors: '',
            saving: false,
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
            this.fetchVehicles().then(response => {
                this.vehicles = response.data
            }).catch(error => {
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
</script>

<style scoped>
    #reg_no{
        text-transform: uppercase;
    }
</style>
