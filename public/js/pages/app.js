import '../axios.min.js'
import { getCookie } from "../function.js";

export const appKey = "ZW5rdWRhdmlAZ21haWwuY29tOkthcmFuOXN1d3VuOSM="
export const bearerToken = getCookie("authToken")
export const headers = {
    "MEZER-KEY": appKey,
    "Authorization": `Bearer ${bearerToken}`
}

if(!bearerToken){
    window.location.href = '/'; 
}else{
    axios.get("/api/v1/auth/check-token", {
        headers: {
            "MEZER-KEY": appKey,
            "Authorization": `Bearer ${bearerToken}`
        }
    }).then(response => {
        document.getElementsByTagName("html")[0].style.visibility = "visible";
    }).catch(error => {
        if(error.response.status == 401){
            window.location.href = '/'; 
        }
    })
}