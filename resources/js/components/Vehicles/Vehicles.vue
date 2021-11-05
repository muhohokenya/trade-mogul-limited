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

                    <list-loader v-if="this.loading"></list-loader>
                    <table v-else class="table table-bordered">
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
<script src="../Vehicles/js/vehicles.js"></script>

<style scoped>
    #reg_no{
        text-transform: uppercase;
    }
</style>
