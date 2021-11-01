<template>
    <main class="container">
        <section class="row">
            <div class="col">
                <ul class="nav nav-pills nav-fill navbar-light">
                    <li class="nav-item">
                        <a class="nav-link active" @click.prevent="fetchOrders" href="#">All Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" @click.prevent="getLoadingOrders">Loading Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" @click.prevent="getDispatchedOrders">Dispatched Orders</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" @click.prevent="getPendingOrders">Pending Orders</a>
                    </li>
                </ul>
            </div>
        </section>
        <section class="row mt-5">
            <div class="col">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Date Ordered</th>
                        <th>Order Status</th>
                        <th>Vehicle Allocated</th>
                        <th colspan="4">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(order,index) in orders">
                        <td>{{ index+=1}}</td>
                        <td>{{ order.item}}</td>
                        <td>{{ moment(order.created_at).format('MMMM Do YYYY, h:mm:ss a') }}</td>
                        <td>{{ order.order_status}}</td>
                        <td>
                            <span v-if="order.vehicle">{{ order.vehicle.reg_no}}</span>
                            <span v-else>Not Allocated</span>
                        </td>
                        <td>
                            <!-- Button trigger modal -->
                            <button v-if="order.order_status==='pending'" @click="allocateToVehicle(order)" type="button" class="btn btn-outline-primary"
                                    data-toggle="modal" data-target="#staticBackdrop">
                                Allocate to vehicle
                            </button>
                            <button v-else class="btn btn-success" disabled >Allocated</button>
                        </td>
                        <td>

                            <div v-if="order.order_status!=='pending'">
                                <button v-if="order.order_status==='loading' && order.order_status!=='dispatched'" class="btn btn-outline-success" @click="markDispatched(order)">Mark Dispatched</button>
                                <button v-else disabled class="btn btn-success">Dispatched</button>
                            </div>
                            <div v-else>
                                <button  class="btn btn-outline-info" disabled>Not Allocated</button>
                            </div>

                        </td>
                        <td>
                            <div v-if="order.order_status==='dispatched' && order.order_status!=='delivered'">
                                <button class="btn btn-outline-primary" @click="markDelivered(order)">Mark Delivered</button>

                            </div>
                            <div v-else-if="order.order_status==='delivered'">
                                <button class="btn btn-success" disabled>Delivered</button>
                            </div>
                            <div v-else>
                                Not Delivered
                            </div>


                        </td>

                    </tr>
                    </tbody>
                </table>


                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1"
                     aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Allocate Order to a vehicle</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit.prevent="allocate">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="order">Order</label>
                                        <input type="text" class="form-control" v-model="allocate_form.order_item"
                                               readonly>
                                    </div>

                                    <div class="form-group">
                                        <label for="vehicle">Select Vehicle</label>
                                        <select v-model="allocate_form.vehicle" name="vehicle" id="vehicle"
                                                class="form-control">
                                            <option v-for="vehicle in vehicles" :value="vehicle.id">
                                                {{vehicle.reg_no}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button @click="clearForm" type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Close
                                    </button>
                                    <button type="submit" class="btn btn-primary">Allocate</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </section>
    </main>
</template>

<script>
import Moment from 'moment'
import VehiclesMixins from "../../Mixins/VehiclesMixins";
import OrderMixins from "../../Mixins/OrderMixins";

export default {
    name: "Orders",
    mixins: [
        VehiclesMixins,
        OrderMixins
    ],


    data() {
        return {
            orders: [],
            vehicles: [],
            order: '',
            moment: '',
            submitting: false,
            allocate_form: {
                vehicle: '',
                order_id: '',
                order_item: '',
            }
        }
    },
    created() {
        this.moment = Moment;
    },
    mounted() {
        this.fetchOrders()

        //Reusable Method from the Mixins
        this.fetchAvailableVehicles().then(response => {
            this.vehicles = response.data
        })
    },

    methods: {
        getLoadingOrders(){
            this.fetchLoadingOrders().then(response=>{
                this.orders = response.data
            }).catch(error=>{})
        },

        getDispatchedOrders(){
            this.fetchDispatchedOrders().then(response=>{
                this.orders = response.data
            }).catch(error=>{})
        },

        getPendingOrders(){
            this.fetchPendingOrders().then(response=>{
                this.orders = response.data
            }).catch(error=>{})
        },
        markDispatched(order){
            let url = base_url+'orders/mark_order_dispatched'
            let data = {
                order:order.id
            }
            axios.post(url,data).
            then(response=>{
                this.fetchOrders()
            }).catch(error=>{});
        },
        markDelivered(order){
            let url = base_url+'orders/mark_order_delivered'
            let data = {
                order:order.id
            }
            axios.post(url,data).
            then(response=>{
                this.fetchOrders()
            }).catch(error=>{});
        },
        allocate() {
            this.submitting = true
            let url = base_url+'orders/allocate'
            let data = {
                vehicle:this.allocate_form.vehicle,
                order_id:this.allocate_form.order_id
            }
            axios.post(url,data)
            .then(response=>{
                this.fetchOrders()
                $("#staticBackdrop").modal('hide');
            })
            .catch(error=>{

            })
        },
        clearForm() {
            this.order = ''
            this.allocate_form.vehicle = ''
            this.allocate_form.order_id = ''
            this.allocate_form.order_item = ''
        },
        allocateToVehicle(order) {
            this.order = order
            this.allocate_form.order_id = order.id
            this.allocate_form.order_item = order.item
        },
        fetchOrders() {
            let url = base_url + 'orders'
            axios.get(url)
                .then(response => {
                    this.orders = response.data
                }).catch(error => {

            })
        },
    },
}
</script>

<style scoped>

</style>
