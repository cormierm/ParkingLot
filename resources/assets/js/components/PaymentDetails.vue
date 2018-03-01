<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Payment Details</div>

                    <div v-if="error" class="alert alert-danger">
                        {{ error }}
                    </div>
                    <div v-if="success" class="alert alert-success">
                        {{ success }}
                    </div>
                    Ticket Number: {{ details.ticket.id }} <br>
                    Time in: {{ details.timeIn }} <br>
                    Time out: {{ details.timeOut }} <br>
                    Parking time in minutes: {{ details.totalTime }} <br>
                    Amount due: ${{ details.amountDue }} <br>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button @click="sendPayment" class="btn btn-danger" v-if="!isPaid">
                                Pay Ticket
                            </button>
                            <router-link v-if="isPaid" tag="div" to="/" class="form-group">
                                <button class="btn btn-info">Back to Home</button>
                            </router-link>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "payment-details",
        props: ['details'],
        data() {
            return {
                error: '',
                success: '',
                isPaid: false
            }
        },
        methods: {
            sendPayment() {
                axios.post('/payment/pay', {
                    ticket_number: this.details.ticket.id
                })
                    .then(({data}) => this.processPayment(data));
            },
            processPayment(data) {
                console.log(data);
                if(data.hasOwnProperty('error')) {
                    this.error = data.error;
                }
                if (data.hasOwnProperty('success')) {
                    this.isPaid = true;
                    this.success = data.success;
                }
            }
        }
    }
</script>

<style scoped>

</style>