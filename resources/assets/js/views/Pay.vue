<template>
    <div class="container">
        <br>
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card card-default">
                    <div class="card-header">Pay Parking Ticket</div>

                    <div class="card-body">
                        <alert-message :error="error"></alert-message>
                        <form method="post" action="/payment/pay" @submit.prevent="onSubmit">

                            <div class="form-group row">
                                <label for="ticket_number" class="col-md-4 col-form-label text-md-right">Ticket Number</label>

                                <div class="col-md-6">
                                    <input v-model="ticketNumber" type="number" id="ticket_number" name="ticket_number"
                                           class="form-control" required :disabled="isValid">
                                    <span v-show="formErrors.ticketNumber" class="alert-danger">
                                        <strong>{{ formErrors.ticketNumber }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="pin" class="col-md-4 col-form-label text-md-right">PIN</label>

                                <div class="col-md-6">
                                    <input v-model="pin" type="text" id="pin" name="pin" class="form-control"
                                           required :disabled="isValid">
                                    <span v-show="formErrors.pin" class="alert-danger">
                                        <strong>{{ formErrors.pin }}</strong>
                                    </span>
                                </div>
                            </div>


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button class="btn btn-primary" :disabled="isValid">
                                        Pay Ticket
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <payment-details v-if="isValid" :details="data"></payment-details>
    </div>
</template>

<script>
    import PaymentDetails from '../components/PaymentDetails';
    import AlertMessage from '../components/AlertMessage';

    export default {
        components: { PaymentDetails, AlertMessage },
        name: "pay",
        data() {
            return {
                error: '',
                message: '',
                ticketNumber: '',
                pin: '',
                isValid: false,
                details: {},
                formErrors: { 'ticketNumber': '', 'pin': ''}
            }
        },
        methods: {
            onSubmit() {
                this.error = '';
                this.message = '';
                this.formErrors.ticketNumber = '';
                this.formErrors.pin = '';
                axios.post('/api/payment/details', {
                    ticket_number: this.ticketNumber,
                    pin: this.pin
                })
                    .then(({data}) => this.processDetails(data))
                    .catch(error => this.processErrors(error.response));
            },
            processDetails (data) {
                if (data.hasOwnProperty('error')) {
                    this.error = data.error;
                }
                else {
                    this.data = data;
                    this.isValid = true;
                }
            },
            processErrors(data) {
                if (data.status = 401) {
                    this.error = data.data.error;
                }
                if (data.status = 422 && data.data.errors.hasOwnProperty('ticket_number')) {
                    this.formErrors.ticketNumber = data.data.errors.ticket_number[0];
                }
                if (data.status = 422 && data.data.errors.hasOwnProperty('pin')) {
                    this.formErrors.pin = data.data.errors.pin[0];
                }


            }
        }
    }
</script>

<style scoped>

</style>