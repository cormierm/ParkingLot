<template>
    <div class="container">
        <h2>Vehikl Parking Ticket</h2>
        <div class="alert alert-info" v-if="message">
            {{ message }}
        </div>
        <p>
            Time In: {{ ticket.created_at }}<br>
            Ticket number: <strong>{{ ticket.id }}</strong><br>
            Your PIN*: <strong>{{ ticket.pin }}</strong><br>
            * This is required for payment and exiting parking lot
        </p>
        <a href="/" class="btn btn-primary">Back to Main Page</a>
    </div>
</template>

<script>
    import PaymentDetails from '../components/PaymentDetails';

    export default {
        components: { PaymentDetails },
        data() {
            return {
                ticket: {},
                message: ''
            }
        },
        name: "ticket",
        methods: {
            createTicket() {
                axios.post('/api/ticket/create')
                    .then(({data}) => this.processCreateTicket(data));
            },
            processCreateTicket(data) {
                if (data.hasOwnProperty('ticket')) {
                    this.ticket = data.ticket;
                }
                if (data.hasOwnProperty('message')) {
                    this.message = data.message;
                }
            }
        },
        mounted() {
            this.createTicket();
        }
    }

</script>

<style scoped>

</style>