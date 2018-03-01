<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card card-default">
                    <div class="card-header">Exit Parking Lot</div>

                    <div class="container">
                        <div v-if="error" class="alert alert-danger">
                            {{ error }}
                        </div>

                        <div v-if="success" class="alert alert-success">
                            {{ success }}
                        </div>
                    </div>

                    <div class="card-body">
                        <form method="post" action="/parking/exit" @submit.prevent="onSubmit">

                            <div class="form-group row">
                                <label for="ticket_number" class="col-md-4 col-form-label text-md-right">Ticket Number</label>

                                <div class="col-md-6">
                                    <input v-model="ticketNumber" type="number" id="ticket_number" name="ticket_number" class="form-control" required>
                                    <span v-show="errorTicket" class="alert-danger">
                                        <strong>{{ errorTicket }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="pin" class="col-md-4 col-form-label text-md-right">PIN</label>

                                <div class="col-md-6">
                                    <input v-model="pin" type="text" id="pin" name="pin" class="form-control" required>
                                    <span v-show="errorPin" class="alert-danger">
                                        <strong>{{ errorPin }}</strong>
                                    </span>
                                </div>


                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button class="btn btn-primary" v-if="!isDone">
                                        Exit Parking Lot
                                    </button>
                                    <router-link v-if="isDone" tag="div" to="/" class="form-group">
                                        <button class="btn btn-info">Back to Home</button>
                                    </router-link>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "exit",
        data() {
            return {
                ticketNumber: '',
                pin: '',
                error: '',
                success: '',
                errorPin: '',
                errorTicket: '',
                isDone: false
            }
        },
        methods: {
            onSubmit() {
                this.errorPin = '';
                this.errorTicket = '';
                axios.post('/parking/exit', {
                    ticket_number: this.ticketNumber,
                    pin: this.pin
                })
                    .then(({data}) => this.processExit(data))
                    .catch(error => this.processErrors(error.response.data));
            },
            processExit(data) {
                if (data.hasOwnProperty('success')) {
                    this.isDone = true;
                    this.success = data.success;
                }
                else if (data.hasOwnProperty('error')) {
                    this.error = data.error;
                }
            },
            processErrors(data) {
                if (data.errors.hasOwnProperty('ticket_number')) {
                    this.errorTicket = data.errors.ticket_number[0];
                }
                if (data.errors.hasOwnProperty('pin')) {
                    this.errorPin = data.errors.pin[0];
                }
            }
        }
    }
</script>

<style scoped>

</style>