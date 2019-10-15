export default class Auth{

    constructor(user){
        this.user=user
    }

    roles(){
        return this.user.roles.map(role=>role.name);
    }

    permissions(){
        return this.user.permissions.map(permission=>permission.name);
    }

    hasAnyPermission(){
        return this.user.permissions.length>0?true:false
    }

    isAdmin(){
        return this.roles().includes("Admin");
    }

    can($permissionName){
        return this.permissions().includes($permissionName);
    }

    routeCheck(to,from,next,permission){
        if(auth.can(permission)){
            next()
        }else{
            toast.fire({
                type:'warning',
                position:'center',
                title:'Sorry! Restricted area!'
            })
            next(from.path)
        }
    }
}
