const searchBar = document.querySelector(".search input"),
searchIcon = document.querySelector(".search button"),
allUsers = document.querySelector(".all_users");

searchBar.onkeyup = ()=>{
    let searchOn = searchBar.value;
    if(searchOn != ""){
        searchBar.classList.add("active");
    }else{
        searchBar.classList.remove("active");
    }
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/search.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                allUsers.innerHTML = data;
            }
        }
    }
    xhr.setRequestHeader("content-type", "application/x-www-form-urlencoded");
    xhr.send("searchOn=" + searchOn);

}
setInterval(() =>{
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "php/home.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE){
            if(xhr.status === 200){
                let data = xhr.response;
                if(!searchBar.classList.contains("active")){
                allUsers.innerHTML = data;
                }
            }
        }
    }
    xhr.send();
}, 500);