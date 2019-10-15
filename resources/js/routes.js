import AdminHome from './components/admin/ExampleComponent.vue'
import AllUsers from './components/admin/user/List.vue'
import NewUser from './components/admin/user/New.vue'
import AllRoles from './components/admin/roles/list.vue'
import NewRole from './components/admin/roles/new.vue'
import Accounting from './components/admin/account/List.vue'
import Company from './components/admin/account/Company.vue'
import Media from './components/admin/Media.vue'

export const routes = [
    {
        path:'/',
        name:'home',
        component:AdminHome
    },
    {
        path:'/users',
        name:'all-users',
        component:AllUsers,
        beforeEnter(to,from,next){
            auth.routeCheck(to,from,next,'view user')
        }
    },
    {
        path:'/new-user',
        name:'new-user',
        component:NewUser,
        beforeEnter(to,from,next){
            auth.routeCheck(to,from,next,'create user')
        }
    },
    {
        path:'/roles',
        name:'roles',
        component:AllRoles,
        beforeEnter(to,from,next){
            auth.routeCheck(to,from,next,'view role')
        }
    },
    {
        path:'/new-role',
        name:'new-role',
        component:NewRole,
        beforeEnter(to,from,next){
            auth.routeCheck(to,from,next,'create role')
        }
    },
    {
        path:'/account',
        name:'accounting',
        component:Accounting,
        beforeEnter(to,from,next){
            auth.routeCheck(to,from,next,'view company')
        }
    },
    {
        path:'/media',
        name:'media',
        component:Media,
        beforeEnter(to,from,next){
            auth.routeCheck(to,from,next,'view file')
        }
    },
    {
        path:'/company',
        name:'company',
        component:Company,
        props:true,
        beforeEnter(to,from,next){
            if(from.path=='/account')
            {
                auth.routeCheck(to,from,next,'view invoice')
            }else{
                next('/account')
            }
        }
    }
];


