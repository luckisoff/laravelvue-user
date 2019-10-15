<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-around">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add New User</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" v-on:submit.prevent="addUser()" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="name" class="form-control" id="name" placeholder="Full Name" v-model="form.name" name="name" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error>
                                </div>


                                <div class="form-group">
                                    <label for="email">Email Address</label>
                                    <input type="email" class="form-control" id="email" placeholder="Valid Email Address" v-model="form.email" name="email" :class="{ 'is-invalid': form.errors.has('email') }">
                                    <has-error :form="form" field="email"></has-error>
                                </div>

                                <div class="form-group">
                                    <label for="roleId">Password</label>
                                    <input type="password" class="form-control" id="password" placeholder="password" v-model="form.password" name="password" :class="{ 'is-invalid': form.errors.has('password') }">
                                    <has-error :form="form" field="password"></has-error>
                                </div>

                                <div class="form-group">
                                    <label for="password_confirmation">Password Agaim</label>
                                    <input type="password" class="form-control" id="password_confirmation" placeholder="Password Again" v-model="form.password_confirmation" name="password_confirmation" :class="{ 'is-invalid': form.errors.has('password_confirmation') }">
                                    <has-error :form="form" field="password_confirmation"></has-error>
                                </div>

                                <div class="form-group">
                                    <label for="role">Select Role</label>
                                    <select id="role"  name="role" class="form-control" v-model="form.role">
                                        <option  v-for="(role) in getAllRoles" :key="role.id"  :value="role.id">{{role.name}}</option>
                                    </select><br>
                                </div>

                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->

                </div>

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
</template>

<script>
    export default {
        name: "new",
        data(){
            return {
                form: new Form({
                    name:'',
                    email:'',
                    password:'',
                    password_confirmation:'',
                    role:''
                }),
            }
        },

        mounted(){
            this.$store.dispatch("getAllRoles")
        },
        computed:{
           getAllRoles(){
            return this.$store.getters.getAllRoles
           }
        },
        methods:{
            addUser(){
                 axios.post('/new-user',this.form)
                    .then((response)=>{
                        console.log(response.data)
                        this.$router.push('/')
                        toast({
                            type: 'success',
                            title: 'Role Added successfully'
                        })
                    })
                    .catch((error)=>{
                        console.log(error.response);
                    })

                }
        }
}
</script>

<style scoped>

</style>

