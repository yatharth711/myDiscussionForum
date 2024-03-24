function validatePost(){
    var title=document.create_post.title;
    var comm= document.create_post.community;

    //check if title is empty
    if(title===""){
        title.classList.add("error"); //add error class to title and add css
        title.focus();
        return false;
    }else{
        title.classList.remove("error");
    }

    //check if community is empty
    if(comm===""){
        comm.classList.add("error");//add error class to community
        comm.focus();
        return false;
    }else{
        comm.classList.remove("error");
    }
    return true;
}