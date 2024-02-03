import { getCookie } from "../function.js";

const bearerToken = getCookie("authToken")
if(!bearerToken){
    window.location.href = '/error'; 
}else{
    document.getElementsByTagName("html")[0].style.visibility = "visible";
}