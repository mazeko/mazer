import { getCookie } from "../function.js";

export const appKey = "ZW5rdWRhdmlAZ21haWwuY29tOkthcmFuOXN1d3VuOSM="
export const bearerToken = getCookie("authToken")
if(!bearerToken){
    window.location.href = '/error'; 
}else{
    document.getElementsByTagName("html")[0].style.visibility = "visible";
}