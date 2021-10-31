<template>
    <main class="container">
        <section class="row">
            <div class="col">

                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(depot,index) in depots">
                        <td>{{index+=1}}</td>
                        <td>{{ depot.name }}</td>
                    </tr>
                    </tbody>
                </table>

                <hr>
                <!-- Button trigger modal -->
                <button @click="modalInit" type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#addDepotModal">
                    Add Depot
                </button>

                <!-- Modal -->
                <div class="modal fade" id="addDepotModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
                     aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="staticBackdropLabel">Add Depot</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form @submit.prevent="addDepot" autocomplete="off">
                                <div class="modal-body">

                                    <div class="form-group">
                                        <label for="name">Name</label>
                                        <input :class="{'is-invalid':errors.name}" v-model="form.name" type="text"
                                               class="form-control" id="name">
                                        <span v-if="errors.name"
                                              :class="{'text-danger':errors.name}">{{
                                                                    errors.name[0]
                                                                }}</span>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

            </div>
        </section>
    </main>
</template>

<script>
export default {
    name: "Depots",

    data() {
        return {
            errors: '',
            depots: [],
            saving: false,
            form: {
                name: ''
            }
        }
    },

    mounted() {
        this.fetchDepots();
    },

    methods: {
        modalInit(){
            $("#name").focus
        },
        addDepot() {
            this.saving = true
            let url = base_url + 'depots'
            axios.post(url, {
                name: this.form.name
            }).then(response => {
                this.depots.push(response.data)
                this.saving = false
                this.clearForm()
                $("#addDepotModal").modal('hide');
            }).catch(error => {
                this.errors = error.response.data.errors
                this.saving = false
            })
        },

        clearForm(){
            this.form.name = ''
        },

        fetchDepots() {
            let url = base_url + 'depots'
            axios.get(url).then(response => {
                this.depots = response.data
            }).catch(error => {
                this.errors = error.response.data.errors
            })
        }
    },
}
</script>

<style scoped>

</style>
