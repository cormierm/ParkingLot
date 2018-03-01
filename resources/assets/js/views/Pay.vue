<template>
    <div class="container">
        <br>
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card card-default">
                    <div class="card-header">Pay Parking Ticket</div>

                    <div class="card-body">
                        <div v-if="error" class="alert alert-danger">
                            {{ error }}
                        </div>
                        <form method="post" action="/payment/pay" @submit.prevent="onSubmit">

                            <div class="form-group row">
                                <label for="ticket_number" class="col-md-4 col-form-label text-md-right">Ticket Number</label>

                                <div class="col-md-6">
                                    <input v-model="ticketNumber" type="number" id="ticket_number" name="ticket_number"
                                           class="form-control" required :disabled="is_valid">
                                    <span v-show="errorTicket" class="alert-danger">
                                        <strong>{{ errorTicket }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="pin" class="col-md-4 col-form-label text-md-right">PIN</label>

                                <div class="col-md-6">
                                    <input v-model="pin" type="text" id="pin" name="pin" class="form-control"
                                           required :disabled="is_valid">
                                    <span v-show="errorPin" class="alert-danger">
                                        <strong>{{ errorPin }}</strong>
                                    </span>
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button class="btn btn-primary" :disabled="is_valid">
                                        Pay Ticket
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <payment-details v-if="is_valid" :details="data"></payment-details>
    </div>
</template>

<script>
    import PaymentDetails from '../components/PaymentDetails';

    export default {
        components: { PaymentDetails },
        name: "pay",
        data() {
            return {
                error: '',
                message: '',
                ticketNumber: '',
                pin: '',
                is_valid: false,
                details: {},
                errorTicket: '',
                errorPin: ''
            }
        },
        methods: {
            onSubmit() {
                this.errorPin = '';
                this.errorTicket = '';
                axios.post('/payment/details', {
                    ticket_number: this.ticketNumber,
                    pin: this.pin
                })
                    .then(({data}) => this.processDetails(data))
                    .catch(error => this.processErrors(error.response.data));
            },
            processDetails (data) {
                console.log(data);
                if (data.hasOwnProperty('error')) {
                    this.error = data.error;
                }
                else {
                    this.data = data;
                    this.is_valid = true;
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