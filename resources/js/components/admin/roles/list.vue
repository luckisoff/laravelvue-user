<template>
         <section class="content" >
            <div class="row justify-content-around" >
                <div class="col-12 ">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Roles List
                                <router-link v-if="$auth.can('create role')" to="/new-role" style="color:#fff">
                                    <span class="btn btn-primary btn-sm">+</span>
                                </router-link>
                            </h3>

                        </div>

                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>
                                        <select name="" id="" v-model="select" @change="deleteSelected">
                                            <option value="">Select</option>
                                            <option value="">Delete all</option>
                                        </select>
                                        <input type="checkbox" @click.prevent="selectAll" v-model="all_select">
                                        <span v-if="all_select==false">Check All</span>
                                        <span class="phabicon phabicon-delete" v-else>Uncheck All</span>
                                    </th>
                                    <th>Sl</th>
                                    <th>Name</th>
                                    <th>Guard Name</th>
                                    <th>Actions</th>

                                </tr>
                                </thead>
                                <tbody>

                                <tr v-for="(role,index) in getAllRoles" :key="role.id">
                                    <td><input type="checkbox" v-model="roleItem" :value="role.id" ></td>
                                    <td>{{index+1}}</td>
                                    <td>{{role.name}}</td>
                                    <td>{{role.guard_name}}</td>
                                    <td>
                                        <a v-if="$auth.can('delete role')" href="" onClick="return " @click.prevent = "deleteRole(role.id)">Delete</a>
                                    </td>
                                </tr>
                                </tbody>


                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
</template>
<script>
    export default {
        name: "List",
        data(){
            return{
                roleItem:[],
                select:'',
                all_select:false
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
            deleteRole(id){
                confirm.fire({
                    title:'Are you sure?'
                }).then((result) => {
                    if (result.value) {
                       axios.get('/del-role/selected/'+id)
                        .then(()=>{
                            this.$store.dispatch("getAllRoles")
                            toast.fire(
                                'Deleted!',
                                'A role has been deleted.',
                                'success'
                            )
                        })
                        .catch(()=>{

                        })
                    }
                });




            },

            deleteSelected(){
                confirm.fire({
                    title:'Are you sure?'
                }).then((result) => {
                    if (result.value) {
                        axios.get('/del-role/selected/'+this.roleItem)
                        .then(()=>{
                        this.roleItem = []
                        this.$store.dispatch("getAllRoles")
                        toast.fire({
                            type: 'success',
                            title: 'Roles Deleted successfully'
                        })

                        })
                    }else{
                        this.all_select = false
                        this.roleItem = []
                    }
                });

            },
            selectAll(){
                if(this.all_select==false){
                    this.all_select = true
                    for(var role in this.getAllRoles){
                        this.roleItem.push(this.getAllRoles[role].id)
                    }
                }else{
                    this.all_select = false
                    this.roleItem = []
                }


            },

            confirm(){
                Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                if (result.value) {
                    Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                    )
                }
                })
            }
        }
    }
</script>

<style scoped>
</style>


