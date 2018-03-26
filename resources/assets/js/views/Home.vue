<template>
    <div class="container">
        <div class="container col-md-7">
            <br>
            <div class="card card-default">
                <div class="card-header">Parking Lot Status</div>
                <div class="card-body">
                    <p v-if="availableSpaces > 0 && isRefreshed">
                        There is currently {{ availableSpaces }} parking spaces available.
                    </p>
                    <p v-if="availableSpaces < 1 && isRefreshed">
                        PARKING LOT IS FULL
                    </p>
                    <button @click="checkStatus" class="btn btn-info">Refresh Availability</button>
                </div>
            </div>

        </div>
        <br>
        <div class="container border col-md-6">
            <br>

            <router-link v-if="availableSpaces > 0" tag="div" to="/ticket" class="form-group">
                <button class="btn btn-primary btn-lg btn-block">Enter Parking Lot</button>
            </router-link>

            <router-link v-if="availableSpaces < 1" tag="div" to="/waitlist" class="form-group">
                <button class="btn btn-primary btn-lg btn-block">Enter Waiting List</button>
            </router-link>

            <router-link tag="div" to="/waitlistEntrance" class="form-group">
                <button class="btn btn-info btn-lg btn-block">Wait List Entrance</button>
            </router-link>

            <router-link tag="div" to="/ticket/pay" class="form-group">
                <a class="btn btn-danger btn-lg btn-block"><span class="glyphicons-stop-sign"></span>Pay Ticket</a>
            </router-link>

            <router-link tag="div" to="/exit" class="form-group">
                <button class="btn btn-primary btn-lg btn-block">Exit Parking Lot</button>
            </router-link>
        </div>

    </div>


</template>

<script>
    export default {
        name: "home",
        data() {
            return {
                availableSpaces: 5,
                isRefreshed: false
            }
        },
        methods: {
            checkStatus() {
                axios.get('/api/ticket/status')
                    .then(({data}) => {
                        this.availableSpaces = data.available;
                        this.isRefreshed = true;
                    });
            }
        },
        created() {
            this.checkStatus();
            setInterval(() => {
                this.checkStatus();
            }, 20000);
        }
    }
</script>

<style scoped>

</style>