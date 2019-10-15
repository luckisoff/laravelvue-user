export default {
    state:{
        user:[],
        role:[],
        permission:[],
        companies:[]
    },

    getters:{
        getAllUser(state){
            return state.user
        },

        getAllCompanies(state){
            return state.companies
        },

        getAllRoles(state){
            return state.role
        },

        getAllPermissions(state){
            return state.permission
        }

    },

    actions:{


        getAllCompanies(context){
            nprogress.start()
            axios.get('/company')
                .then(response=>{
                    nprogress.done()
                    context.commit('companies',response.data)
                }).catch(error=>{
                    console.log(error.response)
                    toast.fire({
                        position:'center',
                        type:'error',
                        title:'Sorry! Something went wrong.'
                    })
                })
        },
        getAllUser(context){
            nprogress.start()
            axios.get('/users')
                .then((response)=>{
                    nprogress.done()
                    context.commit('users',response.data.users)
                }).catch(error=>{
                    toast.fire({
                        position:'center',
                        type:'warning',
                        interval:5000,
                        title:error.response.data.message
                    })
                })
        },

        getAllRoles(context){
            axios.get('/roles')
            .then(response=>{
                context.commit('roles',response.data.roles)
            })
        },

        getAllPermissions(context){
            nprogress.start()
            axios.get('/permission')
            .then(response=>{
                nprogress.done()
                context.commit('permissions',response.data.permissions)
            })
        }

    },

    mutations:{

        companies(state,data){
            state.companies=data
        },
        users(state,data){
            state.user=data
        },

        roles(state,data){
            state.role=data
        },
        permissions(state,data){
            state.permission=data
        },


    }
}
