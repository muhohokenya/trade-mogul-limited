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
