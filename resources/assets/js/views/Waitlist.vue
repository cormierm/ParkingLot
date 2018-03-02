<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">

                <div class="card card-default">
                    <div class="card-header">Enter Wait List</div>
                    <div class="card-body">
                        <alert-message :error="error" :success="success"></alert-message>

                        <form method="post" action="/waitlist" @submit.prevent="onSubmit">

                            <div class="form-group row">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                                <div class="col-md-6">
                                    <input v-model="email" type="text" id="email" name="email" class="form-control"
                                           required :disabled="isDone">
                                    <span v-show="formErrors.email" class="alert-danger">
                                        <strong>{{ formErrors.email }}</strong>
                                    </span>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name (Optional)</label>

                                <div class="col-md-6">
                                    <input v-model="name" type="text" id="name" name="name" class="form-control"
                                           :disabled="isDone">
                                    <span v-show="formErrors.name" class="alert-danger">
                                        <strong>{{ formErrors.name }}</strong>
                                    </span>
                                </div>


                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button class="btn btn-primary" v-if="!isDone">
                                        Enter Wait List
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
    import AlertMessage from '../components/AlertMessage';

    export default {
        components: { AlertMessage },
        name: "waitlist",
        data() {
            return {
                error: '',
                success: '',
                email: '',
                name: '',
                formErrors: { 'email': '', 'name': ''},
                isDone: false
            }
        },
        methods: {
            onSubmit() {
                this.formErrors.email = '';
                this.formErrors.name = '';
                this.error = '';
                axios.post('/api/waitlist', {
                    email: this.email,
                    name: this.name
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
                if (data.errors.hasOwnProperty('email')) {
                    this.formErrors.email = data.errors.email[0];
                }
                if (data.errors.hasOwnProperty('name')) {
                    this.formErrors.name = data.errors.name[0];
                }
            }
        }
    }
</script>

<style scoped>

</style>