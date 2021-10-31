<template>
    <main class="container">
        <section class="row">
            <div class="col">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Date Ordered</th>
                        <th>Order Status</th>
                        <th colspan="2">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(order,index) in orders">
                        <td>{{ index+=1}}</td>
                        <td>{{ order.item}}</td>
                        <td>{{ moment(order.created_at).format('MMMM Do YYYY, h:mm:ss a') }}</td>
                        <td>{{ order.order_status}}</td>
                        <td>
                            <!-- Button trigger modal -->
                            <button @click="allocateToVehicle(order)" type="button" class="btn btn-primary" data-toggle="modal" data-target="#staticBackdrop">
                                Allocate to vehicle
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>




                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="order">Order</label>
                                    <input type="text" class="form-control" v-model="allocate_form.order_item" readonly>
                                </div>

                            <div class="form-group">
                                <label for="vehicle">Select Vehicle</label>
                                <select v-model="allocate_form.vehicle" name="vehicle" id="vehicle" class="form-control">
                                    <option v-for="vehicle in vehicles" :value="vehicle.reg_no">{{vehicle.reg_no}}</option>
                                </select>
                            </div>
                            </div>
                            <div class="modal-footer">
                                <button @click="clearForm" type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Allocate</button>
                            </div>
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
export default {
    name: "Orders",
    mixins:[
        VehiclesMixins
    ],


    data(){
        return{
            orders:[],
            vehicles:[],
            order:'',
            moment:'',
            allocate_form:{
                vehicle:'',
                order_id:'',
                order_item:'',
            }
        }
    },
    created(){
        this.moment = Moment;
    },
    mounted() {
        this.fetchOrders()
        this.fetchVehicles().then(response=>{
            this.vehicles = response.data
        })
    },

    methods: {
        clearForm(){
            this.order = ''
            this.allocate_form.vehicle = ''
            this.allocate_form.order_id = ''
            this.allocate_form.order_item = ''
        },
        allocateToVehicle(order){
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
