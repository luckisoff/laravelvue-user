<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-around">
                <!-- left column -->
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Add New Role</h3>
                        </div>
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form role="form" v-on:submit.prevent="addRole()" method="POST">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="roleId">Role Name</label>
                                    <input type="text" class="form-control" id="roleId" placeholder="Add New Role" v-model="form.name" name="name" :class="{ 'is-invalid': form.errors.has('name') }">
                                    <has-error :form="form" field="name"></has-error>
                                </div>

                                <div class="form-group">

                                    <label for="permissionId">Permissions: </label>
                                    <input type="checkbox" v-on:click.prevent="selectAll()" v-model="all_select">
                                    <div v-for="(permission) in getAllPermissions" :key="permission.id">
                                      <input type="checkbox" v-model="form.permissionItem" :value="permission.id" name="permissionItem">{{permission.name}}
                                    </div>

                                </div>

                            </div>
                            <!-- /.card-body -->

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
                    permissionItem:[],
                }),
                select:'',
                all_select:false
            }
        },

        mounted(){
            this.$store.dispatch("getAllPermissions")
        },
        computed:{
           getAllPermissions(){
            return this.$store.getters.getAllPermissions
           }
        },
        methods:{
            addRole(){
                 this.form.post('/add-role')
                    .then((response)=>{
                        this.$router.push('/roles')
                        toast.fire({
                            type: 'success',
                            title: 'Role Added successfully'
                        })
                    })
                    .catch(()=>{

                    })

                },
                selectAll(){
                    if(this.all_select==false){
                        this.all_select = true
                        for(var permission in this.getAllPermissions){

                            this.form.permissionItem.push(this.getAllPermissions[permission].id)
                        }
                    }else{
                        this.all_select = false
                        this.form.permissionItem = []
                    }
                }
        }
}
</script>

<style scoped>

</style>
